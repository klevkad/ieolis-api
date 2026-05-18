<?php

namespace App\Http\Controllers\Syntheses;

use App\Http\Controllers\Controller;
use App\Models\Export\EmbarquementTc;
use App\Models\Old\Eolis\Escale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:synthesesbookingtc')->only('paginate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = DB::table(DB::raw('(
                    SELECT NOESCALE, COUNT(IDRETOUR_CONTENEUR) QTY
                    FROM BOOKING.EMB_CONTENEUR 
                    GROUP BY NOESCALE ) T1'))
                ->select(DB::raw('T2.NOESCALE, T1.QTY, T2.QTY_PREV, EOLIS.ESCALE.ETAD, EOLIS.NAVIRE.LIBNAVIRE'))
                ->rightJoin(DB::raw('(
                    SELECT NOESCALE, SUM(BOOKING_CONTENEUR.NB_TCS_DEF) QTY_PREV
                    FROM BOOKING_CONTENEUR
                    INNER JOIN P_DEMANDE_BOOKING ON BOOKING_CONTENEUR.IDDEMANDE_BOOKING = P_DEMANDE_BOOKING.IDDEMANDE_BOOKING
                    WHERE P_DEMANDE_BOOKING.SI_VALIDER = 1
                    GROUP BY NOESCALE ) T2'), DB::raw('T1.NOESCALE'), '=', DB::raw('T2.NOESCALE')
                )->join(DB::raw('EOLIS.ESCALE'), DB::raw('EOLIS.ESCALE.NOESCALE'), '=', DB::raw('T2.NOESCALE'))
                 ->join(DB::raw('EOLIS.NAVIRE'), DB::raw('EOLIS.NAVIRE.CODENAVIRE'), '=', DB::raw('EOLIS.ESCALE.CODENAVIRE'));

/*
        if(!\Auth::user()->isUsername()) {
            $req->where('ct_num',\Auth::user()->ct_num);
        }
*/

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                    $query->whereRaw("UPPER(NOESCALE) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(QTY) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(QTY_PREV) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(ETAD) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(LIBNAVIRE) LIKE '%".mb_strtoupper(request()->search)."%'");
                });
        }

        if(request()->has('statut') && is_numeric(request()->statut) && request()->statut >= -1 && request()->statut <= 1 )
        {
            //$req->where('si_valider','=',request()->statut);
        }

        $displayedColumns = [
            'noescale' => 'noescale',
            'qty' => 'qty',
            'qty_prev' => 'qty_prev',
            'etad' => 'etad',
            'libnavire' => 'libnavire',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }


    public function detailsEmbarquementNavire(Escale $escale)
    {
        $escale->navire;

        $embData = EmbarquementTc::with([
            'finretourtc',
            'retourtc.empotagetc',
            'retourtc.positionnement.finposit',
            'retourtc.positionnement.attributiontc.bookingtc.demandebooking.client',
            'retourtcpropremoyen.positionnement.attributiontc.bookingtc.demandebooking.client',
        ])->where('noescale',$escale->noescale)->get();

        $byCliTmp = [];
        $byProd[] = ['x' => 'Mangues', 'y' => 0];
        foreach($embData as $emb)
        {
            $byProd[0]['y']++;

            if($emb->finretourtc)
            {
                $code = $emb->retourtc->positionnement->attributiontc->bookingtc->demandebooking->ct_num;
                if(!isset($byCliTmp[$code]))
                {
                    $byCliTmp[$code] = [
                        'title' => $emb->retourtc->positionnement->attributiontc->bookingtc->demandebooking->client->liboper,
                        'qty' => 1,
                    ];
                }
                else
                {
                    $byCliTmp[$code]['qty']++;
                }
            } else {
                $code = $emb->retourtcpropremoyen->positionnement->attributiontc->bookingtc->demandebooking->ct_num;
                if(!isset($byCliTmp[$code]))
                {
                    $byCliTmp[$code] = [
                        'title' => $emb->retourtcpropremoyen->positionnement->attributiontc->bookingtc->demandebooking->client->liboper,
                        'qty' => 1,
                    ];
                }
                else
                {
                    $byCliTmp[$code]['qty']++;
                }
            }
        }

        $byCli = [];
        foreach($byCliTmp as $tmp)
        {
            $byCli[] = ['x' => $tmp['title'], 'y' => $tmp['qty']];
        }
        
        return response()->json(['data' => $embData, 'escale' => $escale, 'byCli' => $byCli, 'byProd' => $byProd], 200);
    }
}
