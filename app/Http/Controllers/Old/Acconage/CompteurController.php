<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\CompteurCreateRequest;
use App\Http\Requests\Old\Acconage\CompteurUpdateRequest;
use App\Models\Old\Acconage\Compteur;
use Illuminate\Http\Request;

class CompteurController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Compteur::orderBy('anotation','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(anotation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("UPPER(numcompteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Compteur::with(['lastreleveindex'])->where('etat',1)->orderBy('anotation','ASC')->orderBy('numcompteur','ASC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompteurCreateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\Compteur  $compteur
     * @return \Illuminate\Http\Response
     */
    public function show(Compteur $compteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\Compteur  $compteur
     * @return \Illuminate\Http\Response
     */
    public function update(CompteurUpdateRequest $request, Compteur $compteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\Compteur  $compteur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compteur $compteur)
    {
        //
    }
}
