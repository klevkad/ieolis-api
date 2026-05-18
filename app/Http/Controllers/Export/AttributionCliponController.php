<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\AttributionCliponCreateRequest;
use App\Http\Requests\Export\AttributionCliponUpdateRequest;
use App\Models\Export\AttributionClipon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributionCliponController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:attributioncliponfilter')->only('filter');
        $this->middleware('permission:attributioncliponpaginate')->only('paginate');
        $this->middleware('permission:attributioncliponindex')->only('index');
        $this->middleware('permission:attributioncliponcreate')->only('store');
        $this->middleware('permission:attributioncliponshow')->only('show');
        $this->middleware('permission:attributioncliponupdate')->only('update');
        $this->middleware('permission:attributionclipondelete')->only('destroy');

        $this->authorizeResource(App\Models\Export\AttributionClipon::class, 'attribution_clipon');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = AttributionClipon::with(['attributiontc'])->orderBy('idattribution_tc','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = AttributionClipon::with(['attributioncliponverif','attributiontc','approcarburant']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("qte_appro LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('attributiontc', function (Builder $q) {
                          $q->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('no_tc','ASC');
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
            'idclipon' => 'idclipon',
            'qte_appro' => 'qte_appro',
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
        return response()->json(AttributionClipon::orderBy('idattribution_tc')->orderBy('idclipon')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributionCliponCreateRequest $request)
    {
        $attributionClipon = AttributionClipon::create($request->all());
        if($request->qte_appro && $request->qte_appro > 0)
        {
            $attributionClipon->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                'idengin' => $request->idclipon,
                'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
            ]);
        }
        return response()->json($attributionClipon, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributionClipon  $attributionClipon
     * @return \Illuminate\Http\Response
     */
    public function show(AttributionClipon $attributionClipon)
    {
        $attributionClipon->load(['attributioncliponverif', 'attributiontc']);
        return response()->json($attributionClipon, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributionClipon  $attributionClipon
     * @return \Illuminate\Http\Response
     */
    public function update(AttributionCliponUpdateRequest $request, AttributionClipon $attributionClipon)
    {
        $attributionClipon->update($request->except(['id']));
        if($request->qte_appro && $request->qte_appro > 0)
        {
            if($attributionClipon->approcarburant)
            {
                $attributionClipon->approcarburant->update($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                    'idengin' => $request->idclipon,
                    'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                ]);
            }
            else
            {
                $attributionClipon->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                    'idengin' => $request->idclipon,
                    'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                ]);
            }
        }
        else
        {
            $attributionClipon->approcarburant()->delete();
        }
        return response()->json($attributionClipon, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributionClipon  $attributionClipon
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributionClipon $attributionClipon)
    {
        try{
            $attributionClipon->approcarburant()->delete();
            $attributionClipon->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
