<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\A_Etatcs;
use App\Models\Old\Eolis\Escale;
use App\Models\Old\Eolis\TcsBase;
use App\Models\Old\Eolis\View_Douane_Mvt_Tcs;
use App\Models\Old\Eolis\View_Eolis_Mvt_Tcs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class A_EtatcsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:aetatcsfilter')->only('filter');
        $this->middleware('permission:aetatcspaginate')->only('paginate');
        $this->middleware('permission:aetatcsindex')->only('index');
        $this->middleware('permission:aetatcscreate')->only('store');
        $this->middleware('permission:aetatcsshow')->only('show');
        $this->middleware('permission:aetatcsupdate')->only('update');
        $this->middleware('permission:aetatcsdelete')->only('destroy');

        $this->authorizeResource(App\Models\Old\Eolis\A_Etatcs::class, 'aetatcs');
    }


    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterNobl()
    {
        if(request()->has('search') && request()->search != '')
        {
            $nobls = DB::connection('eolis')->select("
                SELECT DISTINCT NOBL
                FROM BLS
                WHERE UPPER(NOBL) LIKE ? AND ROWNUM <= 50 
                ORDER BY NOBL ASC
            ", ['%'.mb_strtoupper(request()->search).'%']);

            return response()->json($nobls, 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterTc()
    {
        $req = TcsBase::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(REPLACE(no_tc,'-','')) LIKE ?", ['%'.str_replace('/','',str_replace('-','',mb_strtoupper(request()->search))).'%'])
                ->limit(50);

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterEscale()
    {
        if(request()->has('search') && request()->search != '')
        {
            $req = Escale::with(['navire'])->orderBy('etad','DESC');

            $req->where(function ($query) {
                $query->whereHas('navire', function (Builder $q) {
                    $q->whereRaw("UPPER(libnavire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                });
            })->limit(50);

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }


    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = A_Etatcs::orderBy('no_tc','ASC');

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
    public function paginateView()
    {
        $req = /*\Auth::user()->isUsername() ? View_Eolis_Mvt_Tcs::with([]) :*/ View_Douane_Mvt_Tcs::with([]);

        if(request()->has('search') && request()->search != '')
        {
            if(request()->statut == 'nobl')
            {
                $req->whereRaw("UPPER(nobl) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
            else if(request()->statut == 'notc')
            {
                $req->whereRaw("UPPER(REPLACE(no_tc,'-','')) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
            else if(request()->statut == 'navire')
            {
                $req->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
        }

        $displayedColumns = [
            'no_tc' => 'no_tc', 
            'type_tc' => 'type_tc', 
            'produit' => 'produit', 
            'nobl' => 'nobl', 
            'client' => 'client', 
            'trafic' => 'trafic', 
            'date_mvt' => 'date_mvt', 
            'navire' => 'navire', 
            'noescale' => 'noescale', 
            'eta' => 'eta', 
            'etat' => 'etat', 
            'parc' => 'parc', 
            'details' => 'details',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }

    public function getDetailBranch($id)
    {
        $branch = DB::connection('eolis')->selectOne("
            SELECT 
                1 branch,
                T_OPERA_BRANCH.HEURDEBUTBRANCH debut,
                T_OPERA_BRANCH.HEURFINBRANCH fin,
                T_OPERA_BRANCH.NUMCOMPTEUR compteur,
                T_OPERA_BRANCH.TEMP temp,
                T0.LIBPORT port_dep,
                T1.LIBPORT port_arr,
                TCS_BASE.TARE_TC tare_tc,
                T2.PLOMB1 plomb,
                T2.DOSSIER dossier,
                T2.NO_DECLAR1 declar,
                T_OPERA_BRANCH.NO_TC no_tc,
                TCS_BASE.TYPE_TC type_tc,
                T_PROD_BRANCH.LIB_GRP_PROD produit,
                T2.NOBL nobl,
                OPERATEU.LIBOPER client,
                TRAFFIC.LIBELLE_TRAFFIC trafic,
                T_OPERA_BRANCH.HEURDEBUTBRANCH date_mvt,
                EOLIS.NAVIRE.LIBNAVIRE navire,
                EOLIS.ESCALE.NOESCALE noescale,
                EOLIS.ESCALE.ETAD eta,
                'PLEIN' etat,
                'EOLIS Terminal Fruitier' parc,
                'Branchement' details
            FROM ACCONAGE.T_OPERA_BRANCH 
            LEFT JOIN ACCONAGE.T_PROD_BRANCH ON ACCONAGE.T_OPERA_BRANCH.PRODUIT = ACCONAGE.T_PROD_BRANCH.GROU_PROD
            LEFT JOIN EOLIS.OPERATEU ON ACCONAGE.T_OPERA_BRANCH.CODEOPER = EOLIS.OPERATEU.CODEOPER
            LEFT JOIN EOLIS.TCS_BASE ON ACCONAGE.T_OPERA_BRANCH.NO_TC = EOLIS.TCS_BASE.NO_TC
            LEFT JOIN (
                    SELECT EOLIS.CONTENEU.NO_TC, EOLIS.CONTENEU.PLOMB1, EOLIS.BLS.PORT_EMB, EOLIS.BLS.PORT_DEB, EOLIS.BLS.DOSSIER, EOLIS.BLS.NO_DECLAR1, EOLIS.BLS.NOESCALE, EOLIS.BLS.IDBL, EOLIS.BLS.NOBL, EOLIS.BLS.CONVENIENCE
                    FROM EOLIS.BLS
                    INNER JOIN EOLIS.CONTENEU ON EOLIS.BLS.IDBL = EOLIS.CONTENEU.IDBL
            ) T2 ON (ACCONAGE.T_OPERA_BRANCH.NO_TC = T2.NO_TC AND ACCONAGE.T_OPERA_BRANCH.NOESCALE = T2.NOESCALE)
            LEFT JOIN EOLIS.PORT T0 ON T0.CODEPORT = T2.PORT_EMB
            LEFT JOIN EOLIS.PORT T1 ON T1.CODEPORT = T2.PORT_DEB
            LEFT JOIN EOLIS.TRAFFIC ON T_OPERA_BRANCH.TRAFIC = EOLIS.TRAFFIC.IDTRAFFIC
            LEFT JOIN EOLIS.ESCALE ON ACCONAGE.T_OPERA_BRANCH.NOESCALE = EOLIS.ESCALE.NOESCALE
            LEFT JOIN EOLIS.NAVIRE ON EOLIS.ESCALE.CODENAVIRE = EOLIS.NAVIRE.CODENAVIRE
            WHERE T_OPERA_BRANCH.TRAFIC = 1 AND T_OPERA_BRANCH.IDT_OPERA8BRANCH = ?
        ", [$id]);

        return response()->json($branch, 200);
    }

    public function getDetailTcDeb($id)
    {
        $tcdeb = DB::connection('eolis')->selectOne("
            SELECT 
                T0.LIBPORT port_dep,
                T1.LIBPORT port_arr,
                A_TCSDEB.POIDS_BRUT*1000 pbrut,
                TCS_BASE.TARE_TC tare_tc,
                A_TCSDEB.PLOMB1 plomb,
                BLS.DOSSIER dossier,
                BLS.NO_DECLAR1 declar,
                A_TCSDEB.NO_TC no_tc,
                TCS_BASE.TYPE_TC type_tc,
                A_TCSDEB.LIB_PRODUIT produit,
                BLS.NOBL nobl,
                A_TCSDEB.NOM_DEST client,
                'IMPORT' trafic,
                A_TCSDEB.DATE_DEB date_mvt,
                NAVIRE.LIBNAVIRE navire,
                A_TCSDEB.NOESCALE noescale,
                BLS.CONVENIENCE convenience,
                ESCALE.ETAD eta,
                (CASE WHEN A_TCSDEB.PLEIN_VIDE = 1 THEN 'PLEIN' ELSE 'VIDE' END) etat,
                'EOLIS Terminal Fruitier' parc,
                'Débarquement' details
            FROM EOLIS.A_TCSDEB 
            LEFT JOIN EOLIS.TCS_BASE ON EOLIS.A_TCSDEB.NO_TC = EOLIS.TCS_BASE.NO_TC
            LEFT JOIN EOLIS.BLS ON EOLIS.A_TCSDEB.IDBL = EOLIS.BLS.IDBL
            LEFT JOIN EOLIS.PORT T0 ON T0.CODEPORT = EOLIS.BLS.PORT_EMB
            LEFT JOIN EOLIS.PORT T1 ON T1.CODEPORT = EOLIS.BLS.PORT_DEB
            LEFT JOIN EOLIS.ESCALE ON EOLIS.A_TCSDEB.NOESCALE = EOLIS.ESCALE.NOESCALE
            LEFT JOIN EOLIS.NAVIRE ON EOLIS.ESCALE.CODENAVIRE = EOLIS.NAVIRE.CODENAVIRE
            WHERE A_TCSDEB.TOP_TBDT = 2 AND A_TCSDEB.IDTCSDEB = ?

            UNION

            SELECT 
                T0.LIBPORT port_dep,
                T1.LIBPORT port_arr,
                CONTENEU.POIDS_BRUT*1000 pbrut,
                TCS_BASE.TARE_TC tare_tc,
                A_TCSDEB.PLOMB1 plomb,
                BLS.DOSSIER dossier,
                BLS.NO_DECLAR1 declar,
                A_TCSDEB.NO_TC no_tc,
                TCS_BASE.TYPE_ISO type_tc,
                BLS.DESIGNATIONMAX produit,
                BLS.NOBL nobl,
                BLS.NOM_DEST client,
                'IMPORT' trafic,
                A_TCSDEB.DATE_DEB date_mvt,
                NAVIRE.LIBNAVIRE navire,
                A_TCSDEB.NOESCALE noescale,
                ESCALE.ETAD eta,
                BLS.CONVENIENCE convenience,
                (CASE WHEN A_TCSDEB.PLEIN_VIDE = 1 THEN 'PLEIN' ELSE 'VIDE' END) etat,
                'EOLIS Terminal Fruitier' parc,
                'Débarquement' details
            FROM EOLIS.A_TCSDEB 

            LEFT JOIN EOLIS.PREVISION_DEBARQ ON A_TCSDEB.IDPREV_DEBARQ = PREVISION_DEBARQ.IDPREV_DEBARQ 
            LEFT JOIN EOLIS.PREVS_DEBARQ_TCMANIF ON PREVISION_DEBARQ.IDPREV_DEBARQ = PREVS_DEBARQ_TCMANIF.IDPREV_DEBARQ 
            LEFT JOIN EOLIS.CONTENEU ON PREVS_DEBARQ_TCMANIF.IDCONTENEU = CONTENEU.IDCONTENEU 
            LEFT JOIN EOLIS.OPERATEU ON PREVISION_DEBARQ.CODEOPER = OPERATEU.CODEOPER
            LEFT JOIN EOLIS.TCS_BASE ON EOLIS.CONTENEU.NO_TC = EOLIS.TCS_BASE.NO_TC 
            LEFT JOIN EOLIS.BLS ON EOLIS.CONTENEU.IDBL = EOLIS.BLS.IDBL 

            LEFT JOIN EOLIS.PORT T0 ON T0.CODEPORT = EOLIS.BLS.PORT_EMB
            LEFT JOIN EOLIS.PORT T1 ON T1.CODEPORT = EOLIS.BLS.PORT_DEB

            LEFT JOIN EOLIS.ESCALE ON EOLIS.A_TCSDEB.NOESCALE = EOLIS.ESCALE.NOESCALE
            LEFT JOIN EOLIS.NAVIRE ON EOLIS.ESCALE.CODENAVIRE = EOLIS.NAVIRE.CODENAVIRE
            WHERE ESCALE.ETAD < CURRENT_DATE AND A_TCSDEB.IDTCSDEB = ?
        ", [$id,$id]);

        return response()->json($tcdeb, 200);
    }

    public function getDetailTcEmb($id)
    {
        $tcemb = DB::connection('eolis')->selectOne("
            SELECT 
                T0.LIBPORT port_dep,
                T1.LIBPORT port_arr,
                A_TCSEMB.POIDS_BRUT pbrut2,
                T2.POIDS_BRUT pbrut,
                TCS_BASE.TARE_TC tare_tc,
                A_TCSEMB.PLOMB1 plomb2,
                T2.PLOMB plomb,
                T2.DOSSIER dossier,
                T2.NO_DECLAR1 declar2,
                T2.NO_DECLAR declar,
                A_TCSEMB.NO_TC no_tc,
                TCS_BASE.TYPE_TC type_tc,
                PRODUIT.LIB_PRODUIT produit,
                T2.NOBL nobl,
                A_TCSEMB.NOM_CHARG client,
                'EXPORT' trafic,
                A_TCSEMB.DATE_MVT date_mvt,
                NAVIRE.LIBNAVIRE navire,
                A_TCSEMB.NOESCALE noescale,
                ESCALE.ETAD eta,
                T2.CONVENIENCE convenience,
                (CASE WHEN T2.CONVENIENCE = 1 THEN 'PLEIN' ELSE (CASE WHEN A_TCSEMB.PLEIN_VIDE = 1 THEN 'PLEIN' ELSE 'VIDE' END) END) etat,
                'FLOTTANT' parc,
                'Embarquement' details
            FROM EOLIS.A_TCSEMB 
            LEFT JOIN EOLIS.TCS_BASE ON EOLIS.A_TCSEMB.NO_TC = EOLIS.TCS_BASE.NO_TC
            LEFT JOIN EOLIS.PORT T0 ON T0.CODEPORT = EOLIS.A_TCSEMB.PORT_EMB
            LEFT JOIN EOLIS.PORT T1 ON T1.CODEPORT = EOLIS.A_TCSEMB.PORT_DEB
            LEFT JOIN EOLIS.PRODUIT ON EOLIS.A_TCSEMB.PRODUIT = EOLIS.PRODUIT.PRODUIT
            LEFT JOIN (
                    SELECT EOLIS.BOOKINGFINAL.PLOMB, EOLIS.BOOKINGFINAL.POIDS_BRUT, EOLIS.BOOKINGFINAL.NO_DECLAR, EOLIS.CONTENEU.NO_TC, EOLIS.BLS.DOSSIER, EOLIS.BLS.NO_DECLAR1, EOLIS.BLS.NOESCALE, EOLIS.BLS.IDBL, EOLIS.BLS.NOBL, EOLIS.BLS.CONVENIENCE
                    FROM EOLIS.BLS
                    INNER JOIN EOLIS.CONTENEU ON EOLIS.BLS.IDBL = EOLIS.CONTENEU.IDBL
                    LEFT JOIN EOLIS.BOOKENTET ON EOLIS.BLS.NOESCALE = EOLIS.BOOKENTET.NOESCALE
                    LEFT JOIN EOLIS.BOOKINGFINAL ON EOLIS.BOOKENTET.NOBOOK = EOLIS.BOOKINGFINAL.NOBOOK AND EOLIS.CONTENEU.NO_TC = EOLIS.BOOKINGFINAL.NO_TC
                ) T2 ON (A_TCSEMB.NO_TC = T2.NO_TC AND A_TCSEMB.NOESCALE = T2.NOESCALE)
            LEFT JOIN EOLIS.ESCALE ON EOLIS.A_TCSEMB.NOESCALE = EOLIS.ESCALE.NOESCALE
            LEFT JOIN EOLIS.NAVIRE ON EOLIS.ESCALE.CODENAVIRE = EOLIS.NAVIRE.CODENAVIRE
            WHERE A_TCSEMB.TOP_TBDT = 2 AND CONCAT(A_TCSEMB.NOESCALE,A_TCSEMB.NO_TC) = ?
        ", [$id]);

        return response()->json($tcemb, 200);
    }

    public function getDetailDepTcImp($id)
    {
        $deptc = DB::connection('eolis')->selectOne("
            SELECT 
                T0.LIBPORT port_dep,
                T1.LIBPORT port_arr,
                A_TCSDEB.POIDS_BRUT*1000 pbrut,
                TCS_BASE.TARE_TC tare_tc,
                A_TCSDEB.PLOMB1 plomb,
                BLS.DOSSIER dossier,
                BLS.NO_DECLAR1 declar,
                A_TCSDEB.NO_TC no_tc,
                TCS_BASE.TYPE_TC type_tc,
                (CASE WHEN PRODUIT.LIB_PRODUIT IS NULL THEN DEPOTAGE_TC_IMPORT.PRODUIT ELSE PRODUIT.LIB_PRODUIT END) produit,
                BLS.NOBL nobl,
                A_TCSDEB.NOM_DEST client,
                'IMPORT' trafic,
                DEPOTAGE_TC_IMPORT.DATE_DEPOTAGE date_mvt,
                NAVIRE.LIBNAVIRE navire,
                A_TCSDEB.NOESCALE noescale,
                ESCALE.ETAD eta,
                'VIDE' etat,
                'EOLIS Terminal Fruitier' parc,
                'Dépotage' details
            FROM EOLIS.DEPOTAGE_TC_IMPORT 
            INNER JOIN EOLIS.A_TCSDEB ON DEPOTAGE_TC_IMPORT.IDTCSDEB = A_TCSDEB.IDTCSDEB
            LEFT JOIN EOLIS.TCS_BASE ON EOLIS.A_TCSDEB.NO_TC = EOLIS.TCS_BASE.NO_TC
            LEFT JOIN EOLIS.PRODUIT ON EOLIS.DEPOTAGE_TC_IMPORT.PRODUIT = EOLIS.PRODUIT.PRODUIT
            LEFT JOIN EOLIS.BLS ON EOLIS.A_TCSDEB.IDBL = EOLIS.BLS.IDBL
            LEFT JOIN EOLIS.PORT T0 ON T0.CODEPORT = EOLIS.BLS.PORT_EMB
            LEFT JOIN EOLIS.PORT T1 ON T1.CODEPORT = EOLIS.BLS.PORT_DEB
            LEFT JOIN EOLIS.ESCALE ON EOLIS.A_TCSDEB.NOESCALE = EOLIS.ESCALE.NOESCALE
            LEFT JOIN EOLIS.NAVIRE ON EOLIS.ESCALE.CODENAVIRE = EOLIS.NAVIRE.CODENAVIRE
            WHERE A_TCSDEB.TOP_TBDT = 2 AND DEPOTAGE_TC_IMPORT.IDDEPOTAGE_TC_IMPORT = ?
        ", [$id]);

        return response()->json($deptc, 200);
    }

    public function getDetailMvtTc($id)
    {
        $mvttc = DB::connection('eolis')->selectOne("
            SELECT 
                1 in_out,
                A_MVTCS.TRANSPORTEUR transp,
                A_MVTCS.IMMAT_REM rem,
                A_MVTCS.IMMAT_TRACTEUR cam,
                A_MVTCS.NO_TC no_tc,
                TCS_BASE.TYPE_TC type_tc,
                PRODUIT.LIB_PRODUIT produit,
                '' nobl,
                OPERATEU.LIBOPER client,
                (CASE WHEN A_MVTCS.TYPEMVT = 1 THEN 'IMPORT' ELSE 
                    (CASE WHEN A_MVTCS.TYPEMVT = 2 THEN 'EXPORT' ELSE 
                        (CASE WHEN A_MVTCS.TYPEMVT = 3 THEN '' ELSE 
                            (CASE WHEN A_MVTCS.TYPEMVT = 4 THEN 'EXPORT' ELSE 
                                (CASE WHEN A_MVTCS.TYPEMVT = 5 THEN 'EXPORT' ELSE '' END) END
                            ) END
                        ) END
                    ) END
                ) trafic,
                A_MVTCS.DATE_MVT date_mvt,
                '' navire,
                '' noescale,
                null eta,
                (CASE WHEN A_MVTCS.PLEIN_VIDE = 1 THEN 'PLEIN' ELSE 'VIDE' END) etat,
                A_MVTCS.DESTINATION parc,
                (CASE WHEN A_MVTCS.TYPEMVT = 1 THEN 'Livraison' ELSE 
                    (CASE WHEN A_MVTCS.TYPEMVT = 2 THEN 'Positionnement' ELSE 
                        (CASE WHEN A_MVTCS.TYPEMVT = 3 THEN 'Retour Vide' ELSE 
                            (CASE WHEN A_MVTCS.TYPEMVT = 4 THEN 'Transfert' ELSE 
                                (CASE WHEN A_MVTCS.TYPEMVT = 5 THEN 'Retour Plein' ELSE '' END) END
                            ) END
                        ) END
                    ) END
                ) details
            FROM EOLIS.A_MVTCS 
            LEFT JOIN EOLIS.TCS_BASE ON EOLIS.A_MVTCS.NO_TC = EOLIS.TCS_BASE.NO_TC
            LEFT JOIN EOLIS.PRODUIT ON EOLIS.A_MVTCS.PRODUIT = EOLIS.PRODUIT.PRODUIT
            LEFT JOIN EOLIS.OPERATEU ON EOLIS.A_MVTCS.CODEOPER = EOLIS.OPERATEU.CODEOPER
            WHERE A_MVTCS.ID_MVTCS = ?
        ", [$id]);

        return response()->json($mvttc, 200);
    }


    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = A_Etatcs::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'no_tc' => 'no_tc',
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
    public function indexView()
    {
        $req = View_Douane_Mvt_Tcs::with([]);

        if(request()->has('search') && request()->search != '')
        {
            if(request()->statut == 'nobl')
            {
                $req->whereRaw("UPPER(nobl) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
            else if(request()->statut == 'notc')
            {
                $req->whereRaw("UPPER(REPLACE(no_tc,'-','')) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
            else if(request()->statut == 'navire')
            {
                $req->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            }
        }

        $displayedColumns = [
            'no_tc' => 'no_tc', 
            'type_tc' => 'type_tc', 
            'produit' => 'produit', 
            'nobl' => 'nobl', 
            'client' => 'client', 
            'trafic' => 'trafic', 
            'date_mvt' => 'date_mvt', 
            'navire' => 'navire', 
            'noescale' => 'noescale', 
            'eta' => 'eta', 
            'etat' => 'etat', 
            'parc' => 'parc', 
            'details' => 'details',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->get(), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(A_Etatcs::orderBy('no_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $a_Etatcs = A_Etatcs::create($request->all());
        return response()->json($a_Etatcs, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\A_Etatcs  $a_Etatcs
     * @return \Illuminate\Http\Response
     */
    public function show(A_Etatcs $a_Etatcs)
    {
        $a_Etatcs->load([]);
        return response()->json($a_Etatcs, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_Etatcs  $a_Etatcs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_Etatcs $a_Etatcs)
    {/*
        $a_Etatcs->update($request->except(['id']));
        return response()->json($a_Etatcs, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_Etatcs  $a_Etatcs
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_Etatcs $a_Etatcs)
    {/*
        try{
            $a_Etatcs->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
