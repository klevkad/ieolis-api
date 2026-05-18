<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Situation_Tc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Situation_TcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:situationtcfilter')->only('filter');
        $this->middleware('permission:situationtcpaginate')->only('paginate');
        $this->middleware('permission:situationtcindex')->only('index');
        $this->middleware('permission:situationtccreate')->only('store');
        $this->middleware('permission:situationtcshow')->only('show');
        $this->middleware('permission:situationtcupdate')->only('update');
        $this->middleware('permission:situationtcdelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\Situation_Tc::class, 'situationtc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Situation_Tc::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = Situation_Tc::with(['localite.model','typeSituation_Tc']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeSituation_Tc', function (Builder $q) {
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
//            'type_situationtc' => 'type_situationtcs.libelle',
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
        return response()->json(Situation_Tc::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $situation_Tc = Situation_Tc::create($request->all());
        return response()->json($situation_Tc, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Situation_Tc  $situation_Tc
     * @return \Illuminate\Http\Response
     */
    public function show(Situation_Tc $situation_Tc)
    {
        $situation_Tc->load(['typeSituation_Tc', 'localite']);
        return response()->json($situation_Tc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Situation_Tc  $situation_Tc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Situation_Tc $situation_Tc)
    {/*
        $situation_Tc->update($request->except(['id']));
        return response()->json($situation_Tc, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Situation_Tc  $situation_Tc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Situation_Tc $situation_Tc)
    {/*
        try{
            $situation_Tc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
