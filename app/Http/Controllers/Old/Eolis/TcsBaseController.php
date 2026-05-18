<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\TcsBase;
use Illuminate\Http\Request;

class TcsBaseController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('permission:tcsbasefilter')->only('filter');
        // $this->middleware('permission:tcsbasepaginate')->only('paginate');
        // $this->middleware('permission:tcsbaseindex')->only('index');
        // $this->middleware('permission:tcsbasecreate')->only('store');
        // $this->middleware('permission:tcsbaseshow')->only('show');
        // $this->middleware('permission:tcsbaseupdate')->only('update');
        // $this->middleware('permission:tcsbasedelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\TcsBase::class, 'tcs_base');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = TcsBase::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('type_tc', '=', request()->searchFixe);
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
        $req = TcsBase::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'no_tc' => 'no_tc',
            'type_tc' => 'type_tc',
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
        return response()->json(TcsBase::orderBy('no_tc')->orderBy('type_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $tcsBase = TcsBase::create($request->all());
        return response()->json($tcsBase, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TcsBase  $tcsBase
     * @return \Illuminate\Http\Response
     */
    public function show(TcsBase $tcsBase)
    {
        $tcsBase->load([]);
        return response()->json($tcsBase, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TcsBase  $tcsBase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TcsBase $tcsBase)
    {/*
        $tcsBase->update($request->except(['id']));
        return response()->json($tcsBase, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TcsBase  $tcsBase
     * @return \Illuminate\Http\Response
     */
    public function destroy(TcsBase $tcsBase)
    {/*
        try{
            $tcsBase->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
