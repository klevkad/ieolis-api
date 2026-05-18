<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:produitfilter')->only('filter');
        $this->middleware('permission:produitpaginate')->only('paginate');
        $this->middleware('permission:produitindex')->only('index');
        $this->middleware('permission:produitcreate')->only('store');
        $this->middleware('permission:produitshow')->only('show');
        $this->middleware('permission:produitupdate')->only('update');
        $this->middleware('permission:produitdelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\Produit::class, 'produit');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Produit::orderBy('lib_produit','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_produit) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Produit::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(lib_produit) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'lib_produit' => 'lib_produit',
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
        return response()->json(Produit::orderBy('lib_produit')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $produit = Produit::create($request->all());
        return response()->json($produit, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        $produit->load([]);
        return response()->json($produit, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {/*
        $produit->update($request->except(['id']));
        return response()->json($produit, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {/*
        try{
            $produit->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
