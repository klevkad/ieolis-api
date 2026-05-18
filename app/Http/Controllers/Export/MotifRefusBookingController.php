<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\MotifRefusBookingCreateRequest;
use App\Http\Requests\Export\MotifRefusBookingUpdateRequest;
use App\Models\Export\MotifRefusBooking;
use Illuminate\Http\Request;

class MotifRefusBookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:motifrefusbookingfilter')->only('filter');
        $this->middleware('permission:motifrefusbookingpaginate')->only('paginate');
        $this->middleware('permission:motifrefusbookingindex')->only('index');
        $this->middleware('permission:motifrefusbookingcreate')->only('store');
        $this->middleware('permission:motifrefusbookingshow')->only('show');
        $this->middleware('permission:motifrefusbookingupdate')->only('update');
        $this->middleware('permission:motifrefusbookingdelete')->only('destroy');

        $this->authorizeResource(App\Models\MotifRefusBooking::class, 'motif_refus_booking');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = MotifRefusBooking::with(['localite.model'])->orderBy('libelle','ASC');

        if(!Auth::user()->isAdmin()) {
            $req->where('enabled','=',1);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('localite_id', '=', request()->searchFixe);
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
        $req = MotifRefusBooking::with(['localite.model','typeMotifRefusBooking']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeMotifRefusBooking', function (Builder $q) {
                          $q->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libelle','ASC');
                        })
                      ->orWhereRaw("inscrits LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libelle' => 'libelle',
            'annee' => 'annee',
            'inscrits' => 'inscrits',
//            'type_motifRefusBooking' => 'type_motifRefusBookings.libelle',
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
        return response()->json(MotifRefusBooking::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MotifRefusBookingCreateRequest $request)
    {
        $motifRefusBooking = MotifRefusBooking::create($request->all());
        return response()->json($motifRefusBooking, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotifRefusBooking  $motifRefusBooking
     * @return \Illuminate\Http\Response
     */
    public function show(MotifRefusBooking $motifRefusBooking)
    {
        $motifRefusBooking->load(['typeMotifRefusBooking', 'localite']);
        return response()->json($motifRefusBooking, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotifRefusBooking  $motifRefusBooking
     * @return \Illuminate\Http\Response
     */
    public function update(MotifRefusBookingUpdateRequest $request, MotifRefusBooking $motifRefusBooking)
    {
        $motifRefusBooking->update($request->except(['id']));
        return response()->json($motifRefusBooking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotifRefusBooking  $motifRefusBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotifRefusBooking $motifRefusBooking)
    {
        try{
            $motifRefusBooking->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
