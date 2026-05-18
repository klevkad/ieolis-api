<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\RetourTcCreateRequest;
use App\Http\Requests\Export\RetourTcUpdateRequest;
use App\Models\Export\RetourTc;
use App\Models\Export\RetourTcMain;
use App\Models\Export\RetourTcPropreMoyen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class RetourTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:retourtcfilter')->only('filter');
        $this->middleware('permission:retourtcpaginate')->only('paginate');
        $this->middleware('permission:retourtcindex')->only('index');
        $this->middleware('permission:retourtccreate')->only('store');
        $this->middleware('permission:retourtcshow')->only('show');
        $this->middleware('permission:retourtcupdate')->only('update');
        $this->middleware('permission:retourtcdelete')->only('destroy');
        $this->middleware('permission:retourtcpropremoyencreate')->only('storePropreMoyen');
        $this->middleware('permission:retourtcpropremoyenshow')->only('showPropreMoyen');
        $this->middleware('permission:retourtcpropremoyenupdate')->only('updatePropreMoyen');
        $this->middleware('permission:retourtcpropremoyendelete')->only('destroyPropreMoyen');

        $this->authorizeResource(\App\Models\Export\RetourTc::class, 'retour_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = RetourTc::with(['transporteur'])->orderBy('libelle','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(num_plom_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('idcamion', '=', request()->searchFixe);
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
        $req = RetourTc::with(['transporteur','approcarburant']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(bon_appro_cam) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(num_plom_tc) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("UPPER(compteur_sorti_cam) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereRaw("UPPER(qte_appro_cam) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('transporteur', function (Builder $q) {
                          $q->whereRaw("UPPER(lib_transporteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('lib_transporteur','ASC');
                        })
                      ->orWhereRaw("UPPER(dateh_sorti_cam) LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'bon_appro_cam' => 'bon_appro_cam',
            'num_plom_tc' => 'num_plom_tc',
            'compteur_sorti_cam' => 'compteur_sorti_cam',
            'qte_appro_cam' => 'qte_appro_cam',
            'dateh_sorti_cam' => 'dateh_sorti_cam',
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
        return response()->json(RetourTc::get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RetourTcCreateRequest $request)
    {
        $request->merge([
            'dateh_sorti_cam' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sorti_cam)->toDateTimeString(),
        ]);
        
        $retourTcMain = RetourTcMain::create([
            'model_type' => 'App\Models\Export\RetourTc'
        ]);
        
        $retourTc = $retourTcMain->retourtc()->create( $request->all() + [
            'user_saisi' => \Auth::user()->model->codeuser,
            'user_modif' => \Auth::user()->model->codeuser
        ]);
        
        if($request->idclipon)
        {
            $retourTc->attributionclipon()->create( $request->all() );
            $retourTc->attributionclipon;
            if($request->radVerif)
            {
                $retourTc->attributioncliponretourverif()->create( $request->all() );
                $retourTc->attributionclipon->attributioncliponretourverif;
            }
        }
        
        $retourTc->load([
            'camion',
            'chauffeur',
            'remorque',
            'transporteur'
        ]);

        return response()->json($retourTc, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePropreMoyen(Request $request)
    {
        $request->merge([
            'dateh_retour' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_retour)->toDateTimeString(),
        ]);
        
        $retourTcAble = RetourTcMain::create([
            'model_type' => 'App\Models\Export\RetourTcPropreMoyen'
        ]);
        
        $retourTcPropreMoyen = $retourTcAble->retourtcpropremoyen()->create( $request->all() + [
            'user_saisi' => \Auth::user()->model->codeuser,
            'user_modif' => \Auth::user()->model->codeuser
        ]);

        return response()->json($retourTcPropreMoyen, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RetourTc  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function show(RetourTc $retourTc)
    {
        $retourTc->load([
            'camion',
            'transporteur',
            'remorque',
            'chauffeur',
            'attributionclipon.lieuapproclipon',
            'attributionclipon.attributioncliponretourverif',
            'lieuapprocamion',
            'empotagetc',
            'finretour',
            'positionnement.attributiontc.attributionclipon',
            'positionnement.attributiontc.bookingtc.demandebooking.client'
        ]);

        $retourTc->dateh_sorti_cam = Carbon::createFromFormat('Y-m-d H:i:s', $retourTc->dateh_sorti_cam)->format('Y-m-d\TH:i:s.u\Z');
        $retourTc->empotagetc->datehdeb_empot = Carbon::createFromFormat('Y-m-d H:i:s', $retourTc->empotagetc->datehdeb_empot)->format('Y-m-d\TH:i:s.u\Z');
        $retourTc->empotagetc->datehfin_empot = Carbon::createFromFormat('Y-m-d H:i:s', $retourTc->empotagetc->datehfin_empot)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($retourTc, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking\RetourTc  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function showPropreMoyen(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        $retourTcPropreMoyen->load([
            'positionnement.attributiontc.attributionclipon',
            'positionnement.attributiontc.bookingtc.demandebooking.client'
        ]);

        $retourTcPropreMoyen->dateh_retour = Carbon::createFromFormat('Y-m-d H:i:s', $retourTcPropreMoyen->dateh_retour)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($retourTcPropreMoyen, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RetourTc  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function update(RetourTcUpdateRequest $request, RetourTc $retourTc)
    {
        $request->merge([
            'dateh_sorti_cam' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sorti_cam)->toDateTimeString(),
        ]);
        
        $retourTc->update( $request->all() );
        
        if($retourTc->attributionclipon)
        {
            if($request->idclipon)
            {
                $retourTc->attributionclipon->update( $request->all() );
                if($retourTc->attributionclipon->attributioncliponretourverif)
                {
                    if($request->radVerif)
                    {
                        $retourTc->attributionclipon->attributioncliponretourverif->update( $request->all() );
                    }
                    else
                    {
                        $retourTc->attributionclipon->attributioncliponretourverif->delete();
                    }
                }
                else if($request->radVerif)
                {
                    $retourTc->attributionclipon->attributioncliponretourverif()->create( $request->all() );
                }
            }
            else
            {
                if($retourTc->attributionclipon->attributioncliponretourverif)
                {
                    $retourTc->attributionclipon->attributioncliponretourverif->delete();
                }
                $retourTc->attributionclipon->delete();
            }
        }
        else if($request->idclipon)
        {
            $retourTc->attributionclipon()->create( $request->all() );
            if($request->radVerif)
            {
                $retourTc->attributionclipon->attributioncliponretourverif()->create( $request->all() );
            }
        }
        
        $retourTc->load([
            'attributionclipon',
            'camion',
            'chauffeur',
            'remorque',
            'transporteur'
        ]);

        if($retourTc->attributionclipon)
        {
            $retourTc->attributionclipon->load('attributioncliponretourverif');
        }

        return response()->json($retourTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking\RetourTcPropreMoyen  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function updatePropreMoyen(Request $request, RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        $request->merge([
            'dateh_retour' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_retour)->toDateTimeString(),
        ]);
        
        $retourTcPropreMoyen->update( $request->all() );

        return response()->json($retourTcPropreMoyen, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RetourTc  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(RetourTc $retourTc)
    {
        $id = $retourTc->idretour_conteneur;
        try{
            if($retourTc->finretour)
            {
                $retourTc->finretour->sorties2()->detach();
                $retourTc->finretour->delete();
                return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
            }
            if($retourTc->attributionclipon)
            {
                if($retourTc->retourcliponverif)
                {
                    $retourTc->retourcliponverif->delete();
                }
                $retourTc->attributionclipon->delete();
            }
            $retourTc->delete();
            RetourTcMain::find($id)->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking\RetourTc  $retourTc
     * @return \Illuminate\Http\Response
     */
    public function destroyPropreMoyen(RetourTcPropreMoyen $retourTcPropreMoyen)
    {
        try{
            $retourTcPropreMoyen->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
