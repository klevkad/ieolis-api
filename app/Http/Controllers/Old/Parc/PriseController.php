<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Parc\PriseCreateRequest;
use App\Http\Requests\Old\Parc\PriseUpdateRequest;
use App\Models\Old\Parc\Prise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Image;

class PriseController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:prisefilter')->only('filter');
        $this->middleware('permission:prisepaginate')->only('paginate');
        $this->middleware('permission:priseindex')->only('index');
        $this->middleware('permission:prisecreate')->only('store');
        $this->middleware('permission:priseshow')->only('show');
        $this->middleware('permission:priseupdate')->only('update');
        $this->middleware('permission:prisedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Prise::class, 'prise');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Prise::orderBy('libelle','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            return response()->json($req->get(), 200);
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
        $req = Prise::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('enabled',1);
        }

        $displayedColumns = [
            'libelle' => 'libelle',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }

    public function generatePriseQrCodeF(Prise $prise)
    {
        $path = Storage::disk('public')->path($prise->qrcodefolder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $path = Storage::disk('public')->path($prise->qrcode);
        Storage::delete($path);

        $pathmini = Storage::disk('public')->path($prise->qrcode_minifolder);
        if(!File::isDirectory($pathmini)){
            File::makeDirectory($pathmini, 0777, true, true);
        }
        $pathmini = Storage::disk('public')->path($prise->qrcode_mini);
        Storage::delete($pathmini);

        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate($prise->libelle, $path);

        $img = Image::make(Storage::disk('public')->path('img/qrcode/cadre-qr.png'));
        $imgQr = Image::make($path)->resize(700,700);
        $img->insert($imgQr, 'top-left', 122, 235)
            ->text($prise->libelle, 470, 180, function($font) {
                $font->file(Storage::disk('public')->path('img/qrcode/AgencyFBBold.ttf'));
                $font->size(50);
                $font->size(50);
                $font->color('#ffffff');
                $font->align('center');
                $font->valign('middle');
//                $font->angle(45);
            })
            ->save($path);

        $img->resize(473,650)->save($pathmini);

        return ['path' => $prise->qrcodelink];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Old\Parc\Prise  $prise
     * @return \Illuminate\Http\Response
     */
    public function generatePriseQrCode(Prise $prise)
    {
        return response()->json($this->generatePriseQrCodeF($prise));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generatePriseQrCodes(Request $request)
    {
        $prises = Prise::all();
        $paths = collect([]);

        foreach($prises as $prise)
        {
            $paths = $paths->concat($this->generatePriseQrCodeF($prise));
        }

        return response()->json($paths);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $req = Prise::orderBy('libelle');

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('enabled',1);
        }

        return response()->json($req->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriseCreateRequest $request)
    {
        $prise = Prise::create($request->all());
        return response()->json($prise, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prise  $prise
     * @return \Illuminate\Http\Response
     */
    public function show(Prise $prise)
    {
//        $prise->load([]);
        return response()->json($prise, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prise  $prise
     * @return \Illuminate\Http\Response
     */
    public function update(PriseUpdateRequest $request, Prise $prise)
    {
        $prise->update($request->except(['id']));
        return response()->json($prise, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prise  $prise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prise $prise)
    {
        try{
            $prise->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
