<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\TypeIncidentCreateRequest;
use App\Http\Requests\Fichiers\TypeIncidentUpdateRequest;
use App\Models\Fichiers\TypeIncident;
use Illuminate\Http\Request;

class TypeIncidentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:typeincidentfilter')->only('filter');
        $this->middleware('permission:typeincidentpaginate')->only('paginate');
        $this->middleware('permission:typeincidentindex')->only('index');
        $this->middleware('permission:typeincidentcreate')->only('store');
        $this->middleware('permission:typeincidentshow')->only('show');
        $this->middleware('permission:typeincidentupdate')->only('update');
        $this->middleware('permission:typeincidentdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\TypeIncident::class, 'type_incident');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = TypeIncident::orderBy('libelle','ASC');

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
        $req = TypeIncident::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TypeIncident::orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeIncidentCreateRequest $request)
    {
        $typeIncident = TypeIncident::create($request->all());
        return response()->json($typeIncident, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Http\Response
     */
    public function show(TypeIncident $typeIncident)
    {
//        $typeIncident->load(['chauffeurs']);
        return response()->json($typeIncident, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Http\Response
     */
    public function update(TypeIncidentUpdateRequest $request, TypeIncident $typeIncident)
    {
        $typeIncident->update($request->except(['id']));
        return response()->json($typeIncident, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fichiers\TypeIncident  $typeIncident
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeIncident $typeIncident)
    {
        try{
            $typeIncident->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
