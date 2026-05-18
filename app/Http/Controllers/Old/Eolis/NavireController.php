<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Navire;
use Illuminate\Http\Request;

class NavireController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:navirefilter')->only('filter');
        $this->middleware('permission:navirepaginate')->only('paginate');
        $this->middleware('permission:navireindex')->only('index');
        $this->middleware('permission:navirecreate')->only('store');
        $this->middleware('permission:navireshow')->only('show');
        $this->middleware('permission:navireupdate')->only('update');
        $this->middleware('permission:naviredelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\Navire::class, 'navire');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Navire::orderBy('libnavire','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libnavire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Navire::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libnavire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libnavire' => 'libnavire',
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
        return response()->json(Navire::orderBy('libnavire')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $navire = Navire::create($request->all());
        return response()->json($navire, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Navire  $navire
     * @return \Illuminate\Http\Response
     */
    public function show(Navire $navire)
    {
        $navire->load([]);
        return response()->json($navire, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Navire  $navire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Navire $navire)
    {/*
        $navire->update($request->except(['id']));
        return response()->json($navire, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Navire  $navire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navire $navire)
    {/*
        try{
            $navire->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
