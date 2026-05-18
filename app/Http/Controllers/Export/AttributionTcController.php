<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\AttributionTcCreateRequest;
use App\Http\Requests\Export\AttributionTcUpdateRequest;
use App\Http\Requests\Export\ReAttributionTcRequest;
use App\Models\Export\AttributionClipon;
use App\Models\Export\AttributionTc;
use App\Models\Export\DemandeBooking;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributionTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:attributiontcfilter')->only('filter');
        $this->middleware('permission:attributiontcpaginate')->only('paginate');
        $this->middleware('permission:attributiontcindex')->only('index');
        $this->middleware('permission:attributiontccreate')->only('store');
        $this->middleware('permission:reattribuertc')->only('reAttributionTc');
        $this->middleware('permission:attributiontcshow')->only('show');
        $this->middleware('permission:attributiontcupdate')->only('update');
        $this->middleware('permission:attributiontcdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\AttributionTc::class, 'attribution_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = AttributionTc::with(['attributionclipon'])->orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = DemandeBooking::with([
            'client',
            'escale.navire',
            'bookingtc.attributiontcs', 
            'bookingtc.paramtcreefer'
        ])->where('si_valider','1');

        if(!\Auth::user()->isUsername()) {
            $req->where('ct_num',\Auth::user()->ct_num);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereExists(function ($q) {
                          $q->fromRaw("EOLIS.OPERATEU")
                            ->whereRaw("BOOKING.P_DEMANDE_BOOKING.CT_NUM = EOLIS.OPERATEU.CODEOPER")
                            ->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereHas('bookingtc.attributiontcs', function (Builder $q) {
                          $q->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                            ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        });
            });
        }

        if(request()->has('statut') && (request()->statut == -1 || request()->statut == 1) )
        {
            $req->whereIn('p_demande_booking.iddemande_booking', function($q) {
                $q->select('p_demande_booking.iddemande_booking')
                ->from('p_demande_booking')
                ->join('booking_conteneur','p_demande_booking.iddemande_booking','=','booking_conteneur.iddemande_booking')
                ->leftjoin('attribution_tc','booking_conteneur.idbooking_conteneur','=','attribution_tc.idbooking_conteneur')
                ->groupBy('p_demande_booking.iddemande_booking')
                ->havingRaw('COUNT(attribution_tc.idbooking_conteneur)'.(request()->statut == 1 ? ' = ' : ' < ').'AVG(booking_conteneur.nb_tcs_def)');
            });
        }

        $displayedColumns = [
            'ct_num' => 'ct_num', 
            'qty' => '', 
            'type' => '', 
            'temp' => '', 
            'date_posit' => '', 
            'navire' => '', 
            'trans' => 'si_transporteur_eolis',
            'no_booking' => 'no_booking',
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
        return response()->json(AttributionTc::orderBy('plom1')->orderBy('no_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributionTcCreateRequest $request)
    {
        $attributionTc = AttributionTc::create($request->all() + [
            'codeuser_saisi' => \Auth::user()->model->codeuser,
            'codeuser_modif' => \Auth::user()->model->codeuser
        ]);

        if($request->radcli)
        {
            $attrCli = AttributionClipon::create($request->only(['idclipon']) + ['idattribution_tc' => $attributionTc->idattribution_tc]);
            if($request->qte_appro && $request->qte_appro > 0)
            {
                $attrCli->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                    'idengin' => $request->idclipon,
                    'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                ]);
                $attributionTc->attributionclipon->approcarburant;
            }

            if($request->radVerif)
            {
                $attrCli->attributioncliponverif()->create($request->all());
            }

            if($request->idbon != '')
            {
                //Enregistre dans sortie_attribution_clipon(idattribution_tc,idsortie)
                $attributionTc->sorties2()->attach($request->idbon);
            }
        }

        if($request->immat_camion)
        {
            $request->merge([
                'dateh_sortie' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sortie)->toDateTimeString()
            ]);

            $attributionTc->positionnementtcpropremoyen()->create($request->all() + [
                'user_saisi' => \Auth::user()->model->codeuser,
                'user_modif' => \Auth::user()->model->codeuser
            ]);
        }

        return response()->json($attributionTc, 201);
    }

    /**
     * Swap attributions Bookings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reAttributionTc(ReAttributionTcRequest $request)
    {
        $dmdbooking1 = DemandeBooking::with(['bookingtc'])->where("no_booking",$request->no_booking1)->first();
        $attributionTc1 = AttributionTc::find($request->attrib1);
        $idbooking_conteneur1 = $attributionTc1->idbooking_conteneur;

        $dmdbooking2 = DemandeBooking::with(['bookingtc'])->where("no_booking",$request->no_booking2)->first();
        $idbooking_conteneur2 = $dmdbooking2->bookingtc->idbooking_conteneur;

        if($request->option == 2 && $dmdbooking2->bookingtc->nb_tcs <= $dmdbooking2->attributiontc->count()) {
            return response()->json(['message' => 'Nombre de conteneurs atteint sur la demande'], 403);
        }

        $attributionTc1->update(['idbooking_conteneur' => $idbooking_conteneur2]);/**/
        if($request->option == 1) { // 1 => Echanger; 2 => Transférer
            $attributionTc2 = AttributionTc::find($request->attrib2);
            $attributionTc2->update(['idbooking_conteneur' => $idbooking_conteneur1]);
        }

        $attributionTc1->load([
            'attributionclipon',
            'bookingtc.demandebooking.client'
        ]);

        return response()->json($attributionTc1, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributionTc  $attributionTc
     * @return \Illuminate\Http\Response
     */
    public function show(AttributionTc $attributionTc)
    {
        $attributionTc->load([
            'attributionclipon.lieuappro',
            'bookingtc.demandebooking',
            'positionnementtcpropremoyen', 
            'sortieattributiontc.sortie'
        ]);

        if( $attributionTc->positionnementtcpropremoyen )
        {
            $attributionTc->positionnementtcpropremoyen->dateh_sortie = Carbon::createFromFormat('Y-m-d H:i:s', $attributionTc->positionnementtcpropremoyen->dateh_sortie)->format('Y-m-d\TH:i:s.u\Z');
        }

        if($attributionTc->attributionclipon)
        {
            $attributionTc->attributionclipon->lieuappro;
            if($attributionTc->sortieattributiontc)
            {
                $attributionTc->sortieattributiontc->sortie;
            }
        }

        return response()->json($attributionTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributionTc  $attributionTc
     * @return \Illuminate\Http\Response
     */
    public function update(AttributionTcUpdateRequest $request, AttributionTc $attributionTc)
    {
        $attributionTc->update($request->only(['no_tc', 'plomb1', 'plomb2']) + [ 'codeuser_modif' => \Auth::user()->model->codeuser ]);

        if($request->radcli)
        {
            if($attributionTc->attributionclipon)
            {
//                $attributionTc->attributionclipon->update($request->only(['idclipon', 'idlieu_appro', 'qte_appro']));
                $attributionTc->attributionclipon->update($request->only(['idclipon']));
                if($request->qte_appro && $request->qte_appro > 0)
                {
                    if($attributionTc->attributionclipon->approcarburant)
                    {
                        $attributionTc->attributionclipon->approcarburant->update($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                            'idengin' => $request->idclipon,
                            'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                        ]);
                    }
                    else
                    {
                        $attributionTc->attributionclipon->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                            'idengin' => $request->idclipon,
                            'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                        ]);
                    }
                }
                else
                {
                    $attributionTc->attributionclipon->approcarburant()->delete();
                }
                $attributionTc->sorties2()->detach();
            }
            else
            {
                $attrCli = AttributionClipon::create($request->only(['idclipon']) + ['idattribution_tc' => $attributionTc->idattribution_tc]);
                if($request->qte_appro && $request->qte_appro > 0)
                {
                    $attrCli->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                        'idengin' => $request->idclipon,
                        'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
                    ]);
                }
            }

            if($request->idbon != '')
            {
                //Enregistre dans sortie_attribution_clipon(idattribution_tc,idsortie)
                $attributionTc->sorties2()->attach($request->idbon);
            }
        }

        if($request->immat_camion)
        {
            $request->merge([
                'dateh_sortie' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sortie)->toDateTimeString()
            ]);

            if( $attributionTc->positionnementtcpropremoyen )
            {
                $attributionTc->positionnementtcpropremoyen->update($request->all() + [
                    'user_modif' => \Auth::user()->model->codeuser
                ]);
            }
            else
            {
                $attributionTc->positionnementtcpropremoyen()->create($request->all() + [
                    'user_saisi' => \Auth::user()->model->codeuser,
                    'user_modif' => \Auth::user()->model->codeuser
                ]);    
            }
        }

        return response()->json($attributionTc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributionTc  $attributionTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributionTc $attributionTc)
    {
        try{
            if($attributionTc->positionnementtcpropremoyen)
            {
                $attributionTc->positionnementtcpropremoyen->delete();
            }

            if($attributionTc->attributionclipon)
            {
                $attributionTc->sorties2()->detach();
                if($attributionTc->attributionclipon->approcarburant)
                {
                    $attributionTc->attributionclipon->approcarburant->delete();
                }
                $attributionTc->attributionclipon->delete();
            }

            $attributionTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
