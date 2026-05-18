<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Models\Old\Parc\Typengin;
use Illuminate\Http\Request;

class TypenginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:typenginfilter')->only('filter');
        $this->middleware('permission:typenginpaginate')->only('paginate');
        $this->middleware('permission:typenginindex')->only('index');
        $this->middleware('permission:typengincreate')->only('store');
        $this->middleware('permission:typenginshow')->only('show');
        $this->middleware('permission:typenginupdate')->only('update');
        $this->middleware('permission:typengindelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\Typengin::class, 'typengin');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Typengin::orderBy('libtype','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libtype) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        return response()->json(Typengin::orderBy('codetype','ASC')->paginate(request()->size), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Typengin::orderBy('codetype','ASC')->get(), 200);
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
     * @param  \App\Models\Old\Parc\Typtypengin  $typtypengin
     * @return \Illuminate\Http\Response
     */
    public function show(Typengin $typengin)
    {
//      $typengin->load([]);
        return response()->json($typengin, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\Typtypengin  $typtypengin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Typengin $typengin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\Typtypengin  $typtypengin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Typengin $typengin)
    {
        //
    }
}
