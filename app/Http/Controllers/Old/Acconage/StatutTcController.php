<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\StatutTc;
use Illuminate\Http\Request;

class StatutTcController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = StatutTc::orderBy('lib_statu_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_statu_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        return response()->json(StatutTc::orderBy('lib_statu_tc','ASC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\StatutTc  $statutTc
     * @return \Illuminate\Http\Response
     */
    public function show(StatutTc $statutTc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\StatutTc  $statutTc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatutTc $statutTc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\StatutTc  $statutTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatutTc $statutTc)
    {
        //
    }
}
