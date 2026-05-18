<?php

namespace App\Http\Controllers\Old\Acconage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Old\Acconage\BranchementCreateRequest;
use App\Http\Requests\Old\Acconage\BranchementUpdateRequest;
use App\Models\Old\Acconage\Branchement;
use App\Models\Old\Acconage\Compteur;
use App\Models\Old\Eolis\A_Mvtcs;
use App\Models\Old\Eolis\Conteneu;
use App\Models\Old\Eolis\Prevision_Debarq;
use App\Models\Old\Eolis\Prevs_Debarq_Tcmanif;
use App\Models\Old\Eolis\Produit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchementController extends Controller
{
    public $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    public $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Branchement::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->whereNull('heurfinbranch')
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
        $req = Branchement::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function(Builder $qry) {
                $qry->whereRaw("UPPER(numcompteur) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(codearma) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(temp) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(codeoper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(produit) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(codeoper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(codeuser) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("UPPER(no_fact) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                    ->orWhereRaw("heurdebutbranch LIKE ?", ['%'.request()->search.'%'])
                    ->orWhereRaw("heurfinbranch LIKE ?", ['%'.request()->search.'%'])
                    ->orWhereRaw("heurfinbranchfactu LIKE ?", ['%'.request()->search.'%'])
                    ->orWhereRaw("date_branch_fact LIKE ?", ['%'.request()->search.'%'])
                    ->orWhereHas('compteur', function (Builder $q) {
                        $q->whereRaw("UPPER(anotation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    })
                    ->orWhereExists(function ($q) {
                        $q->fromRaw("EOLIS.OPERATEU")
                        ->whereRaw("ACCONAGE.T_OPERA_BRANCH.CODEOPER = EOLIS.OPERATEU.CODEOPER")
                        ->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    })
                    ->orWhereExists(function ($q) {
                        $q->fromRaw("EOLIS.PORT")
                        ->whereRaw("ACCONAGE.T_OPERA_BRANCH.CODEPORT = EOLIS.PORT.CODEPORT")
                        ->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    })
                    /*
                    ->orWhereHas('operateur', function (Builder $q) {
                        $q->whereRaw("UPPER(lib_oper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    })
                    ->orWhereHas('port', function (Builder $q) {
                        $q->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    })
                    */
                    ->orWhereHas('produit', function (Builder $q) {
                        $q->whereRaw("UPPER(lib_grp_prod) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                    });
            });
        }

        if(request()->has('statut') && (request()->statut == -1 || request()->statut == 1))
        {
            /*
                {id: '-1', name: 'Branchements en cours'},
                {id: '1', name: 'Branchements terminés'}
            */

            if(request()->statut == -1)
            {
                $req->whereNull('heurfinbranch');
            }
            else if(request()->statut == 1)
            {
                $req->whereNotNull('heurfinbranch');
            }
        }

        $displayedColumns = [
            'numcompteur' => 'numcompteur',
            'noescale' => 'noescale',
            'no_tc' => 'no_tc',
            'heurdebutbranch' => 'heurdebutbranch',
            'heurfinbranch' => 'heurfinbranch',
            'codeuser' => 'codeuser',
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
        //
    }

    public function debranch(Branchement $branchement)
    {
        $today = date('Y-m-d H:i:s');
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $today);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $branchement->heurdebutbranch);

        $diff_in_hours = $to->diffInHours($from);

        $branchement->update([
            'semainefin' => date('W',strtotime($today)),
            'heurfinbranch' => $today,
            'nbreheure_reel' => $diff_in_hours,
        ]);
        return response()->json($branchement, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchementCreateRequest $request)
    {
        $ans = Branchement::whereRaw("UPPER(no_tc) = ?", [mb_strtoupper($request->no_tc)])->whereNull('heurfinbranch')->get();
        $cptr = Compteur::findOrFail($request->numcompteur);
        if(sizeof($ans) && ($cptr->nbrepriselibre > 0))
        {
            return response()->json([], 403);
        }

        $today = date('Y-m-d H:i:s');
        $codeoper = '';
        $produit = '';
        if($request->trafic == 1) // IMPORT
        {
            //conteneu depotage_a_quai 0 ou 1
            //convcont depotage_a_quai 0 ou 1
            $prevDeb = Prevision_Debarq::whereHas('prevdebarqtcmanif', function (Builder $q) {
                $q->whereHas('conteneu', function (Builder $q1) {
                    $q1->where('no_tc', request()->no_tc);
                })->where('plein_vide',1) //TC plein
                ->where('si_branche',1); //Branché
            })->orWhereHas('prevdebarqtcnmanif', function (Builder $q) {
                $q->where('no_tc', request()->no_tc);
            })->orWhereHas('prevdebarqvrac', function (Builder $q) {
                $q->whereHas('convcont', function (Builder $q1) {
                    $q1->where('no_tc', request()->no_tc);
                });
            })->orderBy('date_prev','desc')->get()->first();

            if($prevDeb)
            {
                $codeoper = $prevDeb->codeoper;
                $prod = Produit::whereRaw("UPPER(lib_produit) LIKE ?", ['%'.mb_strtoupper($prevDeb->lib_produit).'%'])->first();
                $produit = $prod->produit;
            }
        }
        else if($request->trafic == 2) // EXPORT
        {
            $aMvTc = A_Mvtcs::where('no_tc',$request->no_tc)->where('typemvt',5)->orderBy('date_mvt','desc')->get()->first();
            $codeoper = $aMvTc ? $aMvTc->codeoper : '';
            $produit = $aMvTc ? $aMvTc->produit : '';
        }
        else if($request->trafic == 3) // SHIFTING
        {
        }
        else if($request->trafic == 4) // TRANSBORDEMENT
        {
            //BLS tr_charg_bl = 2 ?
        }

        $branchement = Branchement::create($request->all() + [
            'semainedebut' => date('W',strtotime($today)),
//            'semainefin',
//            'noescale',
//            'codearma',
//            'codenavire',
/*
            'no_tc',
            'numcompteur',
*/
//            'trafic',
            'codeoper' => $codeoper,
            'produit' => $produit,
/*
            'temp',
            'idt_statu_tc',
*/
//            'codeport',
            'site' => 1,
            'heurdebutbranch' => $today,
//            'heurfinbranch',
//            'heurfinbranchfactu',
//            'nbreheure_reel',
//            'nbreheure_factu',
            'numerodumois' => date('n', strtotime($today)),
            'libmois' => $this->months[date('n', strtotime($today)) - 1],
            'datesaisie' => date('Y-m-d H:i:s'),
            'codeuser' => Auth::user()->model->codeuser,
//            'no_fact',
//            'date_branch_fact',
//            'num_bad',
//            'etat',
        ]);
        return response()->json($branchement, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\Branchement  $branchement
     * @return \Illuminate\Http\Response
     */
    public function show(Branchement $branchement)
    {
        return response()->json($branchement, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\Branchement  $branchement
     * @return \Illuminate\Http\Response
     */
    public function update(BranchementUpdateRequest $request, Branchement $branchement)
    {
        $branchement->update($request->all());
        return response()->json($branchement, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\Branchement  $branchement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branchement $branchement)
    {
        try{
            $branchement->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
