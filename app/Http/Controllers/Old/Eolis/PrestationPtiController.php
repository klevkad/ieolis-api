<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Prestation_Pti_Conteneur;
use App\Models\Old\Eolis\Prestation_Conteneur_Dispo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestationPtiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:prestationpticonteneurfilter')->only('filter');
        $this->middleware('permission:prestationpticonteneurpaginate')->only('paginate');
        $this->middleware('permission:prestationpticonteneurindex')->only('index');
        $this->middleware('permission:prestationpticonteneurcreate')->only('store');
        $this->middleware('permission:prestationpticonteneurshow')->only('show');
        $this->middleware('permission:prestationpticonteneurupdate')->only('update');
        $this->middleware('permission:prestationpticonteneurdelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\Prestation_Pti_Conteneur::class, 'prestationpticonteneur');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Prestation_Pti_Conteneur::orderBy('no_tc','ASC');

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
        $req = Prestation_Pti_Conteneur::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        $displayedColumns = [
            'no_tc' => 'no_tc',
            'username' => 'username',
            'client' => 'client',
            'observation' => 'observation',
            'position' => 'position',
            'date_pti' => 'date_pti',
            'id_prestation_pti' => 'id_prestation_pti'
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
        return response()->json(Prestation_Pti_Conteneur::orderBy('no_tc')->get(), 200);
    }

    /**
     * Obtenir la dernière prestation PTI pour un TC donné
     *
     * @param  string  $no_tc
     * @return \Illuminate\Http\Response
     */
    public function getLastPtiByTc($no_tc)
    {   
        try {
             $lastPti = Prestation_Pti_Conteneur::where('no_tc', $no_tc)->orderBy('id_prestation_pti', 'desc')->first();

            if ($lastPti) {
                return response()->json(
                    [
                        'status' => 1,
                        'msg' => 'Dernière prestation PTI trouvée pour ce TC.', 
                        'data' => $lastPti, 
                    ], 
                    200
                );
            } else {
                return response()->json([
                    'status' => 0,
                    'msg' => 'Aucune prestation PTI trouvée pour ce TC.', 
                    'error' => null, 
                ]);
                //return response()->json(['message' => 'Aucune prestation PTI trouvée pour ce TC.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Erreur lors de la recherche de la dernière prestation PTI.', 
                'error' => $e->getMessage(), 
            ]);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $noTcs = $request->no_tc;
            foreach ($noTcs as $tc) {
                $dataToStore = $request->only(['observation', 'date_pti', 'sitestok', 'app']);
        
                $prest = Prestation_Pti_Conteneur::create($dataToStore+[
                    'no_tc' => trim($tc),
                    'username' => \Auth::user()->model->codeuser,
                ]);
            
                Prestation_Conteneur_Dispo::updateOrCreate(
                    ['no_tc' => trim($tc)], 
                    [
                        'date_ctrl_journalier' => $request->date_pti,
                        'observation' => $request->observation,
                        'pti' => 1,
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
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return \Illuminate\Http\Response
     */
    public function show(Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        $prestation_pti_conteneur->load([]);
        return response()->json($prestation_pti_conteneur, 200);
    }

    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        //return $prestation_pti_conteneur;
        $prestation_pti_conteneur->update($request->except(['id_prestation_pti']));
        return response()->json($prestation_pti_conteneur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestation_Pti_Conteneur  $prestation_pti_conteneur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestation_Pti_Conteneur $prestation_pti_conteneur)
    {
        try{
            $prestation_pti_conteneur->delete();
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
