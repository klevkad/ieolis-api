<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\Username;
use Illuminate\Http\Request;

class UsernameController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:usernamefilter')->only('filter');
        $this->middleware('permission:usernamepaginate')->only('paginate');
        $this->middleware('permission:usernameindex')->only('index');
        $this->middleware('permission:usernamecreate')->only('store');
        $this->middleware('permission:usernameshow')->only('show');
        $this->middleware('permission:usernameupdate')->only('update');
        $this->middleware('permission:usernamedelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\Username::class, 'username');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Username::with(['user'])->orderBy('nomcomplet','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(nomcomplet) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('code_serv', '=', request()->searchFixe);
            }

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
        $req = Username::with(['user']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(nomcomplet) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(codeuser) LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'codeuser' => 'codeuser',
            'nomcomplet' => 'nomcomplet',
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
        return response()->json(Username::orderBy('nomcomplet')->orderBy('codeuser')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $username = Username::create($request->all());
        return response()->json($username, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Username  $username
     * @return \Illuminate\Http\Response
     */
    public function show(Username $username)
    {
        $username->load(['user']);
        return response()->json($username, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Username  $username
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Username $username)
    {/*
        $username->update($request->except(['id']));
        return response()->json($username, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Username  $username
     * @return \Illuminate\Http\Response
     */
    public function destroy(Username $username)
    {/*
        try{
            $username->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
