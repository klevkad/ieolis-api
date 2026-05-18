<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\AttributionCliponRetourCreateRequest;
use App\Http\Requests\Export\AttributionCliponRetourUpdateRequest;
use App\Models\Export\AttributionCliponRetour;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributionCliponRetourController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:attributioncliponretourfilter')->only('filter');
        $this->middleware('permission:attributioncliponretourpaginate')->only('paginate');
        $this->middleware('permission:attributioncliponretourindex')->only('index');
        $this->middleware('permission:attributioncliponretourcreate')->only('store');
        $this->middleware('permission:attributioncliponretourshow')->only('show');
        $this->middleware('permission:attributioncliponretourupdate')->only('update');
        $this->middleware('permission:attributioncliponretourdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\AttributionCliponRetour::class, 'attribution_clipon_retour');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = AttributionCliponRetour::with(['retourtc'])->orderBy('idretour_conteneur','DESC');

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
        $req = AttributionCliponRetour::with(['approcarburant','retourtc','attributioncliponretourverif']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(dateh_arret_clip) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(idclipon) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("qte_appro_clip LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("UPPER(bon_appro_clip) LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'dateh_arret_clip' => 'dateh_arret_clip',
            'idclipon' => 'idclipon',
            'qte_appro_clip' => 'qte_appro_clip',
            'bon_appro_clip' => 'bon_appro_clip',
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
        return response()->json(AttributionCliponRetour::orderBy('dateh_arret_clip','DESC')->orderBy('idclipon')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributionCliponRetourCreateRequest $request)
    {
        $attributionCliponRetour = AttributionCliponRetour::create($request->all());
        if($request->qte_appro && $request->qte_appro > 0)
        {
            $attributionCliponRetour->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                'idengin' => $request->idclipon,
                'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
            ]);
        }
        return response()->json($attributionCliponRetour, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributionCliponRetour  $attributionCliponRetour
     * @return \Illuminate\Http\Response
     */
    public function show(AttributionCliponRetour $attributionCliponRetour)
    {
        $attributionCliponRetour->load(['attributioncliponretourverif', 'retourtc','approcarburant']);
        return response()->json($attributionCliponRetour, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributionCliponRetour  $attributionCliponRetour
     * @return \Illuminate\Http\Response
     */
    public function update(AttributionCliponRetourUpdateRequest $request, AttributionCliponRetour $attributionCliponRetour)
    {
        if($request->dateh_arret_clip)
        {
            $request->merge([
                'dateh_arret_clip' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_arret_clip)->toDateTimeString()
            ]);

            $attributionCliponRetour->update($request->all());

            $attributionCliponRetour->dateh_arret_clip = Carbon::createFromFormat('Y-m-d H:i:s', $attributionCliponRetour->dateh_arret_clip)->format('Y-m-d\TH:i:s.u\Z');
        }
        else
        {
            $attributionCliponRetour->update($request->all());
        }

        if($request->qte_appro && $request->qte_appro > 0)
        {
            if($attributionCliponRetour->approcarburant)
            {
                $attributionCliponRetour->approcarburant->update($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                    'idengin' => $request->idclipon,
                    'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                ]);
            }
            else
            {
                $attributionCliponRetour->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                    'idengin' => $request->idclipon,
                    'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                ]);
            }
        }
        else
        {
            $attributionCliponRetour->approcarburant()->delete();
        }

        return response()->json($attributionCliponRetour, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributionCliponRetour  $attributionCliponRetour
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributionCliponRetour $attributionCliponRetour)
    {
        try{
            $attributionCliponRetour->approcarburant()->delete();
            $attributionCliponRetour->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
