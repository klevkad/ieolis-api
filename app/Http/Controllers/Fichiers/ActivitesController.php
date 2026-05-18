<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\ActivitesCreateRequest;
use App\Http\Requests\Fichiers\ActivitesUpdateRequest;
use App\Models\Fichiers\Activites;
use Illuminate\Http\Request;

class ActivitesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:activitesfilter')->only('filter');
        $this->middleware('permission:activitespaginate')->only('paginate');
        $this->middleware('permission:activitesindex')->only('index');
        $this->middleware('permission:activitescreate')->only('store');
        $this->middleware('permission:activitesshow')->only('show');
        $this->middleware('permission:activitesupdate')->only('update');
        $this->middleware('permission:activitesdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Activites::class, 'activite');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Activites::orderBy('lib_activite','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_activite) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Activites::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_activite) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'lib_activite' => 'lib_activite',
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
        return response()->json(Activites::orderBy('lib_activite')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivitesCreateRequest $request)
    {
        $activite = Activites::create($request->all());
        return response()->json($activite, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activites  $activite
     * @return \Illuminate\Http\Response
     */
    public function show(Activites $activite)
    {
//        $activite->load([]);
        return response()->json($activite, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activites  $activite
     * @return \Illuminate\Http\Response
     */
    public function update(ActivitesUpdateRequest $request, Activites $activite)
    {
        $activite->update($request->except(['id']));
        return response()->json($activite, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activites  $activite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activites $activite)
    {
        try{
            $activite->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
