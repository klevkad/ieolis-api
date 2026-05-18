<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\ParamTcReeferCreateRequest;
use App\Http\Requests\Export\ParamTcReeferUpdateRequest;
use App\Models\Export\ParamTcReefer;
use Illuminate\Http\Request;

class ParamTcReeferController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:paramtcreeferfilter')->only('filter');
        $this->middleware('permission:paramtcreeferpaginate')->only('paginate');
        $this->middleware('permission:paramtcreeferindex')->only('index');
        $this->middleware('permission:paramtcreefercreate')->only('store');
        $this->middleware('permission:paramtcreefershow')->only('show');
        $this->middleware('permission:paramtcreeferupdate')->only('update');
        $this->middleware('permission:paramtcreeferdelete')->only('destroy');

        $this->authorizeResource(App\Models\ParamTcReefer::class, 'param_tc_reefer');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = ParamTcReefer::with(['localite.model'])->orderBy('libelle','ASC');

        if(!Auth::user()->isAdmin()) {
            $req->where('enabled','=',1);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('localite_id', '=', request()->searchFixe);
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
        $req = ParamTcReefer::with(['localite.model','typeParamTcReefer']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeParamTcReefer', function (Builder $q) {
                          $q->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libelle','ASC');
                        })
                      ->orWhereRaw("inscrits LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libelle' => 'libelle',
            'annee' => 'annee',
            'inscrits' => 'inscrits',
//            'type_paramTcReefer' => 'type_paramTcReefers.libelle',
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
        return response()->json(ParamTcReefer::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ParamTcReeferCreateRequest $request)
    {
        $paramTcReefer = ParamTcReefer::create($request->all());
        return response()->json($paramTcReefer, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParamTcReefer  $paramTcReefer
     * @return \Illuminate\Http\Response
     */
    public function show(ParamTcReefer $paramTcReefer)
    {
        $paramTcReefer->load(['typeParamTcReefer', 'localite']);
        return response()->json($paramTcReefer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParamTcReefer  $paramTcReefer
     * @return \Illuminate\Http\Response
     */
    public function update(ParamTcReeferUpdateRequest $request, ParamTcReefer $paramTcReefer)
    {
        $paramTcReefer->update($request->except(['id']));
        return response()->json($paramTcReefer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParamTcReefer  $paramTcReefer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParamTcReefer $paramTcReefer)
    {
        try{
            $paramTcReefer->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
