<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\LieuApproCreateRequest;
use App\Http\Requests\Fichiers\LieuApproUpdateRequest;
use App\Models\Fichiers\LieuAppro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LieuApproController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:lieuapprofilter')->only('filter');
        $this->middleware('permission:lieuappropaginate')->only('paginate');
        $this->middleware('permission:lieuapproindex')->only('index');
        $this->middleware('permission:lieuapprocreate')->only('store');
        $this->middleware('permission:lieuapproshow')->only('show');
        $this->middleware('permission:lieuapproupdate')->only('update');
        $this->middleware('permission:lieuapprodelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\LieuAppro::class, 'lieu_appro');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = LieuAppro::with(['lieu'])->orderBy('libelle_lieu_appro','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle_lieu_appro) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = LieuAppro::with(['lieu']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle_lieu_appro) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereExists(function ($q) {
                          $q->fromRaw("EOLIS.PORT")
                            ->whereRaw("BOOKING.LIEU_APPRO.IDLIEU = EOLIS.PORT.CODEPORT")
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
            'libelle_lieu_appro' => 'libelle_lieu_appro',
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
        return response()->json(LieuAppro::orderBy('idlieu')->orderBy('libelle_lieu_appro')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LieuApproCreateRequest $request)
    {
        $lieuAppro = LieuAppro::create($request->all());
        return response()->json($lieuAppro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LieuAppro  $lieuAppro
     * @return \Illuminate\Http\Response
     */
    public function show(LieuAppro $lieuAppro)
    {
        $lieuAppro->load(['lieu']);
        return response()->json($lieuAppro, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LieuAppro  $lieuAppro
     * @return \Illuminate\Http\Response
     */
    public function update(LieuApproUpdateRequest $request, LieuAppro $lieuAppro)
    {
        $lieuAppro->update($request->except(['id']));
        $lieuAppro->load(['lieu']);
        return response()->json($lieuAppro, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LieuAppro  $lieuAppro
     * @return \Illuminate\Http\Response
     */
    public function destroy(LieuAppro $lieuAppro)
    {
        try{
            $lieuAppro->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
