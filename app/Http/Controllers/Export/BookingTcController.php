<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\BookingTcCreateRequest;
use App\Http\Requests\Export\BookingTcUpdateRequest;
use App\Models\Export\BookingTc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookingTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:bookingtcfilter')->only('filter');
        $this->middleware('permission:bookingtcpaginate')->only('paginate');
        $this->middleware('permission:bookingtcindex')->only('index');
        $this->middleware('permission:bookingtccreate')->only('store');
        $this->middleware('permission:bookingtcshow')->only('show');
        $this->middleware('permission:bookingtcupdate')->only('update');
        $this->middleware('permission:bookingtcdelete')->only('destroy');

        $this->authorizeResource(App\Models\Export\BookingTc::class, 'booking_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = BookingTc::with(['demandebooking', 'bookingtcfinal'])->orderBy('date_posit_souhait','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("date_posit_souhait LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = BookingTc::with(['demandebooking', 'bookingtcfinal']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("nb_tcs LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("nb_tcs_def LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('demandebooking', function (Builder $q) {
                          $q->whereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('no_booking','ASC');
                        })
                      ->orWhereRaw("date_posit_souhait LIKE ?", ['%'.request()->search.'%']);
            });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('codetype_tc',request()->statut);
        }

        $displayedColumns = [
            'nb_tcs' => 'nb_tcs',
            'nb_tcs_def' => 'nb_tcs_def',
            'date_posit_souhait' => 'date_posit_souhait',
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
        return response()->json(BookingTc::orderBy('date_posit_souhait','DESC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingTcCreateRequest $request)
    {
        $bookingTc = BookingTc::create($request->all());
        return response()->json($bookingTc, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookingTc  $bookingTc
     * @return \Illuminate\Http\Response
     */
    public function show(BookingTc $bookingTc)
    {
        $bookingTc->load(['demandebooking', 'bookingtcfinal']);
        return response()->json($bookingTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingTc  $bookingTc
     * @return \Illuminate\Http\Response
     */
    public function update(BookingTcUpdateRequest $request, BookingTc $bookingTc)
    {
        $bookingTc->update($request->except(['id']));
        return response()->json($bookingTc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingTc  $bookingTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingTc $bookingTc)
    {
        try{
            $bookingTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
