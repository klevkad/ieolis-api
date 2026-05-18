<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests\Old\Parc\FinOuvertureRequest;
use App\Models\Old\Parc\OuvertureStation;
use App\Models\Old\Parc\Sortie;

class OuvertureStationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ouverturestationfilter')->only('filter');
        $this->middleware('permission:ouverturestationpaginate')->only('paginate');
        $this->middleware('permission:ouverturestationindex')->only('index');
        $this->middleware('permission:ouverturestationcreate')->only('store');
        // $this->middleware('permission:ouverturestationshow')->only('show');
        $this->middleware('permission:ouverturestationupdate')->only('update');
        $this->middleware('permission:ouverturestationdelete')->only('destroy');
       
        // $this->authorizeResource(\App\Models\Old\Parc\OuvertureStation::class, 'ouverture_station');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $to = date('Y-m-d');
        $from = date('Y-m-d', strtotime('-60 days',strtotime($to)));

        $req = OuvertureStation::with('sorties');

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function($query) {
                    $query->where('stationid','LIKE','%'.mb_strtoupper(request()->search).'%');
                })->whereIn('idbon', function($query) use ($to, $from) {
                    $query->select('sortie.idbon')
                        ->from('sortie')
                        ->join('lignesor','sortie.idbon','=','lignesor.idbon')
                        ->join('piece','lignesor.idpiece','=','piece.idpiece')
                        ->where([
                            ['lignesor.idengin','like',request()->search], 
                            ['piece.codefam','002'], 
                            ['piece.codepiece','0002']
                        ])->whereBetween('lignesor.datesaisie',[$from, $to]);
                })->orderBy('numbon_phys','ASC')
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
     
        if(!\Auth::user()->hasRole('admin') && !\Auth::user()->hasRole('resp-garage'))
        {
            $ouv = OuvertureStation::where('created_by', \Auth::user()->model->codeuser)
                                   ->orderBy('ouverture_id','DESC');
        }
        else{
            $ouv = OuvertureStation::orderBy('ouverture_id','DESC');
        }

        
        if(request()->has('search') && request()->search != '')
        {
            $ouv->where(function ($query) {
                  $query->where('stationid','LIKE','%'.mb_strtoupper(request()->search).'%')
                        ->orWhere('stationid','LIKE','%'.mb_strtolower(request()->search).'%');
            });
        }
        return response()->json($ouv->paginate(request()->size), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        try {
            // VERIFIER SI UNE OUVERTURE EST ENCOURS POUR LA STATION
            $ouvertureEnCours = OuvertureStation::where('stationid', $request->stationid)
                ->whereNull('datefermeture')
                ->first();
            if ($ouvertureEnCours) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Une ouverture est déjà en cours pour cette station.',
                ], 400);
            }
            $dataToStore = $request->only(['stationid','indexdebut','quantitedebut']);
            $OuvertureStation = OuvertureStation::create($dataToStore + [
                'created_by' => \Auth::user()->model->codeuser,
                'index_logique' => request()->indexdebut
            ]);
            return response()->json($OuvertureStation, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.', 
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function finouverture(FinOuvertureRequest $request, OuvertureStation $ouverturestation){
        try {
            
            $dataToUpdate = [
                'indexfin'      => $request->indexfin,
                'quantitefin'   => $request->quantitefin,
                'datefermeture' => $request->datefermeture ? Carbon::parse($request->datefermeture) : Carbon::now(),
                'updated_by'    => optional(\Auth::user())->model->codeuser, 
            ];

            $ouverturestation->update($dataToUpdate);
            return response()->json($ouverturestation, 200);

        } catch (\Throwable $e) {
            \Log::error("Erreur lors de la fin d'ouverture de la station ID: " . $ouverturestation->id, [
                'exception' => $e,
                'user' => optional(\Auth::user())->id,
            ]);
            
            return response()->json([
                'status' => 0,
                'msg' => 'Une erreur inattendue est survenue lors de la fermeture.', 
                'error' => ''//$e->getMessage(), 
            ], 500);
        }     
    }

    public function checkouvertureencour($stationid)
    {
        $ouverturestation = OuvertureStation::whereNull('datefermeture')
            ->where('stationid', $stationid)
            ->orderBy('ouverture_id', 'DESC')
            ->count();
        if($ouverturestation > 0){
            return response()->json(false, 200);
        }else{
            $lastouverturestation = OuvertureStation::whereNotNull('datefermeture')
                ->where('stationid', $stationid)
                ->orderBy('ouverture_id', 'DESC')
                ->first();
            $indexfin = $lastouverturestation ? $lastouverturestation->indexfin : 0;
            
            return response()->json($lastouverturestation, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ouverture_station = OuvertureStation::find($id);
        // $this->authorize('view', $ouverture_station); // Appelle la méthode view() de votre OuvertureStationPolicy
        return response()->json($ouverture_station);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    public function update(Request $request, OuvertureStation $ouverture_station)
    {   

        $ouverture_station->update($request->except(['ouverture_id','created_by', 'created_at']));
        return response()->json($ouverture_station, 200);
        
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(OuvertureStation $ouverture_station)
    {
        $sortie = Sortie::where('ouverture_id', $ouverture_station->ouverture_id)->first();
        if ($sortie) {
            return response()->json(['message' => 'Impossible de supprimer cette ligne, car elle est liée à une sortie.'], 400);
        }
        $ouverture_station->delete();
        return response()->json(['message' => 'Ligne station supprimée avec success'], 200);  
    }
}
