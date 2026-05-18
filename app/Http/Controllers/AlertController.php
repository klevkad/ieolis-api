<?php

namespace App\Http\Controllers;

use App\Models\Export\DemandeBooking;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function booking(Request $request)
    {
        $year = Is_Numeric($request->year) && $request->year >= 2019 ? $request->year : date('Y');

        //Alerte demande booking en attente
        $reqBkgAttente = DemandeBooking::where('si_valider','-1')->whereYear('date_demande','=',$year);

        //Alerte attributions en attente
        $reqMadAttente = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->with('bookingtc.attributiontcs');

        //Alerte positionnement en attente
        $reqPosAttente = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->where('si_transporteur_eolis','1')->with('bookingtc.attributiontcs.positionnementtc');

        //Alerte positionnement en attente
        $reqPosAttente2 = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->where('si_transporteur_eolis','0')->with('bookingtc.attributiontcs.positionnementtcpropremoyen');

        //Alerte TC empotage chez client
        $reqEmpAttente = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->with([
            'bookingtc.attributiontcs.positionnementtc.finposit.empotagetc',
            'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc',
        ]);

        //Alerte TC retour de chez client
        $reqRetAttente = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->with([
            'bookingtc.attributiontcs.positionnementtc.retourtc.finretour',
        ]);

        //Alerte arrivée quai fruitier        
        $reqEmbAttente = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year)->with([
            'bookingtc.attributiontcs.positionnementtc.retourtc.finretour',
            'bookingtc.attributiontcs.positionnementtc.retourtc.embarquementtc',
            'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc.embarquementtc',
        ]);

        if(!\Auth::user()->isUsername()) {
            $reqBkgAttente->where('ct_num',\Auth::user()->ct_num);
            $reqMadAttente->where('ct_num',\Auth::user()->ct_num);
            $reqPosAttente->where('ct_num',\Auth::user()->ct_num);
            $reqPosAttente2->where('ct_num',\Auth::user()->ct_num);
            $reqEmpAttente->where('ct_num',\Auth::user()->ct_num);
            $reqRetAttente->where('ct_num',\Auth::user()->ct_num);
            $reqEmbAttente->where('ct_num',\Auth::user()->ct_num);
        }

        $bkgAttente = $reqBkgAttente->get();
        $madAttente = $reqMadAttente->get();
        $positAttente = $reqPosAttente->get();
        $positAttente2 = $reqPosAttente2->get();
        $empotAttente = $reqEmpAttente->get();
        $retAttente = $reqRetAttente->get();
        $embAttente = $reqEmbAttente->get();

        $data = [
            [
                'code' => 'dbwait', 
                'title' => 'Demandes de Booking en attente', 
                'qty' => $bkgAttente->count(), 
                'type' => 'danger', 
                'link' => ['url' => '/app/export/demande-booking', 'queryparams' => ['status' => -1]]
            ],
            [
                'code' => 'madwait', 
                'title' => 'Conteneurs à mettre à disposition de clients', 
                'qty' => $madAttente->sum(function ($dmd) { return $dmd->bookingtc->nb_tcs_def; }) - $madAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->count(); }),
                'type' => 'danger', 
                'link' => ['url' => '/app/export/attribution-tc', 'queryparams' => ['status' => -1]]
            ],
            [
                'code' => 'positwait', 
                'title' => 'Conteneurs à positionner par EOLIS chez clients', 
                'qty' => $positAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->count(); }) - $positAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc ? 1 : 0; }); }), 
                'type' => 'danger', 
                'link' => ['url' => '/app/export/positionnement', 'queryparams' => ['status' => -1]]
            ],
            [
                'code' => 'positwait2', 
                'title' => 'Conteneurs à positionner par propres moyens chez clients', 
                'qty' => $positAttente2->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->count(); }) - $positAttente2->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtcpropremoyen ? 1 : 0; }); }), 
                'type' => 'danger', 
                'link' => ['url' => '/app/export/positionnement', 'queryparams' => ['status' => -2]]
            ],
            [
                'code' => 'empotwait', 
                'title' => 'Conteneurs à empoter chez clients', 
                'qty' => $empotAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->finposit ? 1 : 0; }); }) - $empotAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->finposit && $attrib->positionnementtc->finposit->empotagetc ? 1 : 0; }); }) + $empotAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtcpropremoyen ? 1 : 0; }); }) - $empotAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtcpropremoyen && $attrib->positionnementtcpropremoyen->retourtc ? 1 : 0; }); }), 
                'type' => 'danger', 
                'link' => ['url' => '/app/export/empotage-tc', 'queryparams' => ['status' => -1]]
            ],
            [
                'code' => 'retourwait', 
                'title' => 'Conteneurs en retour de chez clients', 
                'qty' => $retAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->retourtc ? 1 : 0; }); }) - $retAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->retourtc && $attrib->positionnementtc->retourtc->finretour ? 1 : 0; }); }),
                'type' => 'danger', 
                'link' => ['url' => '/app/export/sortie-tc-site', 'queryparams' => ['status' => -1]]
            ],
            [
                'code' => 'embwait', 
                'title' => 'Conteneurs à embarquer', 
                'qty' => $embAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->retourtc && $attrib->positionnementtc->retourtc->finretour ? 1 : 0; }); }) - $embAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtc && $attrib->positionnementtc->retourtc && $attrib->positionnementtc->retourtc->embarquementtc ? 1 : 0; }); }) + $embAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtcpropremoyen && $attrib->positionnementtcpropremoyen->retourtc ? 1 : 0; }); }) - $embAttente->sum(function ($dmd) { return $dmd->bookingtc->attributiontcs->sum(function ($attrib) { return $attrib->positionnementtcpropremoyen && $attrib->positionnementtcpropremoyen->retourtc && $attrib->positionnementtcpropremoyen->retourtc->embarquementtc ? 1 : 0; }); }), 
                'type' => 'danger', 
                'link' => ['url' => '/app/export/embarquement-tc', 'queryparams' => ['status' => -1]]
            ],
        ];

        return response()->json($data, 200);
    }
}
