<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Old\Eolis\A_Tcsdeb;
use App\Models\Old\Eolis\A_Tcsemb;
use App\Models\Old\Eolis\Escale;
use App\Models\Old\Eolis\View_listetc_a_debarque;
use App\Models\Old\Eolis\View_listetc_a_embarque;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscaleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:escalefilter')->only('filter');
        $this->middleware('permission:escalepaginate')->only('paginate');
        $this->middleware('permission:escaleindex')->only('index');
        $this->middleware('permission:escalecreate')->only('store');
        $this->middleware('permission:escaleshow')->only('show');
        $this->middleware('permission:escaleupdate')->only('update');
        $this->middleware('permission:escaledelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Eolis\Escale::class, 'escale');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterEscale()
    {
        $req = Escale::with(['navire'])->orderBy('voyage','ASC')->orderBy('noescale','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->where('codeport','CIABJ')
                ->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('etad','>=',date('Y-m-d'));
            }

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterVoyage()
    {
        $req = Escale::with(['navire'])->orderBy('voyage','ASC')->orderBy('noescale','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->where('codeport','CIABJ')
                ->whereRaw("UPPER(voyage) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('etad','>=',date('Y-m-d'));
            }

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    public function filterListeTcDebVoyage()
    {
        $req = View_listetc_a_debarque::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    public function filterListeTcEmbVoyage()
    {
        $req = View_listetc_a_embarque::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }


    public function ListeEscaleADebarquer()
    {
        $escales = Escale::with('navire')
            ->whereBetween('etad', [
                now()->subDays(5)->toDateString(),
                now()->addDays(5)->toDateString()
            ])
            ->orderBy('etad', 'DESC')
            ->get()
            ->map(function ($escale) {
                return [
                    'noescale' => $escale->noescale,
                    'libnavire' => $escale->navire->libnavire,
                    'etad' => $escale->etad,
                ];
            }); 
        
            return response()->json($escales, 200);
    }

    public function ListeEscaleAEmbarquer()
    {
    $req = View_listetc_a_embarque::select('noescale', 'libnavire','etad')
        ->groupBy('noescale', 'libnavire','etad')
        ->orderBy('noescale', 'ASC');
        return response()->json($req->get(), 200);
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function paginate()
    {
        $req = Escale::with(['navire', 'qty_deb', 'qty_emb'])->where('etad','<=',date('Y-m-d'));

        if(request()->has('search') && request()->search != '')
        {
            $req->leftjoin(DB::raw('eolis.navire'),'escale.codenavire','=',DB::raw('eolis.navire.codenavire'))
                ->where(function ($query) {
                    $query->whereRaw("UPPER(libnavire) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(noescale) LIKE '%".mb_strtoupper(request()->search)."%'")
                        ->orWhereRaw("UPPER(etad) LIKE '%".mb_strtoupper(request()->search)."%'");
                });
        }

         if(request()->has('export') && request()->export != '')
        {
            $req->where(function ($query) {
                    $query->where('code_trafic',2)
                        ->orWhere('code_trafic',3);
                });
        }

        $displayedColumns = [
            'libnavire' => 'libnavire',
            'noescale' => 'noescale',
            'etad' => 'etad',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }

        return response()->json($req->paginate(request()->size), 200);
    }
 
    public function operationNavire(Escale $escale)
    {
        $escale->navire;

        $dat0 = A_Tcsdeb::with(['port_orig','port_dest'])->selectRaw(
            "A_TCSDEB.NOESCALE, NO_TC, DATE_DEB as DATE_OP, PLEIN_VIDE, PLOMB1, POIDS_BRUT, 0 as TARE_TC, BLS.NOBL, BLS.CODE_CARR, BLS.NOM_CHARG, BLS.PORT_EMB, BLS.PORT_DEB, LIB_PRODUIT, 'deb' as TYPE_OPERATION"
        )->leftjoin('BLS','BLS.IDBL','=','A_TCSDEB.IDBL')
        ->where('A_TCSDEB.NOESCALE',$escale->noescale)->where('TOP_TBDT',2);

        $data = array(
            'operations' => A_Tcsemb::with(['port_orig','port_dest'])->selectRaw(
                    "NOESCALE, NO_TC, DATE_MVT as DATE_OP, PLEIN_VIDE, PLOMB1, POIDS_BRUT, TARE_TC, '' as NOBL, CODE_CARR, NOM_CHARG, PORT_EMB, PORT_DEB, LIB_PRODUIT, 'emb' as TYPE_OPERATION"
                )->leftjoin('PRODUIT','PRODUIT.PRODUIT','=','A_TCSEMB.PRODUIT')
                ->where('NOESCALE',$escale->noescale)->where('TOP_TBDT',2)
                ->union($dat0)
                ->orderBy('DATE_OP')->get(),
            'escale' => $escale
        );

        return response()->json($data, 200);
    }

    public function paginate2()
    {
        $req = Escale::with(['navire','embtcs','emb','deb']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('navire', function (Builder $q) {
                          $q->whereRaw("UPPER(libnavire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libnavire','ASC');
                        });
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'noescale' => 'noescale',
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
        return response()->json(Escale::orderBy('noescale')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
        $escale = Escale::create($request->all());
        return response()->json($escale, 201);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Escale  $escale
     * @return \Illuminate\Http\Response
     */
    public function show(Escale $escale)
    {
        $escale->load(['navire', 'embtcs', 'emb', 'deb', 'qty_emb', 'qty_deb']);
        return response()->json($escale, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Escale  $escale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escale $escale)
    {/*
        $escale->update($request->except(['id']));
        return response()->json($escale, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Escale  $escale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escale $escale)
    {/*
        try{
            $escale->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);*/
    }

}
