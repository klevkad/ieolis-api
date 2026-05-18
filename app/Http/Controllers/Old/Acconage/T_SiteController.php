<?php

namespace App\Http\Controllers\Old\Acconage;


use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\T_Site;
use App\Models\Old\Acconage\Compteur;
use Illuminate\Http\Request;

class T_SiteController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = T_Site::orderBy('lib_site','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_site) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        return response()->json(T_Site::orderBy('lib_site','ASC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(T_Site $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\T_Site  $t_site
     * @return \Illuminate\Http\Response
     */
    public function show(T_Site $t_site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\T_Site  $t_site
     * @return \Illuminate\Http\Response
     */
    public function update(T_Site $request, T_Site $t_site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\T_Site  $t_site
     * @return \Illuminate\Http\Response
     */
    public function destroy(T_Site $t_site)
    {
        //
    }
}
