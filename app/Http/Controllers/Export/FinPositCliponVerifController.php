<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Export\FinPositCliponVerif;
use Illuminate\Http\Request;

class FinPositCliponVerifController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:campagnefilter')->only('filter');
        $this->middleware('permission:campagnepaginate')->only('paginate');
        $this->middleware('permission:campagneindex')->only('index');
        $this->middleware('permission:campagnecreate')->only('store');
        $this->middleware('permission:campagneshow')->only('show');
        $this->middleware('permission:campagneupdate')->only('update');
        $this->middleware('permission:campagnedelete')->only('destroy');

        $this->authorizeResource(App\Models\FinPositCliponVerif::class, 'campagne');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = FinPositCliponVerif::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = FinPositCliponVerif::with(['localite.model','typeFinPositCliponVerif']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeFinPositCliponVerif', function (Builder $q) {
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
//            'type_campagne' => 'type_campagnes.libelle',
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
        return response()->json(FinPositCliponVerif::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinPositCliponVerifCreateRequest $request)
    {
        $finPositCliponVerif = FinPositCliponVerif::create($request->all());
        return response()->json($finPositCliponVerif, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinPositCliponVerif  $finPositCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function show(FinPositCliponVerif $finPositCliponVerif)
    {
        $finPositCliponVerif->load(['typeFinPositCliponVerif', 'localite']);
        return response()->json($finPositCliponVerif, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinPositCliponVerif  $finPositCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function update(FinPositCliponVerifUpdateRequest $request, FinPositCliponVerif $finPositCliponVerif)
    {
        $finPositCliponVerif->update($request->except(['id']));
        return response()->json($finPositCliponVerif, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinPositCliponVerif  $finPositCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinPositCliponVerif $finPositCliponVerif)
    {
        try{
            $finPositCliponVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
