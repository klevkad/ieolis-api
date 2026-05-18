<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\StationEmpotageCreateRequest;
use App\Http\Requests\Fichiers\StationEmpotageUpdateRequest;
use App\Models\Fichiers\StationEmpotage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StationEmpotageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:stationempotagefilter')->only('filter');
        $this->middleware('permission:stationempotagepaginate')->only('paginate');
        $this->middleware('permission:stationempotageindex')->only('index');
        $this->middleware('permission:stationempotagecreate')->only('store');
        $this->middleware('permission:stationempotageshow')->only('show');
        $this->middleware('permission:stationempotageupdate')->only('update');
        $this->middleware('permission:stationempotagedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\StationEmpotage::class, 'station_empotage');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = StationEmpotage::with(['lieu'])->orderBy('lib_station','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_station) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('idlieu', '=', request()->searchFixe);
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
        $req = StationEmpotage::with(['empotages','lieu']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(lib_station) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereExists(function ($q) {
                          $q->fromRaw("EOLIS.PORT")
                            ->whereRaw("BOOKING.STATION_EMPOTAGE.IDLIEU = EOLIS.PORT.CODEPORT")
                            ->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
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
            'lib_station' => 'lib_station',
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
        return response()->json(StationEmpotage::orderBy('idlieu')->orderBy('lib_station')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StationEmpotageCreateRequest $request)
    {
        $stationEmpotage = StationEmpotage::create($request->all());
        $stationEmpotage->load(['lieu']);
        return response()->json($stationEmpotage, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StationEmpotage  $stationEmpotage
     * @return \Illuminate\Http\Response
     */
    public function show(StationEmpotage $stationEmpotage)
    {
        $stationEmpotage->load(['empotages', 'lieu']);
        return response()->json($stationEmpotage, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StationEmpotage  $stationEmpotage
     * @return \Illuminate\Http\Response
     */
    public function update(StationEmpotageUpdateRequest $request, StationEmpotage $stationEmpotage)
    {
        $stationEmpotage->update($request->except(['id']));
        $stationEmpotage->load(['lieu']);
        return response()->json($stationEmpotage, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StationEmpotage  $stationEmpotage
     * @return \Illuminate\Http\Response
     */
    public function destroy(StationEmpotage $stationEmpotage)
    {
        try{
            $stationEmpotage->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
