<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engins\OiCreateRequest;
use App\Http\Requests\Engins\OiUpdateRequest;
use App\Models\Old\Parc\OI;
use Illuminate\Http\Request;

class OIController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = OI::orderBy('dateheure_declaration','DESC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(code_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = OI::with(['operationtechniques','pieces']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(description_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(date_deb_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(date_fin_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(index_cpteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(type_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(code_interv) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(dateheure_declaration) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(code_type_ent) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(comment_qualite) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(lieu_panne) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(matricule) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(idot) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }    
        
        //1 => OIP; 2 => OIC
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('type_interv',request()->statut);
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'lieu_panne' => 'lieu_panne',
            'description_interv' => 'description_interv',
            'date_deb_interv' => 'date_deb_interv',
            'date_fin_interv' => 'date_fin_interv',
            'index_cpteur' => 'index_cpteur',
            'type_interv' => 'type_interv',
            'code_interv' => 'code_interv',
            'dateheure_declaration' => 'dateheure_declaration',
            'code_type_ent' => 'code_type_ent',
            'comment_qualite' => 'comment_qualite',
            'lieu_panne' => 'lieu_panne',
            'matricule' => 'matricule',
            'idot' => 'idot',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder)->orderBy('code_interv',$sortorder);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OiCreateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return \Illuminate\Http\Response
     */
    public function show(OI $oI)
    {
        $oI->load(['operationtechniques','pieces']);
        return response()->json($oI, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return \Illuminate\Http\Response
     */
    public function update(OiUpdateRequest $request, OI $oI)
    {
        $oI->update($request->except(['id']));
        return response()->json($oI, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\OI  $oI
     * @return \Illuminate\Http\Response
     */
    public function destroy(OI $oI)
    {
        try{
            $oI->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
