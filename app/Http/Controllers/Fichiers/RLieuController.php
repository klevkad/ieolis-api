<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\RLieuCreateRequest;
use App\Http\Requests\Fichiers\RLieuUpdateRequest;
use App\Models\Fichiers\RLieu;
use Illuminate\Http\Request;

class RLieuController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:rlieufilter')->only('filter');
        $this->middleware('permission:rlieupaginate')->only('paginate');
        $this->middleware('permission:rlieuindex')->only('index');
        $this->middleware('permission:rlieucreate')->only('store');
        $this->middleware('permission:rlieushow')->only('show');
        $this->middleware('permission:rlieuupdate')->only('update');
        $this->middleware('permission:rlieudelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\RLieu::class, 'r_lieu');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = RLieu::orderBy('lib_lieu','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_lieu) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = RLieu::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(lib_lieu) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'lib_lieu' => 'lib_lieu',
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
        return response()->json(RLieu::orderBy('lib_lieu')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RLieuCreateRequest $request)
    {
        $rLieu = RLieu::create($request->all());
        return response()->json($rLieu, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Http\Response
     */
    public function show(RLieu $rLieu)
    {
        return response()->json($rLieu, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Http\Response
     */
    public function update(RLieuUpdateRequest $request, RLieu $rLieu)
    {
        $rLieu->update($request->except(['idlieu']));
        return response()->json($rLieu, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichiers\RLieu  $rLieu
     * @return \Illuminate\Http\Response
     */
    public function destroy(RLieu $rLieu)
    {
        try{
            $rLieu->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
