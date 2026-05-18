<?php

namespace App\Http\Controllers\Fichiers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fichiers\ChauffeurCreateRequest;
use App\Http\Requests\Fichiers\ChauffeurUpdateRequest;
use App\Models\Fichiers\Chauffeur;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ChauffeurController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:chauffeurfilter')->only('filter');
        $this->middleware('permission:chauffeurpaginate')->only('paginate');
        $this->middleware('permission:chauffeurindex')->only('index');
        $this->middleware('permission:chauffeurcreate')->only('store');
        $this->middleware('permission:chauffeurshow')->only('show');
        $this->middleware('permission:chauffeurupdate')->only('update');
        $this->middleware('permission:chauffeurdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Fichiers\Chauffeur::class, 'chauffeur');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Chauffeur::with(['transporteur'])->orderBy('nom_chauffeur','ASC')->orderBy('prenom_chauffeur','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(CONCAT(nom_chauffeur, CONCAT(' ', prenom_chauffeur))) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('idtransporteur', '=', request()->searchFixe);
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
        $req = Chauffeur::with(['transporteur']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(nom_chauffeur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(tel_mob) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("UPPER(no_pc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('transporteur', function (Builder $q) {
                          $q->whereRaw("UPPER(lib_transporteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereRaw("UPPER(prenom_chauffeur) LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'nom_chauffeur' => 'nom_chauffeur',
            'prenom_chauffeur' => 'prenom_chauffeur',
            'no_pc' => 'no_pc',
            'tel_mob' => 'tel_mob',
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
        return response()->json(Chauffeur::orderBy('nom_chauffeur')->orderBy('prenom_chauffeur')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChauffeurCreateRequest $request)
    {
        $chauffeur = Chauffeur::create($request->all());
        return response()->json($chauffeur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chauffeur  $chauffeur
     * @return \Illuminate\Http\Response
     */
    public function show(Chauffeur $chauffeur)
    {
        $chauffeur->load(['transporteur']);
        return response()->json($chauffeur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chauffeur  $chauffeur
     * @return \Illuminate\Http\Response
     */
    public function update(ChauffeurUpdateRequest $request, Chauffeur $chauffeur)
    {
        $chauffeur->update($request->except(['id']));
        $chauffeur->load(['transporteur']);
        return response()->json($chauffeur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chauffeur  $chauffeur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chauffeur $chauffeur)
    {
        try{
            $chauffeur->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
