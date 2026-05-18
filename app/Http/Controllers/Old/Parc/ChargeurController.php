<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Models\Old\Parc\Chargeur;
use App\Http\Requests\Old\Parc\ChargeurCreateRequest;
use App\Http\Requests\Old\Parc\ChargeurUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Image;

class ChargeurController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*
        $this->middleware('permission:chargeurfilter')->only('filter');
        $this->middleware('permission:chargeurpaginate')->only('paginate');
        $this->middleware('permission:chargeurindex')->only('index');
        $this->middleware('permission:chargeurcreate')->only('store');
        $this->middleware('permission:chargeurshow')->only('show');
        $this->middleware('permission:chargeurupdate')->only('update');
        $this->middleware('permission:chargeurdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\Chargeur::class, 'chargeur');
        */
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Chargeur::orderBy('libelle','ASC');

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
        $req = Chargeur::with([]);

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

    public function generateChargeurQrCodeF(Chargeur $chargeur)
    {
        $path = Storage::disk('public')->path($chargeur->qrcodefolder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $path = Storage::disk('public')->path($chargeur->qrcode);
        Storage::delete($path);

        $pathmini = Storage::disk('public')->path($chargeur->qrcode_minifolder);
        if(!File::isDirectory($pathmini)){
            File::makeDirectory($pathmini, 0777, true, true);
        }
        $pathmini = Storage::disk('public')->path($chargeur->qrcode_mini);
        Storage::delete($pathmini);

        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate($chargeur->libelle, $path);

        $img = Image::make(Storage::disk('public')->path('img/qrcode/cadre-qr.png'));
        $imgQr = Image::make($path)->resize(700,700);
        $img->insert($imgQr, 'top-left', 122, 235)
            ->text($chargeur->libelle, 470, 180, function($font) {
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

        return ['path' => $chargeur->qrcodelink];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Old\Parc\Chargeur  $chargeur
     * @return \Illuminate\Http\Response
     */
    public function generateChargeurQrCode(Chargeur $chargeur)
    {
        return response()->json($this->generateChargeurQrCodeF($chargeur));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateChargeurQrCodes(Request $request)
    {
        $chargeurs = Chargeur::all();
        $paths = collect([]);

        foreach($chargeurs as $chargeur)
        {
            $paths = $paths->concat($this->generateChargeurQrCodeF($chargeur));
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
        $req = Chargeur::orderBy('libelle');

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
    public function store(ChargeurCreateRequest $request)
    {
        $chargeur = Chargeur::create($request->all());
        return response()->json($chargeur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chargeur  $chargeur
     * @return \Illuminate\Http\Response
     */
    public function show(Chargeur $chargeur)
    {
//        $chargeur->load([]);
        return response()->json($chargeur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chargeur  $chargeur
     * @return \Illuminate\Http\Response
     */
    public function update(ChargeurUpdateRequest $request, Chargeur $chargeur)
    {
        $chargeur->update($request->except(['id']));
        return response()->json($chargeur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chargeur  $chargeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chargeur $chargeur)
    {
        try{
            $chargeur->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
