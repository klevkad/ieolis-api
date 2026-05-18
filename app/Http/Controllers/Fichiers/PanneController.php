<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\PanneCreateRequest;
use App\Http\Requests\Fichiers\PanneUpdateRequest;
use App\Models\Fichiers\Panne;
use App\Models\Fichiers\Pannes_Typengin;
use App\Models\Old\Parc\Typengin;
use Illuminate\Http\Request;

class PanneController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:pannefilter')->only('filter');
        $this->middleware('permission:pannepaginate')->only('paginate');
        $this->middleware('permission:panneindex')->only('index');
        $this->middleware('permission:pannecreate')->only('store');
        $this->middleware('permission:panneshow')->only('show');
        $this->middleware('permission:panneupdate')->only('update');
        $this->middleware('permission:pannedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Panne::class, 'panne');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Panne::orderBy('lib_panne','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_panne) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Panne::with(['typengins']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(lib_panne) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'lib_panne' => 'lib_panne',
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
        return response()->json(Panne::with(['typengins'])->orderBy('lib_panne')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PanneCreateRequest $request)
    {
        $panne = Panne::create($request->all());

        $typengins = Typengin::whereIn('codetype',$request->typengins)->get();
        if( $typengins->count() > 0 ){
            Pannes_Typengin::where('idpanne',$panne->idpanne)->delete();
            foreach($typengins as $typengin){
                Pannes_Typengin::create(['idpanne' => $panne->idpanne, 'codetype' => $typengin->codetype]);
            }
        }
        $panne->typengins;
        return response()->json($panne, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return \Illuminate\Http\Response
     */
    public function show(Panne $panne)
    {
        $panne->load(['typengins']);
        return response()->json($panne, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return \Illuminate\Http\Response
     */
    public function update(PanneUpdateRequest $request, Panne $panne)
    {
        $panne->update($request->except(['id']));

        $typengins = Typengin::whereIn('codetype',$request->typengins)->get();
        if( $typengins->count() > 0 ){
            Pannes_Typengin::where('idpanne',$panne->idpanne)->delete();
            foreach($typengins as $typengin){
                Pannes_Typengin::create(['idpanne' => $panne->idpanne, 'codetype' => $typengin->codetype]);
            }
        }
        $panne->typengins;
        return response()->json($panne, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichiers\Panne  $panne
     * @return \Illuminate\Http\Response
     */
    public function destroy(Panne $panne)
    {
        try{
            Pannes_Typengin::where('idpanne',$panne->idpanne)->delete();
            $panne->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
