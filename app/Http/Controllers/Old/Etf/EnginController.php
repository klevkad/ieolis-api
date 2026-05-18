<?php

namespace App\Http\Controllers\Old\Etf;

use App\Http\Controllers\Controller;
use App\Models\Old\Etf\Engin;
use App\Models\Old\Parc\Typengin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EnginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:enginfilter')->only('filter');
        $this->middleware('permission:enginpaginate')->only('paginate');
        $this->middleware('permission:enginindex')->only('index');
        $this->middleware('permission:engincreate')->only('store');
        $this->middleware('permission:enginshow')->only('show');
        $this->middleware('permission:enginupdate')->only('update');
        $this->middleware('permission:engindelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\Engin::class, 'engin');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        if( request()->has('type') )
        {
            if( request()->type == 'CAM' )
            {
                $req = Engin::orderBy('immatriculation','ASC')
                            ->where(function($query) {
                                $query->where('codetype','CAM')
                                    ->orWhere('codetype','TRR');
                            });

                if( request()->has('search') && request()->search != '' )
                {
                    $req->whereRaw("UPPER(immatriculation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                        ->limit(50);
                    return response()->json($req->get(), 200);
                }
            }
            else if( request()->type == 'REM' )
            {
                $req = Engin::orderBy('immatriculation','ASC')
                            ->where(function($query) {
                                $query->where('codetype','REM')
                                    ->orWhere('codetype','R20')
                                    ->orWhere('codetype','R40');
                            });

                if( request()->has('search') && request()->search != '' )
                {
                    $req->whereRaw("UPPER(immatriculation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                        ->limit(50);
                    return response()->json($req->get(), 200);
                }
            }
            else
            {
                $req = Engin::orderBy('idengin','ASC');

                if( request()->has('search') && request()->search != '' && (Str::startsWith(mb_strtoupper(request()->search),'CLI') || Str::startsWith(mb_strtoupper(request()->search),'LOCLI') ) )
                {
                    $req->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                        ->limit(50);
                    return response()->json($req->get(), 200);
                }
            }
        }

        return response()->json([], 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = Engin::with(['assurances','ois.operationtechniques','ois.pieces','sortiecarburants.piece','typengin','visitetechniques']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(immatriculation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('codetype',request()->statut);
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'immatriculation' => 'immatriculation',
            'dateacquis' => 'dateacquis',
            'code_fourn' => 'code_fourn',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Engin::orderBy('idengin','ASC')->paginate(request()->size), 200);
    }

    public function generateEnginQrCodeF(Engin $engin)
    {
        $path = Storage::disk('public')->path($engin->qrcodefolder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }

        $path = Storage::disk('public')->path($engin->qrcode);
        Storage::delete($path);
/*
        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate('http://www.eolis.ci', Storage::disk('public')->path('eolisci.png'));
        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate('https://www.calameo.com/read/0061057384f539f32d093', Storage::disk('public')->path('eoliscien.png'));
        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate('https://www.calameo.com/read/006105738878af300b497', Storage::disk('public')->path('eoliscifr.png'));
*/
        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate($engin->idengin, $path);
        return ['path' => $engin->qrcodelink];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return \Illuminate\Http\Response
     */
    public function generateEnginQrCode(Engin $engin)
    {
        return response()->json($this->generateEnginQrCodeF($engin));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateEnginQrCodes(Request $request)
    {
        $engins = collect([]);
        $paths = collect([]);
        if( $request->types && sizeof($request->types) > 0 )
        {
            $typengins = Typengin::with('engins')->whereIn('codetype', $request->types)->get();
            foreach($typengins as $typengin)
            {
                $engins = $engins->concat($typengin->engins);
            }
        }
        else
        {
            $engins = Engin::all();
        }

        foreach($engins as $engin)
        {
            $paths = $paths->concat($this->generateEnginQrCodeF($engin));
        }

        return response()->json($paths);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return \Illuminate\Http\Response
     */
    public function show(Engin $engin)
    {
        $engin->load(['assurances','ois.operationtechniques','ois.pieces','sortiecarburants.piece','typengin','visitetechniques']);
        return response()->json($engin, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Engin $engin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\Engin  $engin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engin $engin)
    {
        //
    }
}
