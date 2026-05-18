<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\PositionnementTcCreateRequest;
use App\Http\Requests\Export\PositionnementTcUpdateRequest;
use App\Models\Export\DemandeBooking;
use App\Models\Export\PositionnementTc;
use App\Models\Export\PositionnementTcPropreMoyen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PositionnementTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:positionnementtcfilter')->only('filter');
        $this->middleware('permission:positionnementtcpaginate')->only('paginate');
        $this->middleware('permission:positionnementtcindex')->only('index');
        $this->middleware('permission:positionnementtccreate')->only('store');
        $this->middleware('permission:positionnementtcshow')->only('show');
        $this->middleware('permission:positionnementtcupdate')->only('update');
        $this->middleware('permission:positionnementtcdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\PositionnementTc::class, 'positionnement_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = PositionnementTc::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = DemandeBooking::where(function (Builder $query) {
                    return $query->where('type_demande','0')->orHas('bookingtc.attributiontcs');
                })
                ->with([ 
                    'client', 
                    'bookingtc.attributiontcs.positionnementtc.finposit',
                    'bookingtc.attributiontcs.positionnementtc.approcarburant',
                    'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc',
                ])
                ->join('booking_conteneur','p_demande_booking.iddemande_booking','=','booking_conteneur.iddemande_booking')
                ;//->where('si_valider','1');

        if(!\Auth::user()->isUsername()) {
            $req->where('ct_num',\Auth::user()->ct_num);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereHas("bookingtc", function (Builder $q) {
                            $q->whereHas("attributiontcs", function (Builder $q) {
                                $q->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                                  ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                                  ->orWhereHas("positionnementtc", function (Builder $q) {
                                      $q->whereRaw("UPPER(idcamion) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                                        ->orWhereExists(function ($q) {
                                            $q->fromRaw("PARC.ENGIN")
                                              ->whereRaw("BOOKING.POSITIONNEMENT_TC.IDCAMION = PARC.ENGIN.IDENGIN")
                                              ->whereRaw("UPPER(immatriculation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                                        })
                                        ->orWhereRaw("UPPER(idremorque) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                                        ->orWhereExists(function ($q) {
                                            $q->fromRaw("PARC.ENGIN")
                                              ->whereRaw("BOOKING.POSITIONNEMENT_TC.IDREMORQUE = PARC.ENGIN.IDENGIN")
                                              ->whereRaw("UPPER(immatriculation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                                        });
                                    })
                                  ->orWhereHas("positionnementtcpropremoyen", function (Builder $q) {
                                      $q->whereRaw("UPPER(immat_camion) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                                        ->orWhereRaw("UPPER(immat_remorque) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                                    });
                            });
                        })
                      ->orWhereExists(function ($q) {
                          $q->fromRaw("EOLIS.OPERATEU")
                            ->whereRaw("BOOKING.P_DEMANDE_BOOKING.CT_NUM = EOLIS.OPERATEU.CODEOPER")
                            ->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && (request()->statut == -2 || request()->statut == -1 || request()->statut == 1 || request()->statut == 2) )
        {
            /*
                {id: '-2', name: 'Positionnements Propres Moyens en attente'}, 
                {id: '-1', name: 'Positionnements EOLIS en attente'}, 
                {id: '1', name: 'Positionnements EOLIS en cours'},
                {id: '2', name: 'Positionnements terminés'}
            */
            $req->whereIn('p_demande_booking.iddemande_booking', function($q) {
                $q->select('p_demande_booking.iddemande_booking')
                ->from('p_demande_booking')
                ->join('booking_conteneur','p_demande_booking.iddemande_booking','=','booking_conteneur.iddemande_booking')
                ->join('attribution_tc','booking_conteneur.idbooking_conteneur','=','attribution_tc.idbooking_conteneur')
                ->groupBy('p_demande_booking.iddemande_booking');

                if(request()->statut != 1)
                {
                    $q->leftjoin('positionnement_tc','attribution_tc.idattribution_tc','=','positionnement_tc.idattribution_tc')
                        ->havingRaw('COUNT(p_demande_booking.iddemande_booking)'.(request()->statut == 2 ? ' = ' : ' > ').'COUNT(positionnement_tc.idpositionnement)');
                }
                else
                {
                    $q->join('positionnement_tc','attribution_tc.idattribution_tc','=','positionnement_tc.idattribution_tc')
                        ->leftjoin('fin_posit_tc','positionnement_tc.idpositionnement','=','fin_posit_tc.idpositionnement')
                        ->havingRaw('COUNT(p_demande_booking.iddemande_booking) > COUNT(fin_posit_tc.idpositionnement)');
                }

                if(request()->statut < 2)
                {
                    $q->where('si_transporteur_eolis', request()->statut == -2 ? '0' : '1');
                }
            });
        }

        $displayedColumns = [
            'no_booking' => 'no_booking',/*
            'qty' => '',
            'type' => '',*/
            'date_dmd' => 'date_demande',
            'date_posit' => 'date_posit_souhait',/*
            'temp' => '',*/
            'trans' => 'si_transporteur_eolis',
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
        return response()->json(PositionnementTc::orderBy('dateh_depart')->orderBy('idcamion')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionnementTcCreateRequest $request)
    {
        $request->merge([
            'dateh_depart' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_depart)->toDateTimeString()
        ]);

        $positionnementTc = PositionnementTc::create($request->all());

        if($request->idbon != '')
        {
            //Enregistre dans bon_physique(idpositionnement,idsortie)
            $positionnementTc->sorties2()->attach($request->idbon);
        }
        
        return response()->json($positionnementTc, 201);
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
            'dateh_sortie' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sortie)->toDateTimeString()
        ]);

        $positionnementTcPropreMoyen = PositionnementTcPropreMoyen::create($request->all());
        
        return response()->json($positionnementTcPropreMoyen, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function show(PositionnementTc $positionnementTc)
    {
        $positionnementTc->load([
            'finposit',
            'remorque',
            'camion',
            'chauffeur',
            'transporteur',
            'portarr',
            'portdep',
            'lieuarrivee',
            'lieuappro',
            'attributiontc.bookingtc.demandebooking',
            'bonphysique.sortie',
            'finposit.finpositcliponverif',
        ]);

        $positionnementTc->dateh_depart = Carbon::createFromFormat('Y-m-d H:i:s', $positionnementTc->dateh_depart)->format('Y-m-d\TH:i:s.u\Z');

        if( $positionnementTc->finposit )
        {
            $positionnementTc->finposit->dateh_arrive = Carbon::createFromFormat('Y-m-d H:i:s', $positionnementTc->finposit->dateh_arrive)->format('Y-m-d\TH:i:s.u\Z');
        }

        return response()->json($positionnementTc, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function showPropreMoyen(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        $positionnementTcPropreMoyen->attributiontc->bookingtc->demandebooking;

        $positionnementTcPropreMoyen->dateh_sortie = Carbon::createFromFormat('Y-m-d H:i:s', $positionnementTcPropreMoyen->dateh_sortie)->format('Y-m-d\TH:i:s.u\Z');

        if( $positionnementTcPropreMoyen->retourtc )
        {
            $positionnementTcPropreMoyen->retourtc->dateh_retour = Carbon::createFromFormat('Y-m-d H:i:s', $positionnementTcPropreMoyen->retourtc->dateh_retour)->format('Y-m-d\TH:i:s.u\Z');
        }

        return response()->json($positionnementTcPropreMoyen, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function update(PositionnementTcUpdateRequest $request, PositionnementTc $positionnementTc)
    {
        $request->merge([
            'dateh_depart' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_depart)->toDateTimeString()
        ]);

        $positionnementTc->update($request->except(['id']));

        $positionnementTc->sorties2()->detach();
        if($request->idbon != '')
        {
            //Enregistre dans sortie_attribution_clipon(idattribution_tc,idsortie)
            $positionnementTc->sorties2()->attach($request->idbon);
        }

        return response()->json($positionnementTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function updatePropreMoyen(Request $request, PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        $request->merge([
            'dateh_sortie' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_sortie)->toDateTimeString()
        ]);

        $positionnementTcPropreMoyen->update($request->all());
        
        return response()->json($positionnementTcPropreMoyen, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(PositionnementTc $positionnementTc)
    {
        try{
            if($positionnementTc->finposit)
            {
                if($positionnementTc->finposit->finpositcliponverif)
                {
                    $positionnementTc->finposit->finpositcliponverif->delete();
                }
                $positionnementTc->finposit->delete();
                return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
            }

            if($positionnementTc->bonphysique)
            {
                $positionnementTc->bonphysique->delete();
            }
            $positionnementTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking\PositionnementTc  $positionnementTc
     * @return \Illuminate\Http\Response
     */
    public function destroyPropreMoyen(PositionnementTcPropreMoyen $positionnementTcPropreMoyen)
    {
        try{
            $positionnementTcPropreMoyen->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
