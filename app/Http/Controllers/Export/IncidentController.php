<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\IncidentCreateRequest;
use App\Http\Requests\Export\IncidentUpdateRequest;
use App\Models\Export\Incident;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class IncidentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:incidentfilter')->only('filter');
        $this->middleware('permission:incidentpaginate')->only('paginate');
        $this->middleware('permission:incidentindex')->only('index');
        $this->middleware('permission:incidentcreate')->only('store');
        $this->middleware('permission:incidentshow')->only('show');
        $this->middleware('permission:incidentupdate')->only('update');
        $this->middleware('permission:incidentdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\Incident::class, 'incident');
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = Incident::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(nobooking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("qte_appro LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("date_incident LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('typeincident', function (Builder $q) {
                        $q->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereHas('typengin', function (Builder $q) {
                        $q->whereRaw("UPPER(codetype) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereRaw("UPPER(commentaire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("act = ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idlieu_appro',request()->statut);
        }
*/
        $displayedColumns = [
            'nobooking' => 'nobooking',
            'no_tc' => 'no_tc',
            'date_incident' => 'date_incident',
            'commentaire' => 'commentaire',
            'act' => 'act',
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
        return response()->json(Incident::orderBy('date_incident')->orderBy('no_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncidentCreateRequest $request)
    {
        $incident = Incident::create($request->all());
        return response()->json($incident, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Export\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        $incident->load(['typeincident','typengin']);
        return response()->json($incident, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Export\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function update(IncidentUpdateRequest $request, Incident $incident)
    {
        $incident->update($request->except(['id']));
        return response()->json($incident, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Export\Incident  $incident
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        try{
            $incident->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
