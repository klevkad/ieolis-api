<?php

namespace App\Http\Controllers\Engins;

use App\Http\Controllers\Controller;
use App\Models\Export\AttributionClipon;
use App\Models\Export\AttributionCliponRetour;
use App\Models\Export\AttributionCliponVerif;
use App\Models\Export\AttributionTc;
use App\Models\Export\FinRetourCliponVerif;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ControleGensetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = AttributionTc::has('attributionclipon')->with([
            'attributionclipon.attributioncliponverif', 
            'positionnementtc.finpositcliponverif',
            'retourtc.finretour',
            'retourtc.attributionclipon.attributioncliponretourverif',
            'bookingtc.demandebooking'
        ]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('bookingtc.demandebooking', function (Builder $q) {
                        $q->whereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereHas('attributionclipon', function (Builder $q) {
                        $q->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereHas('retourtc.attributionclipon', function (Builder $q) {
                        $q->whereRaw("UPPER(idclipon) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      });
            });
        }

        if(request()->has('statut') && is_numeric(request()->statut) && request()->statut >= -1 && request()->statut <= 1 )
        {
           // $req->where('si_valider','=',request()->statut);
        }

        $displayedColumns = [
            'no_tc' => 'no_tc',
            'date_dmd' => 'date_demande',
            'no_booking' => 'dateh_saisie',
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
    public function storeDepart(Request $request, AttributionClipon $attributionClipon)
    {
        $attributionClipon->attributioncliponverif()->create($request->all());

        return response()->json($attributionClipon->attributioncliponverif, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFinRetour(Request $request, AttributionCliponRetour $attributionCliponRetour)
    {
        $attributionCliponRetour->finretourcliponverif()->create($request->all());

        return response()->json($attributionCliponRetour->finretourcliponverif, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking\ControleGenSet  $controlGenSet
     * @return \Illuminate\Http\Response
     */
    public function updateDepart(Request $request, AttributionCliponVerif $attributionCliponVerif)
    {
        $attributionCliponVerif->update($request->all());

        return response()->json($attributionCliponVerif, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking\ControleGenSet  $controlGenSet
     * @return \Illuminate\Http\Response
     */
    public function updateFinRetour(Request $request, FinRetourCliponVerif $finRetourCliponVerif)
    {
        $finRetourCliponVerif->update($request->all());

        return response()->json($finRetourCliponVerif, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking\ControleGenSet  $controlGenSet
     * @return \Illuminate\Http\Response
     */
    public function destroyDepart(AttributionCliponVerif $attributionCliponVerif)
    {
        try{
            $attributionCliponVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking\ControleGenSet  $controlGenSet
     * @return \Illuminate\Http\Response
     */
    public function destroyFinRetour(FinRetourCliponVerif $finRetourCliponVerif)
    {
        try{
            $finRetourCliponVerif->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
