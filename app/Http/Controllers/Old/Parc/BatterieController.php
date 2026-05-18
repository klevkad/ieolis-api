<?php

namespace App\Http\Controllers\Old\Parc;

use App\Exports\BatterieExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Parc\BatterieCreateRequest;
use App\Http\Requests\Old\Parc\BatterieUpdateRequest;
use App\Models\Old\Parc\Batterie;
use App\Models\Old\Parc\Batterie_Engin;
use App\Models\Old\Parc\BatterieWorkingTime;
use App\Models\Old\Parc\Chargeur;
use App\Models\Old\Parc\Engin;
use App\Models\Old\Parc\SignalPanne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class BatterieController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:batteriefilter')->only('filter');
        $this->middleware('permission:batteriepaginate')->only('paginate');
        $this->middleware('permission:batterieindex')->only('index');
        $this->middleware('permission:batteriecreate')->only('store');
        $this->middleware('permission:batterieshow')->only(['show', 'showByCode']);
        $this->middleware('permission:batterieupdate')->only('update');
        $this->middleware('permission:batteriedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Batterie::class, 'batterie');
    }

    public function statBatterieSDC()
    {
        return response()->json([
            'btot' => Batterie::groupBy('codetype')
                            ->selectRaw('count(id) as count, codetype')
                            ->pluck('count','codetype'),
            'bhs' => Batterie::where('batterieetat_id', 3)
                            ->groupBy('codetype')
                            ->selectRaw('count(id) as count, codetype')
                            ->pluck('count','codetype'),
            'bec' => Batterie::whereHas('charges2', function (Builder $q) {// En charge
                        $q->whereNull("fin");
                    })
                    ->groupBy('codetype')
                    ->selectRaw('count(id) as count, codetype')
                    ->pluck('count','codetype'),
            'beac' => SignalPanne::whereDoesntHave('reception_batterie') // En attente de charge
                                ->where('categorie_panne_id', 2)->get()
                                ->countBy(function ($item) {
                                    return $item->engin->codetype;
                                }),
            'bc' => Batterie::where(function ($qry) {// Chargée
                        $qry->whereDoesntHave('enginSansFin')
                            ->whereDoesntHave('chargeSansFin')
                            ->whereDoesntHave('receptions', function (Builder $q) {
                                $q->doesntHave('charge');
                            })->whereHas('receptions.charge');
                    })
                    ->groupBy('codetype')
                    ->selectRaw('count(id) as count, codetype')
                    ->pluck('count','codetype'),
        ], 200);
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Batterie::orderBy('libelle','ASC');

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
        $req = Batterie::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        if(request()->has('incharge'))
        {
            if(request()->incharge == 'BEC')
            {
                $req->whereHas('charges2', function (Builder $q) {// En charge
                    $q->whereNull("fin");
                });
            }
            else if(request()->incharge == 'BEAC')
            {
                $req->whereHas('receptions', function (Builder $q) {// En attente de charge
                    $q->doesntHave('charge');
                });
            }
            else if(request()->incharge == 'BC')
            {
                $req->where(function ($qry) {// Chargée
                    $qry->whereDoesntHave('enginSansFin')
                        ->whereDoesntHave('chargeSansFin')
                        ->whereDoesntHave('receptions', function (Builder $q) {
                            $q->doesntHave('charge');
                        })->whereHas('receptions.charge');
                });
            }
            else if(request()->incharge == 1)
            {
                $req->whereHas('charges2', function (Builder $q) {// En charge
                    $q->whereNull("fin");
                })->orWhereHas('receptions', function (Builder $q) {// En attente de charge
                    $q->doesntHave('charge');
                })->orWhere(function ($qry) {// Chargée
                    $qry->whereDoesntHave('enginSansFin')
                        ->whereDoesntHave('chargeSansFin')
                        ->whereDoesntHave('receptions', function (Builder $q) {
                            $q->doesntHave('charge');
                        })->whereHas('receptions.charge');
                });
            }
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

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportData()
    {
        $req = Batterie::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        if(request()->has('incharge'))
        {
            if(request()->incharge == 'BEC')
            {
                $req->whereHas('charges2', function (Builder $q) {// En charge
                    $q->whereNull("fin");
                });
            }
            else if(request()->incharge == 'BEAC')
            {
                $req->whereHas('receptions', function (Builder $q) {// En attente de charge
                    $q->doesntHave('charge');
                });
            }
            else if(request()->incharge == 'BC')
            {
                $req->where(function ($qry) {// Chargée
                    $qry->whereDoesntHave('enginSansFin')
                        ->whereDoesntHave('chargeSansFin')
                        ->whereDoesntHave('receptions', function (Builder $q) {
                            $q->doesntHave('charge');
                        })->whereHas('receptions.charge');
                });
            }
            else if(request()->incharge == 1)
            {
                $req->whereHas('charges2', function (Builder $q) {// En charge
                    $q->whereNull("fin");
                })->orWhereHas('receptions', function (Builder $q) {// En attente de charge
                    $q->doesntHave('charge');
                })->orWhere(function ($qry) {// Chargée
                    $qry->whereDoesntHave('enginSansFin')
                        ->whereDoesntHave('chargeSansFin')
                        ->whereDoesntHave('receptions', function (Builder $q) {
                            $q->doesntHave('charge');
                        })->whereHas('receptions.charge');
                });
            }
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

        $data = $req->get();

        return Excel::download(new BatterieExport($data->groupBy(function ($item, $key) { return $item->codetype; })), 'export-batteries.xlsx');
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginateAttribution()
    {
        $req = Batterie_Engin::with(['batterie', 'engin', 'lieu']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('batterie', function (Builder $q) {
                        $q->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereRaw("UPPER(observation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            if(request()->statut == 'ec')
            {
                $req->whereNull('fin');
            }
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'batterie_id' => 'batterie_id',
            'idlieu' => 'idlieu',
            'debut' => 'debut',
            'fin' => 'fin',
            'observation' => 'observation',
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
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAttribution()
    {
        $req = Batterie_Engin::with(['batterie', 'engin', 'lieu']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        $req->whereNull('fin');
        $req->orderBy('idengin','asc');

        return response()->json($req->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function startBatterieWorkingTime(Batterie_Engin $batterie_Engin)
    {
        $date_wt = date('Y-m-d H:i:s');

        $bwt = BatterieWorkingTime::create([
            'debut' => $date_wt,
            'signal_panne_id' => $batterie_Engin->signal_panne_id,
            'created_by' => Auth::user()->id
        ]);

        return response()->json($bwt->batterieworkingtimes, 201);
    }

    public function stopBatterieWorkingTime(Batterie_Engin $batterie_Engin)
    {
        $date_wt = date('Y-m-d H:i:s');

        $batterie_Engin->batterieworkingtimes->last()->update([
            'fin' => $date_wt,
            'updated_by' => Auth::user()->id
        ]);

        return response()->json($batterie_Engin->batterieworkingtimes, 200);
    }

    public function generateBatterieQrCodeF(Batterie $batterie)
    {
        $path = Storage::disk('public')->path($batterie->qrcodefolder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $path = Storage::disk('public')->path($batterie->qrcode);
        Storage::delete($path);

        $pathmini = Storage::disk('public')->path($batterie->qrcode_minifolder);
        if(!File::isDirectory($pathmini)){
            File::makeDirectory($pathmini, 0777, true, true);
        }
        $pathmini = Storage::disk('public')->path($batterie->qrcode_mini);
        Storage::delete($pathmini);

        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate($batterie->libelle, $path);

        $img = Image::make(Storage::disk('public')->path('img/qrcode/cadre-qr.png'));
        $imgQr = Image::make($path)->resize(700,700);
        $img->insert($imgQr, 'top-left', 122, 235)
            ->text($batterie->libelle, 470, 180, function($font) {
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

        return ['path' => $batterie->qrcodelink];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Old\Parc\Batterie  $batterie
     * @return \Illuminate\Http\Response
     */
    public function generateBatterieQrCode(Batterie $batterie)
    {
        return response()->json($this->generateBatterieQrCodeF($batterie));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateBatterieQrCodes(Request $request)
    {
        $batteries = Batterie::all();
        $paths = collect([]);

        foreach($batteries as $batterie)
        {
            $paths = $paths->concat($this->generateBatterieQrCodeF($batterie));
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
        $req = Batterie::orderBy('libelle');

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('enabled',1);
        }

        return response()->json($req->get(), 200);
    }

    public function storeWithPhoto(BatterieCreateRequest $request)
    {
        $request->merge([
            'libelle' => mb_strtoupper($request->libelle),
        ]);

        $batterie = Batterie::create($request->except(['photo']));

        if( $photo = $request->file('photo') )
        {
            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle.'/'.$batterie->id.'.jpg');
            if(File::isFile($path)) {
                Storage::delete($path);
            }

            Storage::disk('public')->putFileAs('photo/batterie/'.$batterie->libelle, $request->file('photo'), $batterie->id.'.jpg');
        }

        return response()->json($batterie, 201);
    }

    public function updateWithPhoto(BatterieUpdateRequest $request, Batterie $batterie)
    {
        $request->merge([
            'libelle' => mb_strtoupper($request->libelle),
        ]);

        $batterie->update($request->except(['id','photo']));

        if( $photo = $request->file('photo') )
        {
            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle.'/'.$batterie->id.'.jpg');
            if(File::isFile($path)) {
                Storage::delete($path);
            }

            Storage::disk('public')->putFileAs('photo/batterie/'.$batterie->libelle, $request->file('photo'), $batterie->id.'.jpg');
        }

        return response()->json($batterie, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BatterieCreateRequest $request)
    {
        $request->merge([
            'libelle' => mb_strtoupper($request->libelle),
        ]);

        $batterie = Batterie::create($request->except(['photo']));

        if( $image = $request->photo )
        {
            $path = Storage::disk('public')->path('photo/batteries/'.$batterie->libelle);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('photo/batteries/'.$batterie->libelle.'/'.$batterie->id.'.jpeg');
            Storage::delete($path);

            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            Storage::disk('public')->putFileAs('photo/batteries/'.$batterie->libelle, base64_decode($image), $batterie->id.'.jpeg');
        }

        return response()->json($batterie, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBatterieReception(Request $request)
    {
        $date_reception = date('Y-m-d H:i:s');
        $date_reception2 = date_format(date_create($date_reception),'Ymd_His');

        $batterie = Batterie::where('libelle',mb_strtoupper($request->batterie_qr))->firstOrFail();
        $batterie->receptions2()->attach($request->mod_docker_matricule, [
            'date_reception' => $date_reception,
            'observation' => $request->observation,
            'signal_panne_id' => $request->signal_panne_id,
            'created_by' => Auth::user()->id
        ]);

        if($batterie->enginSansFin->count() > 0)
        {
            $batterie->enginSansFin()->updateExistingPivot($batterie->enginSansFin[0]->idengin, [
                'fin' => $date_reception,
                'updated_by' => Auth::user()->id
            ]);    
        }

        if( $video = $request->file('video') )
        {
            $path = Storage::disk('public')->path('video/batterie/reception/'.$batterie->libelle);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('video/batterie/reception/'.$batterie->libelle.'/'.$date_reception2.'.mp4');
            Storage::delete($path);

            Storage::disk('public')->putFileAs('video/batterie/reception/'.$batterie->libelle, $request->file('video'), $date_reception2.'.mp4');
        }
//        $batterie->receptions;

        return response()->json($batterie, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBatterieReception(Request $request, Batterie $batterie)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBatterieAttribution(Request $request)
    {
        $date_attribution = date('Y-m-d H:i:s');
//        $date_attribution2 = date_format(date_create($date_attribution),'Ymd_His');

        $batterie = Batterie::doesnthave('enginSansFin')->doesnthave('chargeSansFin')->where('libelle',mb_strtoupper($request->batterie_qr))->firstOrFail();
        $engin = Engin::doesnthave('attributionbatteriesansfin')->where('idengin',mb_strtoupper($request->idengin))->firstOrFail();
/*
        $batterie->engins()->attach(mb_strtoupper($request->idengin), [
            'idlieu' => $request->idlieu,
            'debut' => $date_attribution,
            'observation' => $request->observation,
            'signal_panne_id' => $request->signal_panne_id,
            'created_by' => Auth::user()->id
        ]);
*/

        $batterie->batterieengins()->create([
            'idengin' => $engin->idengin,
            'idlieu' => $request->idlieu,
            'debut' => $date_attribution,
            'observation' => $request->observation,
            'signal_panne_id' => $request->signal_panne_id,
            'created_by' => Auth::user()->id
        ]);

//        $batterie->batterieengins;

        return response()->json($batterie, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBatterieAttribution(Request $request, Batterie $batterie)
    {
        $date_attribution = date('Y-m-d H:i:s');

        $batterie = Batterie::where('libelle',mb_strtoupper($request->batterie_qr))->firstOrFail();

        $batterie->batterieenginencours()->where('idengin',mb_strtoupper($request->idengin))->last()->update([
            'idlieu' => $request->idlieu,
            'debut' => $request->debut,
            'fin' => $request->fin,
            'observation' => $request->observation,
            'signal_panne_id' => $request->signal_panne_id,
            'updated_by' => Auth::user()->id
        ]);

        return response()->json($batterie, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBatterieCharge(Request $request)
    {
        $date_charge = date('Y-m-d H:i:s');
        $date_charge2 = date_format(date_create($date_charge),'Ymd_His');

        $batterie = Batterie::where('libelle',mb_strtoupper($request->batterie_qr))->firstOrFail();
        $panne_id = $batterie->reception->signal_panne_id;
        $chargeur = Chargeur::where('libelle',mb_strtoupper($request->chargeur_qr))->firstOrFail();
        $batterie->charges()->attach($chargeur->id, [
            'debut' => $date_charge,
            'observation' => $request->observation,
            'created_by' => Auth::user()->id,
            'signal_panne_id' => $panne_id
        ]);

        $batterie->charges;

        return response()->json($batterie, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBatterieCharge(Request $request, Batterie $batterie)
    {
        $date_fin_charge = date('Y-m-d H:i:s');
        $chargeur = $batterie->charge;
        $batterie->chargeSansFin()->updateExistingPivot($chargeur->id, [
            'fin' => $date_fin_charge,
            'updated_by' => Auth::user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Batterie  $batterie
     * @return \Illuminate\Http\Response
     */
    public function show(Batterie $batterie)
    {
//        $batterie->load([]);
        return response()->json($batterie, 200);
    }

    public function showByCode(Request $request)
    {
        $batterie = Batterie::with(['batterieetat', 'batterietype', 'typengin', 'engins'/*, 'prises'*/])
                            ->where('libelle','=',$request->code)
                            ->first();
        return response()->json($batterie, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batterie  $batterie
     * @return \Illuminate\Http\Response
     */
    public function update(BatterieUpdateRequest $request, Batterie $batterie)
    {
        $request->merge([
            'libelle' => mb_strtoupper($request->libelle),
        ]);

        $batterie->update($request->except(['id','photo']));

        if( $photo = $request->file('photo') )
        {
            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle);
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }

            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle.'/'.$batterie->id.'.jpg');
            if(File::isFile($path)) {
                Storage::delete($path);
            }

            Storage::disk('public')->putFileAs('photo/batterie/'.$batterie->libelle, $request->file('photo'), $batterie->id.'.jpg');
        }

        return response()->json($batterie, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Batterie  $batterie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batterie $batterie)
    {
        try{
            $path = Storage::disk('public')->path('photo/batterie/'.$batterie->libelle.'/'.$batterie->id.'.jpg');
            if(File::isFile($path)) {
                Storage::disk('public')->delete($path);
            }

            $batterie->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
