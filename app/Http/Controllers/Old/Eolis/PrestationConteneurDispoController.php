<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Prestation_Conteneur_Dispo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestationConteneurDispoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:prestationconteneurdispofilter')->only('filter');
        $this->middleware('permission:prestationconteneurdispopaginate')->only('paginate');
        $this->middleware('permission:prestationconteneurdispoindex')->only('index');
        $this->middleware('permission:prestationconteneurdispocreate')->only('store');
        $this->middleware('permission:prestationconteneurdisposhow')->only('show');
        $this->middleware('permission:prestationconteneurdispoupdate')->only('update');
        $this->middleware('permission:prestationconteneurdispodelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\Prestation_Conteneur_Dispo::class, 'prestationconteneurdispo');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Prestation_Conteneur_Dispo::orderBy('no_tc','ASC');

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
        $req = Prestation_Conteneur_Dispo::with([]);

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
            'date_mad' => 'date_mad',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }

    public function count(){
        $count = Prestation_Conteneur_Dispo::count();
        return response()->json([
            'status' => 1,
            'data' => $count
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Prestation_Conteneur_Dispo::orderBy('no_tc')->get(), 200);
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
                $dataToStore = $request->only(['client', 'observation','date_mad']);
                $prest = Prestation_Conteneur_Dispo::create($dataToStore+[
                    'no_tc' => trim($tc),
                    'username' => \Auth::user()->model->codeuser,
                ]); 
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
                'error' => $e->getMessage(), // Only for development
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return \Illuminate\Http\Response
     */
    public function show(Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        $prestation_conteneur_dispo->load([]);
        return response()->json($prestation_conteneur_dispo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        $prestation_conteneur_dispo->update($request->except(['idprestation_conteneur_export'])); // Assuming 'idprestation_conteneur_export' and 'no_tc' are not updatable
        return response()->json($prestation_conteneur_dispo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestation_Conteneur_Dispo  $prestation_conteneur_dispo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestation_Conteneur_Dispo $prestation_conteneur_dispo)
    {
        try{
            $prestation_conteneur_dispo->delete();
        }catch(\Illuminate\Database\QueryException $ex){
             return response()->json([
                    'status' => 0,
                    'msg' => 'Une erreur est survenue lors de la suppression.', 
                    'error' => null,
            ]);
        }
        return response()->json([
            'status' => 1,
            'msg' => 'Suppression de la ligne réussie!', 
            'error' => null, 
        ]);
       
    }

}
