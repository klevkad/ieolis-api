<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\Traffic;
use Illuminate\Http\Request;

class TrafficController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Traffic::orderBy('libelle_traffic','ASC')->get(), 200);
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
     * @param  \App\Models\Old\Acconage\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function show(Traffic $traffic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Traffic $traffic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\Traffic  $traffic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Traffic $traffic)
    {
        //
    }
}
