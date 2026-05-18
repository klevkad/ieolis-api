<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Export\AttributionCliponRetourVerif;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributionCliponRetourVerifController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:attributioncliponretourveriffilter')->only('filter');
        $this->middleware('permission:attributioncliponretourverifpaginate')->only('paginate');
        $this->middleware('permission:attributioncliponretourverifindex')->only('index');
        $this->middleware('permission:attributioncliponretourverifcreate')->only('store');
        $this->middleware('permission:attributioncliponretourverifshow')->only('show');
        $this->middleware('permission:attributioncliponretourverifupdate')->only('update');
        $this->middleware('permission:attributioncliponretourverifdelete')->only('destroy');

        $this->authorizeResource(App\Models\Export\AttributionCliponRetourVerif::class, 'attribution_clipon_retour_verif');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = AttributionCliponRetourVerif::with(['attributioncliponretour'])->orderBy('idretour_conteneur','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->WhereHas('attributioncliponretour', function (Builder $q) {
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
        $req = AttributionCliponRetourVerif::with(['attributioncliponretour']);

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
        return response()->json(AttributionCliponRetourVerif::orderBy('idretour_conteneur','DESC')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributionCliponRetourVerif = AttributionCliponRetourVerif::create($request->all());
        return response()->json($attributionCliponRetourVerif, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return \Illuminate\Http\Response
     */
    public function show(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        $attributionCliponRetourVerif->load(['attributioncliponretour']);
        return response()->json($attributionCliponRetourVerif, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        $attributionCliponRetourVerif->update($request->except(['id']));
        return response()->json($attributionCliponRetourVerif, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributionCliponRetourVerif  $attributionCliponRetourVerif
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributionCliponRetourVerif $attributionCliponRetourVerif)
    {
        try{
            $attributionCliponRetourVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
