<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\CompteurCreateRequest;
use App\Http\Requests\Old\Acconage\CompteurEauUpdateRequest;
use App\Models\Old\Acconage\CompteurEau;
use Illuminate\Http\Request;

class CompteurEauController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = CompteurEau::orderBy('designation','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(designation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("UPPER(numcpteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        return response()->json(CompteurEau::with(['lastreleveindex'])->orderBy('designation','ASC')->orderBy('numcpteur','ASC')->get(), 200);
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
     * @param  \App\Models\Old\Acconage\CompteurEau  $compteurEau
     * @return \Illuminate\Http\Response
     */
    public function show(CompteurEau $compteurEau)
    {
        $compteurEau->load(['lastreleveindex']);
        return response()->json($compteurEau, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\CompteurEau  $compteurEau
     * @return \Illuminate\Http\Response
     */
    public function update(CompteurEauUpdateRequest $request, CompteurEau $compteurEau)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\CompteurEau  $compteurEau
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompteurEau $compteurEau)
    {
        //
    }
}
