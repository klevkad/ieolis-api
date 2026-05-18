<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Parc\BatterieEtatCreateRequest;
use App\Http\Requests\Old\Parc\BatterieEtatUpdateRequest;
use App\Models\Old\Parc\BatterieEtat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatterieEtatController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:batterieetatfilter')->only('filter');
        $this->middleware('permission:batterieetatpaginate')->only('paginate');
        $this->middleware('permission:batterieetatindex')->only('index');
        $this->middleware('permission:batterieetatcreate')->only('store');
        $this->middleware('permission:batterieetatshow')->only('show');
        $this->middleware('permission:batterieetatupdate')->only('update');
        $this->middleware('permission:batterieetatdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\BatterieEtat::class, 'batterie_etat');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = BatterieEtat::orderBy('libelle','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = BatterieEtat::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('enabled',1);
        }

        $displayedColumns = [
            'libelle' => 'libelle',
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
        $req = BatterieEtat::orderBy('libelle');

        if(!Auth::user()->hasRole('admin'))
        {
            $req->where('enabled',1);
        }

        return response()->json($req->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BatterieEtatCreateRequest $request)
    {
        $batterieEtat = BatterieEtat::create($request->all());
        return response()->json($batterieEtat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BatterieEtat  $batterieEtat
     * @return \Illuminate\Http\Response
     */
    public function show(BatterieEtat $batterieEtat)
    {
//        $batterieEtat->load([]);
        return response()->json($batterieEtat, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BatterieEtat  $batterieEtat
     * @return \Illuminate\Http\Response
     */
    public function update(BatterieEtatUpdateRequest $request, BatterieEtat $batterieEtat)
    {
        $batterieEtat->update($request->except(['id']));
        return response()->json($batterieEtat, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BatterieEtat  $batterieEtat
     * @return \Illuminate\Http\Response
     */
    public function destroy(BatterieEtat $batterieEtat)
    {
        try{
            $batterieEtat->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
