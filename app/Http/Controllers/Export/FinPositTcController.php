<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\FinPositTcCreateRequest;
use App\Http\Requests\Export\FinPositTcUpdateRequest;
use App\Models\Export\FinPositTc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FinPositTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:finposittcfilter')->only('filter');
        $this->middleware('permission:finposittcpaginate')->only('paginate');
        $this->middleware('permission:finposittcindex')->only('index');
        $this->middleware('permission:finposittccreate')->only('store');
        $this->middleware('permission:finposittcshow')->only('show');
        $this->middleware('permission:finposittcupdate')->only('update');
        $this->middleware('permission:finposittcdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\FinPositTc::class, 'fin_posit_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = FinPositTc::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = FinPositTc::with([
                    'retourtc',
                    'empotagetc.stationempotage',
                    'positionnement.stations',
                    'positionnement.attributiontc.attributionclipon',
                    'positionnement.attributiontc.bookingtc.demandebooking.client'
                ]);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereHas('positionnement.attributiontc', function (Builder $q) {
                          $q->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                            ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereHas('empotagetc', function (Builder $q) {
                          $q->whereRaw("UPPER(observation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereRaw("UPPER(dateh_arrive) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        if(request()->has('statut') && (request()->statut == -1 || request()->statut == 1) )
        {
            if( request()->statut == 1 )
            {
                $req->has('empotagetc');
            }
            else
            {
                $req->doesnthave('empotagetc');
            }
        }

        $displayedColumns = [
//            'no_tc' => 'no_tc',
//            'plomb1' => 'plomb1',
            'date_posit' => 'dateh_arrive',
/*            'datehdeb_empot' => 'datehdeb_empot', 
            'datehfin_empot' => 'datehfin_empot', 
            'si_depassement_facture' => 'si_depassement_facture', 
            'observation' => 'observation',*/
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
        return response()->json(FinPositTc::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinPositTcCreateRequest $request)
    {
        if(strlen($request->dateh_arrive) > 19)
        {
            $request->merge([
                'dateh_arrive' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_arrive)->toDateTimeString()
            ]);
        }

        $finPositTc = FinPositTc::create($request->all() + [
            'agent_com' => \Auth::user()->model->codeuser,
            'codeuser_modif' => \Auth::user()->model->codeuser
        ]);

        if($request->radVerif)
        {
            $finPositTc->finpositcliponverif()->create($request->all());
        }

        $finPositTc->dateh_arrive = Carbon::createFromFormat('Y-m-d H:i:s', $finPositTc->dateh_arrive)->format('Y-m-d\TH:i:s.u\Z');
        $finPositTc->finpositcliponverif;

        return response()->json($finPositTc, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinPositTc  $finPositTc
     * @return \Illuminate\Http\Response
     */
    public function show(FinPositTc $finPositTc)
    {
        $finPositTc->dateh_arrive = Carbon::createFromFormat('Y-m-d H:i:s', $finPositTc->dateh_arrive)->format('Y-m-d\TH:i:s.u\Z');
        return response()->json($finPositTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinPositTc  $finPositTc
     * @return \Illuminate\Http\Response
     */
    public function update(FinPositTcUpdateRequest $request, FinPositTc $finPositTc)
    {
        $request->merge([
            'dateh_arrive' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_arrive)->toDateTimeString()
        ]);

        $finPositTc->update($request->except(['id']) + [
            'codeuser_modif' => \Auth::user()->model->codeuser
        ]);

        if($finPositTc->finpositcliponverif)
        {
            if($request->radVerif)
            {
                $finPositTc->finpositcliponverif->update($request->all());
            }
            else
            {
                $finPositTc->finpositcliponverif->delete();
            }
        }
        else if($request->radVerif)
        {
            $finPositTc->finpositcliponverif()->create($request->all());
        }

        $finPositTc->dateh_arrive = Carbon::createFromFormat('Y-m-d H:i:s', $finPositTc->dateh_arrive)->format('Y-m-d\TH:i:s.u\Z');
        $finPositTc->load('finpositcliponverif');

        return response()->json($finPositTc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinPositTc  $finPositTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinPositTc $finPositTc)
    {
        try{
            $finPositTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
