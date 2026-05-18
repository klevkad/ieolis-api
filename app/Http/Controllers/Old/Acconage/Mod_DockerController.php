<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\Mod_Docker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Mod_DockerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $req = Mod_Docker::orderBy('nom')->orderBy('prenoms');

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('statut',1);
        }

        return response()->json($req->get(), 200);
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
     * @param  \App\Models\Old\Acconage\Mod_Docker  $mod_Docker
     * @return \Illuminate\Http\Response
     */
    public function show(Mod_Docker $mod_Docker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\Mod_Docker  $mod_Docker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mod_Docker $mod_Docker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\Mod_Docker  $mod_Docker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mod_Docker $mod_Docker)
    {
        //
    }
}
