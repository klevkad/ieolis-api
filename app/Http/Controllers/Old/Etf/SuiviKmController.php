<?php

namespace App\Http\Controllers\Old\Etf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engins\SuiviKmCreateRequest;
use App\Http\Requests\Engins\SuiviKmUpdateRequest;
use App\Models\Old\Etf\SuiviKm;
use Illuminate\Http\Request;

class SuiviKmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(SuiviKm::orderBy('created_at','DESC')->get(), 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = SuiviKm::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(curdate) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(prevdate) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(cptkm) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(nbrtcv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(nbrtcp) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(qtecarb) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(nbrhrtrav) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('codetype',request()->statut);
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'curdate' => 'curdate',
            'prevdate' => 'prevdate',
            'cptkm' => 'cptkm',
            'nbrtcv' => 'nbrtcv',
            'nbrtcp' => 'nbrtcp',
            'qtecarb' => 'qtecarb',
            'nbrhrtrav' => 'nbrhrtrav',
            'created_at' => 'created_at',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SuiviKmCreateRequest $request)
    {
        $suiviKm = SuiviKm::create($request->all());
        return response()->json($suiviKm, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Parc\SuiviKm  $suiviKm
     * @return \Illuminate\Http\Response
     */
    public function show(SuiviKm $suiviKm)
    {
        $suiviKm->load([]);
        return response()->json($suiviKm, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\SuiviKm  $suiviKm
     * @return \Illuminate\Http\Response
     */
    public function update(SuiviKmUpdateRequest $request, SuiviKm $suiviKm)
    {
        $suiviKm->update($request->except(['id']));
        return response()->json($suiviKm, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\SuiviKm  $suiviKm
     * @return \Illuminate\Http\Response
     */
    public function destroy(SuiviKm $suiviKm)
    {
        try{
            $suiviKm->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
