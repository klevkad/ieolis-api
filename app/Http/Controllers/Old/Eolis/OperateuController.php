<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Operateu;
use Illuminate\Http\Request;

class OperateuController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:operateufilter')->only('filter');
        $this->middleware('permission:operateupaginate')->only('paginate');
        $this->middleware('permission:operateuindex')->only('index');
        $this->middleware('permission:operateucreate')->only('store');
        $this->middleware('permission:operateushow')->only('show');
        $this->middleware('permission:operateuupdate')->only('update');
        $this->middleware('permission:operateudelete')->only('destroy');

        $this->authorizeResource(Operateu::class, 'operateu');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Operateu::orderBy('liboper','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Operateu::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'liboper' => 'liboper',
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
        return response()->json(Operateu::orderBy('liboper')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $operateu = Operateu::create($request->all());
        return response()->json($operateu, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Operateu  $operateu
     * @return \Illuminate\Http\Response
     */
    public function show(Operateu $operateu)
    {
        $operateu->load([]);
        return response()->json($operateu, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Operateu  $operateu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Operateu $operateu)
    {/*
        $operateu->update($request->except(['id']));
        return response()->json($operateu, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Operateu  $operateu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operateu $operateu)
    {/*
        try{
            $operateu->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
