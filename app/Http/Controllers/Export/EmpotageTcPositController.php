<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\EmpotageTcPositCreateRequest;
use App\Http\Requests\Export\EmpotageTcPositUpdateRequest;
use App\Models\Export\AttributionTc;
use App\Models\Export\EmpotageTcPosit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EmpotageTcPositController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:empotagetcpositfilter')->only('filter');
        $this->middleware('permission:empotagetcpositpaginate|retourtcpaginate')->only('paginate');
        $this->middleware('permission:empotagetcpositindex')->only('index');
        $this->middleware('permission:empotagetcpositcreate')->only('store');
        $this->middleware('permission:empotagetcpositcreate')->only('setDatehFinEmpotage');
        $this->middleware('permission:empotagetcpositshow')->only('show');
        $this->middleware('permission:empotagetcpositupdate')->only('update');
        $this->middleware('permission:empotagetcpositdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\EmpotageTcPosit::class, 'empotage_tc_posit');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = EmpotageTcPosit::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = AttributionTc::with([
                    'retourtc.camion',
                    'retourtc.transporteur',
                    'retourtc.remorque',
                    'retourtc.chauffeur',
                    'retourtc.attributionclipon',
                    'retourtc.embarquementtc',
                    'retourtc.finretour.sortiesfinretourtc.sortie.lignesorties',
                    'retourtc.finretour.lieuapproclipon',
                    'retourtc.finretour.lieuapprocamion',
                    'empotagetc.stationempotage',
                    'attributionclipon',
                    'positionnementtcpropremoyen.retourtc.embarquementtc',
                    'bookingtc.demandebooking.client',
                ])->where(function ($query) {
                    $query->has('positionnementtcpropremoyen')->orHas('empotagetc');
                });


        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('bookingtc.demandebooking', function (Builder $q) {
                          $q->whereRaw("UPPER(ct_num) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereHas('empotagetc', function (Builder $q) {
                          $q->whereRaw("datehfin_empot LIKE ?", ['%'.request()->search.'%']);
                        });
            });
        }

        if(request()->has('statut') && (request()->statut > -4 && request()->statut < 3) )
        {
            /*
                -3 => Propres moyens en attente
                -2 => EOLIS Retours en attente
                -1 => EOLIS Retours en cours
                 1 => Terminés
                 2 => Terminés EOLIS
            */
            if( request()->statut == 2 )
            {
                $req->where(function ($query) {
                    $query->has('retourtc.finretour')
                        ->doesnthave('positionnementtcpropremoyen');
                });
            }
            else if( request()->statut == 1 )
            {
                $req->where(function ($query) {
                    $query->has('retourtc.finretour')
                        ->orHas('positionnementtcpropremoyen.retourtc');
                });
            }
            else if( request()->statut == -1 )
            {
                $req->doesnthave('retourtc.finretour')
                    ->has('retourtc');
            }
            else if( request()->statut == -2 )
            {
                $req->doesnthave('retourtc')
                    ->has('empotagetc');
            }
            else if( request()->statut == -3 )
            {
                $req->doesnthave('positionnementtcpropremoyen.retourtc')
                    ->has('positionnementtcpropremoyen');
            }
        }

        $displayedColumns = [
            'no_tc' => 'no_tc',
            'plomb1' => 'plomb1',
            'dateh_saisie' => 'dateh_saisie',
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
        return response()->json(EmpotageTcPosit::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpotageTcPositCreateRequest $request)
    {
        $request->merge([
            'datehdeb_empot' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->datehdeb_empot)->toDateTimeString(),
            'datehfin_empot' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->datehfin_empot)->toDateTimeString()
        ]);

        $empotageTcPosit = EmpotageTcPosit::create($request->all());

        return response()->json($empotageTcPosit, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmpotageTcPosit  $empotageTcPosit
     * @return \Illuminate\Http\Response
     */
    public function show(EmpotageTcPosit $empotageTcPosit)
    {
        $empotageTcPosit->load([
            'retourtc',
            'stationempotage',
            'positionnement.attributiontc.attributionclipon',
            'positionnement.attributiontc.bookingtc.demandebooking',
            'positionnement.remorque',
            'positionnement.camion',
            'positionnement.chauffeur',
            'positionnement.transporteur',
        ]);

        $empotageTcPosit->datehdeb_empot = Carbon::createFromFormat('Y-m-d H:i:s', $empotageTcPosit->datehdeb_empot)->format('Y-m-d\TH:i:s.u\Z');
        $empotageTcPosit->datehfin_empot = Carbon::createFromFormat('Y-m-d H:i:s', $empotageTcPosit->datehfin_empot)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($empotageTcPosit, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmpotageTcPosit  $empotageTcPosit
     * @return \Illuminate\Http\Response
     */
    public function update(EmpotageTcPositUpdateRequest $request, EmpotageTcPosit $empotageTcPosit)
    {
        $request->merge([
            'datehdeb_empot' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->datehdeb_empot)->toDateTimeString(),
            'datehfin_empot' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->datehfin_empot)->toDateTimeString()
        ]);

        $empotageTcPosit->update($request->except(['id']));
        $empotageTcPosit->stationempotage;

        return response()->json($empotageTcPosit, 200);
    }

    public function setDatehFinEmpotage(Request $request, EmpotageTcPosit $empotageTcPosit)
    {
        $request->merge([
            'datehfin_empot' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->datehfin_empot)->toDateTimeString()
        ]);

        if($empotageTcPosit->datehdeb_empot >= $request->datehfin_empot)
        {
            return response()->json(['message' => 'La date debut est supérieure à la date fin'], 422);
        }

        $empotageTcPosit->update($request->except(['id']));

        return response()->json($empotageTcPosit, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmpotageTcPosit  $empotageTcPosit
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmpotageTcPosit $empotageTcPosit)
    {
        try{
            $empotageTcPosit->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
