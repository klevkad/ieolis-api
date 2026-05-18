<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\BookingTcFinalCreateRequest;
use App\Http\Requests\Export\BookingTcFinalUpdateRequest;
use App\Models\Export\BookingTcFinal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookingTcFinalController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:bookingtcfinalfilter')->only('filter');
        $this->middleware('permission:bookingtcfinalpaginate')->only('paginate');
        $this->middleware('permission:bookingtcfinalindex')->only('index');
        $this->middleware('permission:bookingtcfinalcreate')->only('store');
        $this->middleware('permission:bookingtcfinalshow')->only('show');
        $this->middleware('permission:bookingtcfinalupdate')->only('update');
        $this->middleware('permission:bookingtcfinaldelete')->only('destroy');

        $this->authorizeResource(App\Models\Export\BookingTcFinal::class, 'booking_tc_final');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = BookingTcFinal::with(['demandebooking','bookingtc'])->orderBy('nobookingfin','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(nobookingfin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = BookingTcFinal::with(['demandebooking','bookingtc']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_declaration) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("poids_brut LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("volume LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("nobookingfin LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("plom1 LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("plom2 LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('demandebooking', function (Builder $q) {
                          $q->whereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('no_booking','ASC');
                        })
                      ->orWhereRaw("plein_vide LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'no_declaration' => 'no_declaration',
            'poids_brut' => 'poids_brut',
            'volume' => 'volume',
            'nobookingfin' => 'nobookingfin',
            'plomb1' => 'plom1',
            'plomb2' => 'plom2',
            'plein_vide' => 'plein_vide',
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
        return response()->json(BookingTcFinal::orderBy('nobookingfin','DESC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingTcFinalCreateRequest $request)
    {
        $bookingTcFinal = BookingTcFinal::create($request->all());
        return response()->json($bookingTcFinal, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingTcFinal  $bookingTcFinal
     * @return \Illuminate\Http\Response
     */
    public function show(BookingTcFinal $bookingTcFinal)
    {
        $bookingTcFinal->load(['demandebooking','bookingtc']);
        return response()->json($bookingTcFinal, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingTcFinal  $bookingTcFinal
     * @return \Illuminate\Http\Response
     */
    public function update(BookingTcFinalUpdateRequest $request, BookingTcFinal $bookingTcFinal)
    {
        $bookingTcFinal->update($request->except(['id']));
        return response()->json($bookingTcFinal, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingTcFinal  $bookingTcFinal
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingTcFinal $bookingTcFinal)
    {
        try{
            $bookingTcFinal->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
