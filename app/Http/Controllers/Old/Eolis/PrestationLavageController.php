<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Prestation_Lavage_Conteneur;
use App\Models\Old\Eolis\Prestation_Conteneur_Dispo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestationLavageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:prestationlavageconteneurfilter')->only('filter');
        $this->middleware('permission:prestationlavageconteneurpaginate')->only('paginate');
        $this->middleware('permission:prestationlavageconteneurindex')->only('index');
        $this->middleware('permission:prestationlavageconteneurcreate')->only('store');
        $this->middleware('permission:prestationlavageconteneurshow')->only('show');
        $this->middleware('permission:prestationlavageconteneurupdate')->only('update');
        $this->middleware('permission:prestationlavageconteneurdelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\Prestation_lavage_Conteneur::class, 'prestationlavageconteneur');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Prestation_Lavage_Conteneur::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Prestation_Lavage_Conteneur::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        $displayedColumns = [
            'no_tc' => 'no_tc',
            'username' => 'username',
            'client' => 'client',
            'observation' => 'observation',
            'idengin' => 'idengin',
            'date_lavage' => 'date_lavage',
            'id_prestation_lav' => 'id_prestation_lav'
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
        return response()->json(Prestation_Lavage_Conteneur::orderBy('no_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try {
           
            $noTcs = $request->no_tc;

            foreach ($noTcs as $tc) {

                $dataToStore = $request->only([
                    'observation',
                    'date_lavage',
                    'idengin',
                    'app'
                ]);

                $prest = Prestation_Lavage_Conteneur::create($dataToStore + [
                    'no_tc' => trim($tc),
                    'username' => \Auth::user()->model->codeuser,
                ]);

                
                Prestation_Conteneur_Dispo::updateOrCreate(
                    ['no_tc' => trim($tc)], 
                    [
                        'date_lavage' => $request->date_lavage,
                        'observation' => $request->observation,
                        'wash' => 1,
                        'username' => \Auth::user()->model->codeuser,
                    ]
                );

            }
            return response()->json([
                'status' => 1,
                'msg' => 'Enregistrement effectué avec succès.',
                'data' => $prest,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Enregistrement échoué.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtenir la dernière prestation Lavage pour un TC donné
     *
     * @param  string  $no_tc
     * @return \Illuminate\Http\Response
     */
    public function getLastLavageByTc($no_tc)
    {   

     try {
            $lastLavage = Prestation_Lavage_Conteneur::where('no_tc', $no_tc)->orderBy('id_prestation_lav', 'desc')->first();

            if ($lastLavage) {
                return response()->json(
                    [
                        'status' => 1,
                        'msg' => 'Dernière prestation Lavage trouvée pour ce TC.', 
                        'data' => $lastLavage, 
                    ], 
                    200
                );
            } else {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Aucune prestation Lavage trouvée pour ce TC.', 
                    'error' => null, 
                ]);
                //return response()->json(['message' => 'Aucune prestation Lavage trouvée pour ce TC.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Erreur lors de la recherche de la dernière prestation Lavage.', 
                'error' => $e->getMessage(), 
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return \Illuminate\Http\Response
     */
    public function show(Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        $prestation_lavage_conteneur->load([]);
        return response()->json($prestation_lavage_conteneur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        $prestation_lavage_conteneur->update($request->except(['id_prestation_lav']));
        return response()->json($prestation_lavage_conteneur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestation_Lavage_Conteneur  $prestation_lavage_conteneur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestation_Lavage_Conteneur $prestation_lavage_conteneur)
    {
        try{
            $prestation_lavage_conteneur->delete();

        }catch(\Illuminate\Database\QueryException $ex){
             return response()->json([
                    'status' => 0,
                    'msg' => 'Une erreur est survenue lors de l\'annulation.', 
                    'error' => null,
            ]);
        }
        return response()->json([
            'status' => 1,
            'msg' => 'Annulation de la ligne Réussie!', 
            'error' => null, 
        ]);
    }

}
