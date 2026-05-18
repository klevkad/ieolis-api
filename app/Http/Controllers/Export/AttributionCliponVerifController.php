<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Export\AttributionCliponVerif;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributionCliponVerifController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:attributioncliponveriffilter')->only('filter');
        $this->middleware('permission:attributioncliponverifpaginate')->only('paginate');
        $this->middleware('permission:attributioncliponverifindex')->only('index');
        $this->middleware('permission:attributioncliponverifcreate')->only('store');
        $this->middleware('permission:attributioncliponverifshow')->only('show');
        $this->middleware('permission:attributioncliponverifupdate')->only('update');
        $this->middleware('permission:attributioncliponverifdelete')->only('destroy');

        $this->authorizeResource(App\Models\AttributionCliponVerif::class, 'attribution_clipon_verif');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = AttributionCliponVerif::with(['attributiontc'])->orderBy('idattribution_tc','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->WhereHas('attributionclipon', function (Builder $q) {
                $q->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('idclipon','ASC');
            })->limit(50);

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
        $req = AttributionCliponVerif::with(['attributiontc','attributionclipon']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereHas('attributioncliponretour', function (Builder $q) {
                    $q->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('idclipon','ASC');
                });
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
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
        return response()->json(AttributionCliponVerif::orderBy('idattribution_tc','DESC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributionCliponVerif = AttributionCliponVerif::create($request->all());
        return response()->json($attributionCliponVerif, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributionCliponVerif  $attributionCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function show(AttributionCliponVerif $attributionCliponVerif)
    {
        $attributionCliponVerif->load(['attributiontc','attributionclipon']);
        return response()->json($attributionCliponVerif, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributionCliponVerif  $attributionCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributionCliponVerif $attributionCliponVerif)
    {
        $attributionCliponVerif->update($request->except(['id']));
        return response()->json($attributionCliponVerif, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributionCliponVerif  $attributionCliponVerif
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributionCliponVerif $attributionCliponVerif)
    {
        try{
            $attributionCliponVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
