<?php

namespace App\Http\Controllers\Syntheses;

use App\Http\Controllers\Controller;
use App\Models\Export\PositionnementTc;
use App\Models\Export\RetourTc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarburantController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:candidatfilter')->only('filter');
        $this->middleware('permission:candidatpaginate')->only('paginate');
        $this->middleware('permission:candidatindex')->only('index');
        $this->middleware('permission:candidatcreate')->only('store');
        $this->middleware('permission:candidatshow')->only('show');
        $this->middleware('permission:candidatupdate')->only('update');
        $this->middleware('permission:candidatdelete')->only('destroy');

        //$this->authorizeResource(App\Models\Candidat::class, 'candidat');
    }

    public function detailsConsoCamion($idengin)
    {
        $dat0 = PositionnementTc::selectRaw('ATTRIBUTION_CLIPON.QTE_APPRO QTE_APPRO_CLIP, P0.IMMATRICULATION IMMAT_REMORQUE, NOM_CHAUFFEUR, PRENOM_CHAUFFEUR, P1.LIBPORT DEPART, P2.LIBPORT ARRIVEE, DATEH_DEPART, DATEH_ARRIVE, ROUND(24*60*(DATEH_ARRIVE - DATEH_DEPART),0) DUREE, NO_TC, IDCLIPON, POSITIONNEMENT_TC.QTE_APPRO')
                                ->join('CHAUFFEUR','POSITIONNEMENT_TC.IDCHAUFFEUR','=','CHAUFFEUR.IDCHAUFFEUR')
                                ->join(DB::raw('PARC.ENGIN P0'),'POSITIONNEMENT_TC.IDREMORQUE','=',DB::raw('P0.IDENGIN'))
                                ->join('ATTRIBUTION_TC','ATTRIBUTION_TC.IDATTRIBUTION_TC','=','POSITIONNEMENT_TC.IDATTRIBUTION_TC')
                                ->leftjoin('ATTRIBUTION_CLIPON','ATTRIBUTION_CLIPON.IDATTRIBUTION_TC','=','ATTRIBUTION_TC.IDATTRIBUTION_TC')
                                ->join('FIN_POSIT_TC','POSITIONNEMENT_TC.IDPOSITIONNEMENT','=','FIN_POSIT_TC.IDPOSITIONNEMENT')
                                ->join(DB::raw('EOLIS.PORT P1'),'POSITIONNEMENT_TC.IDLIEU_DEPART','=',DB::raw('P1.CODEPORT'))
                                ->join(DB::raw('EOLIS.PORT P2'),'POSITIONNEMENT_TC.IDLIEU_ARRIVE','=',DB::raw('P2.CODEPORT'))
                                ->where('POSITIONNEMENT_TC.IDCAMION','=',$idengin);

        $data = RetourTc::selectRaw('QTE_APPRO_CLIP, P0.IMMATRICULATION IMMAT_REMORQUE, NOM_CHAUFFEUR, PRENOM_CHAUFFEUR, P1.LIBPORT DEPART, P2.LIBPORT ARRIVEE, RETOUR_CONTENEUR.DATEH_SORTI_CAM as DATEH_DEPART, FIN_RETOUR_TC.DATEH_ARRIVE_CAM as DATEH_ARRIVE, ROUND(24*60*(FIN_RETOUR_TC.DATEH_ARRIVE_CAM - RETOUR_CONTENEUR.DATEH_SORTI_CAM),0) DUREE, NO_TC, IDCLIPON, QTE_APPRO_CAM as QTE_APPRO')
                        ->join('CHAUFFEUR','RETOUR_CONTENEUR.IDCHAUFFEUR','=','CHAUFFEUR.IDCHAUFFEUR')
                        ->join(DB::raw('PARC.ENGIN P0'),'RETOUR_CONTENEUR.IDREMORQUE','=',DB::raw('P0.IDENGIN'))
                        ->join('FIN_RETOUR_TC','RETOUR_CONTENEUR.IDRETOUR_CONTENEUR','=','FIN_RETOUR_TC.IDRETOUR_CONTENEUR')
                        ->leftjoin('ATTRIBUTION_CLIPON_RETOUR','RETOUR_CONTENEUR.IDRETOUR_CONTENEUR','=','ATTRIBUTION_CLIPON_RETOUR.IDRETOUR_CONTENEUR')
                        ->join('POSITIONNEMENT_TC','RETOUR_CONTENEUR.IDPOSITIONNEMENT','=','POSITIONNEMENT_TC.IDPOSITIONNEMENT')
                        ->join('ATTRIBUTION_TC','ATTRIBUTION_TC.IDATTRIBUTION_TC','=','POSITIONNEMENT_TC.IDATTRIBUTION_TC')
                        ->join(DB::raw('EOLIS.PORT P2'),'POSITIONNEMENT_TC.IDLIEU_DEPART','=',DB::raw('P2.CODEPORT'))
                        ->join(DB::raw('EOLIS.PORT P1'),'POSITIONNEMENT_TC.IDLIEU_ARRIVE','=',DB::raw('P1.CODEPORT'))
                        ->where('RETOUR_CONTENEUR.IDCAMION','=',$idengin)
                        ->union($dat0)
                        ->orderBy('DATEH_DEPART')->get();

        return response()->json($data, 200);
    }

    public function detailsConsoClipon($idengin)
    {
        $dat0 = PositionnementTc::selectRaw('ATTRIBUTION_CLIPON.QTE_APPRO QTE_APPRO_CLIP, P0.IMMATRICULATION IMMAT_REMORQUE, P1.IMMATRICULATION IMMAT_CAMION, NOM_CHAUFFEUR, PRENOM_CHAUFFEUR, P1.LIBPORT DEPART, P2.LIBPORT ARRIVEE, DATEH_DEPART, DATEH_ARRIVE, ROUND(24*60*(DATEH_ARRIVE - DATEH_DEPART),0) DUREE, NO_TC, IDCAMION, POSITIONNEMENT_TC.QTE_APPRO')
                                ->join('CHAUFFEUR','POSITIONNEMENT_TC.IDCHAUFFEUR','=','CHAUFFEUR.IDCHAUFFEUR')
                                ->join(DB::raw('PARC.ENGIN P0'),'POSITIONNEMENT_TC.IDREMORQUE','=',DB::raw('P0.IDENGIN'))
                                ->join(DB::raw('PARC.ENGIN P1'),'POSITIONNEMENT_TC.IDCAMION','=',DB::raw('P1.IDENGIN'))
                                ->join('ATTRIBUTION_TC','ATTRIBUTION_TC.IDATTRIBUTION_TC','=','POSITIONNEMENT_TC.IDATTRIBUTION_TC')
                                ->join('ATTRIBUTION_CLIPON','ATTRIBUTION_CLIPON.IDATTRIBUTION_TC','=','ATTRIBUTION_TC.IDATTRIBUTION_TC')
                                ->join('FIN_POSIT_TC','POSITIONNEMENT_TC.IDPOSITIONNEMENT','=','FIN_POSIT_TC.IDPOSITIONNEMENT')
                                ->join(DB::raw('EOLIS.PORT P1'),'POSITIONNEMENT_TC.IDLIEU_DEPART','=',DB::raw('P1.CODEPORT'))
                                ->join(DB::raw('EOLIS.PORT P2'),'POSITIONNEMENT_TC.IDLIEU_ARRIVE','=',DB::raw('P2.CODEPORT'))
                                ->where('ATTRIBUTION_CLIPON.IDCLIPON','=',$idengin);

        $data = RetourTc::selectRaw('QTE_APPRO_CLIP, P0.IMMATRICULATION IMMAT_REMORQUE, P1.IMMATRICULATION IMMAT_CAMION, NOM_CHAUFFEUR, PRENOM_CHAUFFEUR, P1.LIBPORT DEPART, P2.LIBPORT ARRIVEE, RETOUR_CONTENEUR.DATEH_SORTI_CAM as DATEH_DEPART, FIN_RETOUR_TC.DATEH_ARRIVE_CAM as DATEH_ARRIVE, ROUND(24*60*(FIN_RETOUR_TC.DATEH_ARRIVE_CAM - RETOUR_CONTENEUR.DATEH_SORTI_CAM),0) DUREE, NO_TC, RETOUR_CONTENEUR.IDCAMION IDCAMION, QTE_APPRO_CAM as QTE_APPRO')
                        ->join('CHAUFFEUR','RETOUR_CONTENEUR.IDCHAUFFEUR','=','CHAUFFEUR.IDCHAUFFEUR')
                        ->join(DB::raw('PARC.ENGIN P0'),'RETOUR_CONTENEUR.IDREMORQUE','=',DB::raw('P0.IDENGIN'))
                        ->join(DB::raw('PARC.ENGIN P1'),'RETOUR_CONTENEUR.IDCAMION','=',DB::raw('P1.IDENGIN'))
                        ->join('FIN_RETOUR_TC','RETOUR_CONTENEUR.IDRETOUR_CONTENEUR','=','FIN_RETOUR_TC.IDRETOUR_CONTENEUR')
                        ->join('ATTRIBUTION_CLIPON_RETOUR','RETOUR_CONTENEUR.IDRETOUR_CONTENEUR','=','ATTRIBUTION_CLIPON_RETOUR.IDRETOUR_CONTENEUR')
                        ->join('POSITIONNEMENT_TC','RETOUR_CONTENEUR.IDPOSITIONNEMENT','=','POSITIONNEMENT_TC.IDPOSITIONNEMENT')
                        ->join('ATTRIBUTION_TC','ATTRIBUTION_TC.IDATTRIBUTION_TC','=','POSITIONNEMENT_TC.IDATTRIBUTION_TC')
                        ->join(DB::raw('EOLIS.PORT P2'),'POSITIONNEMENT_TC.IDLIEU_DEPART','=',DB::raw('P2.CODEPORT'))
                        ->join(DB::raw('EOLIS.PORT P1'),'POSITIONNEMENT_TC.IDLIEU_ARRIVE','=',DB::raw('P1.CODEPORT'))
                        ->where('ATTRIBUTION_CLIPON_RETOUR.IDCLIPON','=',$idengin)
                        ->union($dat0)
                        ->orderBy('DATEH_DEPART')->get();

        return response()->json($data, 200);
    }

    public function recapConsoCamions()
    {
        $data = DB::table(DB::raw('(
                    SELECT IDCAMION, SUM(QTE_APPRO) AS QTE_DEP
                    FROM POSITIONNEMENT_TC
                    WHERE POSITIONNEMENT_TC.DATEH_DEPART > TO_DATE(\'2022-01-01\',\'yyyy-mm-dd\')
                    GROUP BY IDCAMION ) T1'))
                ->select(DB::raw('T1.IDCAMION, CODE_FOURN as CODEFOUR, IMMATRICULATION, NBR_VGE, QTE_DEP, QTE_RET, QTE_ARR, (NVL(QTE_DEP,0)+NVL(QTE_RET,0)+NVL(QTE_ARR,0)) TOTAL_APPRO'))
                ->join(DB::raw('(
                    SELECT IDCAMION, SUM(QTE_APPRO_CAM) AS QTE_RET, SUM(QTE_APPRO_ARRIVE_CAM) AS QTE_ARR, COUNT(FIN_RETOUR_TC.IDFIN_RETOUR_TC) AS NBR_VGE
                    FROM RETOUR_CONTENEUR
                    LEFT JOIN FIN_RETOUR_TC ON RETOUR_CONTENEUR.IDRETOUR_CONTENEUR = FIN_RETOUR_TC.IDRETOUR_CONTENEUR
                    WHERE RETOUR_CONTENEUR.DATEH_SORTI_CAM > TO_DATE(\'2022-01-01\',\'yyyy-mm-dd\')
                    GROUP BY IDCAMION ) T2'), DB::raw('T1.IDCAMION'), '=', DB::raw('T2.IDCAMION')
                )->join(DB::raw('PARC.ENGIN'), DB::raw('PARC.ENGIN.IDENGIN'), '=', DB::raw('T1.IDCAMION'))->orderBy('IDCAMION')->get();

        return response()->json($data, 200);
    }

    public function recapConsoClipons()
    {
        $data = DB::table(DB::raw('PARC.ENGIN'))
                ->select(DB::raw('T1.IDCLIPON, NBR_VGE, QTE_DEP, QTE_RET, QTE_ARR'))
                ->leftjoin(DB::raw('(
                    SELECT IDCLIPON, SUM(QTE_APPRO) AS QTE_DEP 
                    FROM ATTRIBUTION_CLIPON 
                    INNER JOIN ATTRIBUTION_TC ON ATTRIBUTION_CLIPON.IDATTRIBUTION_TC = ATTRIBUTION_TC.IDATTRIBUTION_TC
                    WHERE ATTRIBUTION_TC.DATEH_SAISIE > TO_DATE(\'2022-01-01\',\'yyyy-mm-dd\')
                    GROUP BY IDCLIPON ) T1'), DB::raw('T1.IDCLIPON'), '=', DB::raw('ENGIN.IDENGIN'))
                ->leftjoin(DB::raw('(
                    SELECT IDCLIPON, SUM(QTE_APPRO_CLIP) AS QTE_RET, SUM(QTE_APPRO_ARRIVE_CLIPON) AS QTE_ARR, COUNT(FIN_RETOUR_TC.IDFIN_RETOUR_TC) AS NBR_VGE
                    FROM ATTRIBUTION_CLIPON_RETOUR
                    LEFT JOIN FIN_RETOUR_TC ON ATTRIBUTION_CLIPON_RETOUR.IDRETOUR_CONTENEUR = FIN_RETOUR_TC.IDRETOUR_CONTENEUR
                    WHERE FIN_RETOUR_TC.DATEH_ARRIVE_CAM > TO_DATE(\'2022-01-01\',\'yyyy-mm-dd\')
                    GROUP BY IDCLIPON ) T2'), DB::raw('ENGIN.IDENGIN'), '=', DB::raw('T2.IDCLIPON')
                )->orderBy('IDCLIPON')->get();

        return response()->json($data, 200);
    }

}
