<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\ReleveShift;
use Illuminate\Http\Request;

class ReleveShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ReleveShift::orderBy('lib_shift','ASC')->get(), 200);
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
     * @param  \App\Models\Old\Acconage\ReleveShift  $releveShift
     * @return \Illuminate\Http\Response
     */
    public function show(ReleveShift $releveShift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\ReleveShift  $releveShift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReleveShift $releveShift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\ReleveShift  $releveShift
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReleveShift $releveShift)
    {
        //
    }
}
