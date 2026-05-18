<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\ReleveIndexCompteurCreateRequest;
use App\Http\Requests\Old\Acconage\ReleveIndexCompteurUpdateRequest;
use App\Models\Old\Acconage\ReleveIndexCompteur;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleveIndexCompteurController extends Controller
{
    public $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = ReleveIndexCompteur::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(numcompteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("datereleve LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("indexdebut LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("indexfin LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("UPPER(codeuser) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereHas('compteur', function (Builder $q) {
                    $q->whereRaw("UPPER(anotation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('numcompteur',request()->statut);
        }

        $displayedColumns = [
            'numcompteur' => 'numcompteur',
            'datereleve' => 'datereleve',
            'indexdebut' => 'indexdebut',
            'indexfin' => 'indexfin',
            'codeuser' => 'codeuser',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReleveIndexCompteurCreateRequest $request)
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $prevRlvIdxCptr = ReleveIndexCompteur::find($request->idt_releve_index_compteur);
        $releveIndexCompteur = ReleveIndexCompteur::create($request->only(['indexfin','numcompteur']) + [
            'numsemaine' => date('W',$yesterday),
            'nummois' => $this->months[date('n', $yesterday) - 1],
            'numjour' => $this->days[date('w', $yesterday)],
            'datereleve' => $yesterday,
            'indexdebut' => $prevRlvIdxCptr->indexfin,
            'consojrnl' => $request->indexfin - $prevRlvIdxCptr->indexfin,
            'numerodumois' => date('n', $yesterday),
            'pourcenteolis' => 0,
            'consoeolis' => 100,
            'consosmpa' => 0,
            'datesaisie' => $today,
            'codeuser' => Auth::user()->model->codeuser,
        ]);
        return response()->json($releveIndexCompteur, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\ReleveIndexCompteur  $releveIndexCompteur
     * @return \Illuminate\Http\Response
     */
    public function show(ReleveIndexCompteur $releveIndexCompteur)
    {
        return response()->json($releveIndexCompteur, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\ReleveIndexCompteur  $releveIndexCompteur
     * @return \Illuminate\Http\Response
     */
    public function update(ReleveIndexCompteurUpdateRequest $request, ReleveIndexCompteur $releveIndexCompteur)
    {
        $releveIndexCompteur->append('next');
        if($releveIndexCompteurNext = $releveIndexCompteur->next)
        {
            $releveIndexCompteurNext->update(['indexdebut' => $request->indexfin]);
        }
        $releveIndexCompteur->update($request->except(['id']) + [
            'consojrnl' => $request->indexfin - $releveIndexCompteur->indexdebut,
        ]);
        return response()->json($releveIndexCompteur, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\ReleveIndexCompteur  $releveIndexCompteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleveIndexCompteur $releveIndexCompteur)
    {
        try{
            $releveIndexCompteur->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
