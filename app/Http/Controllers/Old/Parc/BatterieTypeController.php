<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Parc\BatterieTypeCreateRequest;
use App\Http\Requests\Old\Parc\BatterieTypeUpdateRequest;
use App\Models\Old\Parc\BatterieType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatterieTypeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:batterietypefilter')->only('filter');
        $this->middleware('permission:batterietypepaginate')->only('paginate');
        $this->middleware('permission:batterietypeindex')->only('index');
        $this->middleware('permission:batterietypecreate')->only('store');
        $this->middleware('permission:batterietypeshow')->only('show');
        $this->middleware('permission:batterietypeupdate')->only('update');
        $this->middleware('permission:batterietypedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\BatterieType::class, 'batterie_type');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = BatterieType::orderBy('libelle','ASC');

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
        $req = BatterieType::with([]);

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
        $req = BatterieType::orderBy('libelle');

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
    public function store(BatterieTypeCreateRequest $request)
    {
        $batterieType = BatterieType::create($request->all());
        return response()->json($batterieType, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BatterieType  $batterieType
     * @return \Illuminate\Http\Response
     */
    public function show(BatterieType $batterieType)
    {
//        $batterieType->load([]);
        return response()->json($batterieType, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BatterieType  $batterieType
     * @return \Illuminate\Http\Response
     */
    public function update(BatterieTypeUpdateRequest $request, BatterieType $batterieType)
    {
        $batterieType->update($request->except(['id']));
        return response()->json($batterieType, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BatterieType  $batterieType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BatterieType $batterieType)
    {
        try{
            $batterieType->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
