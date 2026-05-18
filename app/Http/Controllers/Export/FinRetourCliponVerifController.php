<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Export\FinRetourCliponVerif;
use Illuminate\Http\Request;

class FinRetourCliponVerifController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:finretourcliponveriffilter')->only('filter');
        $this->middleware('permission:finretourcliponverifpaginate')->only('paginate');
        $this->middleware('permission:finretourcliponverifindex')->only('index');
        $this->middleware('permission:finretourcliponverifcreate')->only('store');
        $this->middleware('permission:finretourcliponverifshow')->only('show');
        $this->middleware('permission:finretourcliponverifupdate')->only('update');
        $this->middleware('permission:finretourcliponverifdelete')->only('destroy');

        $this->authorizeResource(App\Models\Export\FinRetourCliponVerif::class, 'fin_retour_clipon_verif');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = FinRetourCliponVerif::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = FinRetourCliponVerif::with(['localite.model','typeFinRetourCliponVerif']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeFinRetourCliponVerif', function (Builder $q) {
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
//            'type_finRetourCliponVerif' => 'type_finRetourCliponVerifs.libelle',
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
        return response()->json(FinRetourCliponVerif::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinRetourCliponVerifCreateRequest $request)
    {
        $finRetourCliponVerif = FinRetourCliponVerif::create($request->all());
        return response()->json($finRetourCliponVerif, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinRetourCliponVerif  $finRetourCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function show(FinRetourCliponVerif $finRetourCliponVerif)
    {
        $finRetourCliponVerif->load(['typeFinRetourCliponVerif', 'localite']);
        return response()->json($finRetourCliponVerif, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinRetourCliponVerif  $finRetourCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function update(FinRetourCliponVerifUpdateRequest $request, FinRetourCliponVerif $finRetourCliponVerif)
    {
        $finRetourCliponVerif->update($request->except(['id']));
        return response()->json($finRetourCliponVerif, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinRetourCliponVerif  $finRetourCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinRetourCliponVerif $finRetourCliponVerif)
    {
        try{
            $finRetourCliponVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
