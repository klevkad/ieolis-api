<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\EtapeSuiviBookingCreateRequest;
use App\Http\Requests\Fichiers\EtapeSuiviBookingUpdateRequest;
use App\Models\Fichiers\EtapeSuiviBooking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EtapeSuiviBookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:etapesuivibookingfilter')->only('filter');
        $this->middleware('permission:etapesuivibookingpaginate')->only('paginate');
        $this->middleware('permission:etapesuivibookingindex')->only('index');
        $this->middleware('permission:etapesuivibookingcreate')->only('store');
        $this->middleware('permission:etapesuivibookingshow')->only('show');
        $this->middleware('permission:etapesuivibookingupdate')->only('update');
        $this->middleware('permission:etapesuivibookingdelete')->only('destroy');

        $this->authorizeResource(App\Models\Fichiers\EtapeSuiviBooking::class, 'etapesuivibooking');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = EtapeSuiviBooking::orderBy('libelle_etape','ASC');


        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle_etape) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = EtapeSuiviBooking::with(['demandebookings']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle_etape) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('demandeookings', function (Builder $q) {
                          $q->whereDoesntHave('bookingtcfinal');
                        });
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libelle_etape' => 'libelle_etape',
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
        return response()->json(EtapeSuiviBooking::orderBy('libelle_etape')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EtapeSuiviBookingCreateRequest $request)
    {
        $etapeSuiviBooking = EtapeSuiviBooking::create($request->all());
        return response()->json($etapeSuiviBooking, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EtapeSuiviBooking  $etapeSuiviBooking
     * @return \Illuminate\Http\Response
     */
    public function show(EtapeSuiviBooking $etapeSuiviBooking)
    {
        $etapeSuiviBooking->load(['demandebookings']);
        return response()->json($etapeSuiviBooking, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EtapeSuiviBooking  $etapeSuiviBooking
     * @return \Illuminate\Http\Response
     */
    public function update(EtapeSuiviBookingUpdateRequest $request, EtapeSuiviBooking $etapeSuiviBooking)
    {
        $etapeSuiviBooking->update($request->except(['id']));
        return response()->json($etapeSuiviBooking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EtapeSuiviBooking  $etapeSuiviBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(EtapeSuiviBooking $etapeSuiviBooking)
    {
        try{
            $etapeSuiviBooking->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
