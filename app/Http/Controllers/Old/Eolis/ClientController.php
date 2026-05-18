<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:clientfilter')->only('filter');
        $this->middleware('permission:clientpaginate')->only('paginate');
        $this->middleware('permission:clientindex')->only('index');
        $this->middleware('permission:clientcreate')->only('store');
        $this->middleware('permission:clientshow')->only('show');
        $this->middleware('permission:clientupdate')->only('update');
        $this->middleware('permission:clientdelete')->only('destroy');

        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Client::orderBy('lib_cli','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_cli) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        //
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
     * @param  \App\Models\Old\Eolis\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Eolis\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Eolis\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
