<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\ReleveIndexEauCreateRequest;
use App\Http\Requests\Old\Acconage\ReleveIndexEauUpdateRequest;
use App\Models\Old\Acconage\ReleveIndexEau;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReleveIndexEauController extends Controller
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
        $req = ReleveIndexEau::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(numcpteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("datereleve LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("indexdebut LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("indexfin LIKE ?", ['%'.request()->search.'%'])
                ->orWhereRaw("UPPER(codeuser) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereHas('compteur', function (Builder $q) {
                    $q->whereRaw("UPPER(designation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('numcpteur',request()->statut);
        }

        $displayedColumns = [
            'numcpteur' => 'numcpteur',
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
    public function store(ReleveIndexEauCreateRequest $request)
    {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $prevRlvIdxEau = ReleveIndexEau::find($request->idt_releve_eau);
        $releveIndexEau = ReleveIndexEau::create($request->only(['indexfin','numcpteur']) + [
            'datereleve' => $yesterday,
            'indexdebut' => $prevRlvIdxEau->indexfin,
            'datesaisie' => $today,
            'codeuser' => Auth::user()->model->codeuser,
        ]);
        return response()->json($releveIndexEau, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\ReleveIndexEau  $releveIndexEau
     * @return \Illuminate\Http\Response
     */
    public function show(ReleveIndexEau $releveIndexEau)
    {
        return response()->json($releveIndexEau, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\ReleveIndexEau  $releveIndexEau
     * @return \Illuminate\Http\Response
     */
    public function update(ReleveIndexEauUpdateRequest $request, ReleveIndexEau $releveIndexEau)
    {
        $releveIndexEau->append('next');
        if($releveIndexEauNext = $releveIndexEau->next)
        {
            $releveIndexEauNext->update(['indexdebut' => $request->indexfin]);
        }
        $releveIndexEau->update($request->except(['id']));
        return response()->json($releveIndexEau, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\ReleveIndexEau  $releveIndexEau
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleveIndexEau $releveIndexEau)
    {
        try{
            $releveIndexEau->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
