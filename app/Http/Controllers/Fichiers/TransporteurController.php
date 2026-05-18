<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\TransporteurCreateRequest;
use App\Http\Requests\Fichiers\TransporteurUpdateRequest;
use App\Models\Fichiers\Transporteur;
use Illuminate\Http\Request;

class TransporteurController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:transporteurfilter')->only('filter');
        $this->middleware('permission:transporteurpaginate')->only('paginate');
        $this->middleware('permission:transporteurindex')->only('index');
        $this->middleware('permission:transporteurcreate')->only('store');
        $this->middleware('permission:transporteurshow')->only('show');
        $this->middleware('permission:transporteurupdate')->only('update');
        $this->middleware('permission:transporteurdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Transporteur::class, 'transporteur');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Transporteur::with(['chauffeurs'])->orderBy('lib_transporteur','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_transporteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('si_tier', '=', request()->searchFixe);
            }

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
        $req = Transporteur::with(['chauffeurs']);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_transporteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'lib_transporteur' => 'lib_transporteur',
            'si_tier' => 'si_tier',
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
        return response()->json(Transporteur::with(['chauffeurs'])->orderBy('lib_transporteur')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransporteurCreateRequest $request)
    {
        $transporteur = Transporteur::create($request->all());
        return response()->json($transporteur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transporteur  $transporteur
     * @return \Illuminate\Http\Response
     */
    public function show(Transporteur $transporteur)
    {
        $transporteur->load(['chauffeurs']);
        return response()->json($transporteur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transporteur  $transporteur
     * @return \Illuminate\Http\Response
     */
    public function update(TransporteurUpdateRequest $request, Transporteur $transporteur)
    {
        $transporteur->update($request->except(['id']));
        return response()->json($transporteur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transporteur  $transporteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transporteur $transporteur)
    {
        try{
            $transporteur->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
