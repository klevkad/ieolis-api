<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\FinRetourTcCreateRequest;
use App\Http\Requests\Export\FinRetourTcUpdateRequest;
use App\Models\Export\FinRetourTc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FinRetourTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:finretourtcfilter')->only('filter');
        $this->middleware('permission:finretourtcpaginate')->only('paginate');
        $this->middleware('permission:finretourtcindex')->only('index');
        $this->middleware('permission:finretourtccreate')->only('store');
        $this->middleware('permission:finretourtcshow')->only('show');
        $this->middleware('permission:finretourtcupdate')->only('update');
        $this->middleware('permission:finretourtcdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\FinRetourTc::class, 'fin_retour_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = FinRetourTc::with(['localite.model'])->orderBy('libelle','ASC');

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
        $req = FinRetourTc::with(['localite.model','typeFinRetourTc','approcarburant']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("annee LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('typeFinRetourTc', function (Builder $q) {
                          $q->whereRaw("UPPER(libelle) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libelle','ASC');
                        })
                      ->orWhereRaw("inscrits LIKE ?", ['%'.request()->search.'%']);
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'libelle' => 'libelle',
            'annee' => 'annee',
            'inscrits' => 'inscrits',
//            'type_finRetourTc' => 'type_finRetourTcs.libelle',
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
        return response()->json(FinRetourTc::orderBy('annee')->orderBy('libelle')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinRetourTcCreateRequest $request)
    {
        $request->merge([
            'dateh_arrive_cam' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_arrive_cam)->toDateTimeString(),
        ]);
        
        $finRetourTc = FinRetourTc::create($request->all());
        if($request->qte_appro && $request->qte_appro > 0)
        {
            $attributionCliponRetour->approcarburant()->create($request->only(['bon_appro', 'idlieu_appro', 'qte_appro']) + [
                'idengin' => $request->idclipon,
                'date_appro' => $request->date_appro ? $request->date_appro : date('Y-m-d'),
            ]);
        }

        if( $request->appro_cam )
        {
            $finRetourTc->approcarburant()->create([
                'idengin' => $request->idclipon,
                'bon_appro' => $request->idboncam, 
                'idlieu_appro' => $request->idlieu_appro_cam, 
                'qte_appro' => $request->qte_appro_arrive_cam,
                'date_appro' => $request->dateh_arrive_cam ? $request->dateh_arrive_cam : date('Y-m-d'),
            ]);
            $finRetourTc->lieuapprocamion;
            if($request->idboncam != '')
            {
                $finRetourTc->sorties2()->attach($request->idboncam);
            }
        }

        if( $request->appro_cli )
        {
            $finRetourTc->approcarburant()->create([
                'idengin' => $request->idclipon,
                'bon_appro' => $request->idboncli, 
                'idlieu_appro' => $request->idlieu_appro_cli_arr, 
                'qte_appro' => $request->qte_appro_arrive_clipon,
                'date_appro' => $request->dateh_arrive_cam ? $request->dateh_arrive_cam : date('Y-m-d'),
            ]);
            $finRetourTc->lieuapproclipon;
            if($request->idboncli != '')
            {
                $finRetourTc->sorties2()->attach($request->idboncli);
            }
        }

        if( $finRetourTc->sortiesfinretourtc )
        {
            $finRetourTc->sortiesfinretourtc->each(function($elt){
                return $elt->sortie->lignesorties;
            });
        }

        $finRetourTc->dateh_arrive_cam = Carbon::createFromFormat('Y-m-d H:i:s', $finRetourTc->dateh_arrive_cam)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($finRetourTc, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinRetourTc  $finRetourTc
     * @return \Illuminate\Http\Response
     */
    public function show(FinRetourTc $finRetourTc)
    {
        $finRetourTc->load(['typeFinRetourTc', 'localite']);
        return response()->json($finRetourTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinRetourTc  $finRetourTc
     * @return \Illuminate\Http\Response
     */
    public function update(FinRetourTcUpdateRequest $request, FinRetourTc $finRetourTc)
    {
        $request->merge([
            'dateh_arrive_cam' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_arrive_cam)->toDateTimeString(),
        ]);

        $data = [];

        if( !$request->appro_cam )
        {
            $data['idlieu_appro_cam'] = '';
            $data['qte_appro_arrive_cam'] = '';
        }

        if( !$request->appro_cli )
        {
            $data['idlieu_appro_cli_arr'] = '';
            $data['qte_appro_arrive_clipon'] = '';
        }

        $finRetourTc->update( $request->all() + $data);
        $finRetourTc->sorties2()->detach();

        if( $request->appro_cam )
        {
            $finRetourTc->lieuapprocamion;
            if($request->idboncam != '')
            {
                $finRetourTc->sorties2()->attach($request->idboncam);
            }
        }

        if( $request->appro_cli )
        {
            $finRetourTc->lieuapproclipon;
            if($request->idboncli != '')
            {
                $finRetourTc->sorties2()->attach($request->idboncli);
            }
        }

        if( $finRetourTc->sortiesfinretourtc )
        {
            $finRetourTc->sortiesfinretourtc->each(function($elt){
                return $elt->sortie->lignesorties;
            });
        }

        $finRetourTc->dateh_arrive_cam = Carbon::createFromFormat('Y-m-d H:i:s', $finRetourTc->dateh_arrive_cam)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($finRetourTc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinRetourTc  $finRetourTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinRetourTc $finRetourTc)
    {
        try{
            $finRetourTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
