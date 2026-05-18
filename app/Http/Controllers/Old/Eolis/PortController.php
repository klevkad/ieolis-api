<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:portfilter')->only('filter');
        $this->middleware('permission:portpaginate')->only('paginate');
        $this->middleware('permission:portindex')->only('index');
        $this->middleware('permission:portcreate')->only('store');
        $this->middleware('permission:portshow')->only('show');
        $this->middleware('permission:portupdate')->only('update');
        $this->middleware('permission:portdelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\Port::class, 'port');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Port::orderBy('libport','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Port::with(['lieuappros','stationempotages']);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libport' => 'libport',
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
        return response()->json(Port::orderBy('libport')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $port = Port::create($request->all());
        return response()->json($port, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Port  $port
     * @return \Illuminate\Http\Response
     */
    public function show(Port $port)
    {
        $port->load(['lieuappros','stationempotages']);
        return response()->json($port, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Port  $port
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Port $port)
    {/*
        $port->update($request->except(['id']));
        return response()->json($port, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Port  $port
     * @return \Illuminate\Http\Response
     */
    public function destroy(Port $port)
    {/*
        try{
            $port->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
