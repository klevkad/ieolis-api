<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\EmbarquementTcCreateRequest;
use App\Http\Requests\Export\EmbarquementTcUpdateRequest;
use App\Models\Export\AttributionTc;
use App\Models\Export\EmbarquementTc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EmbarquementTcController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:embarquementtcfilter')->only('filter');
        $this->middleware('permission:embarquementtcpaginate')->only('paginate');
        $this->middleware('permission:embarquementtcindex')->only('index');
        $this->middleware('permission:embarquementtccreate')->only('store');
        $this->middleware('permission:embarquementtcshow')->only('show');
        $this->middleware('permission:embarquementtcupdate')->only('update');
        $this->middleware('permission:embarquementtcdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Export\EmbarquementTc::class, 'embarquement_tc');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = EmbarquementTc::with(['escale'])->orderBy('noescale','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = AttributionTc::with([
            'retourtc.finretour',
            'retourtc.embarquementtc.escale.navire',
            'positionnementtcpropremoyen.retourtc.embarquementtc.escale.navire',
            'bookingtc.demandebooking.client',
            'bookingtc.demandebooking.escale.navire',
        ])->where(function ($query) {
            $query->has('positionnementtcpropremoyen.retourtc')->orHas('retourtc.finretour');
        });

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(plomb1) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('retourtc', function (Builder $q) {
                          $q->whereRaw("UPPER(num_plom_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereHas('retourtcpropremoyen', function (Builder $q) {
                          $q->whereRaw("UPPER(num_plom_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      })
                      ->orWhereHas('bookingtc.demandebooking', function (Builder $q) {
                          $q->whereExists(function ($q) {
                              $q->fromRaw("EOLIS.OPERATEU")
                                ->whereRaw("BOOKING.P_DEMANDE_BOOKING.CT_NUM = EOLIS.OPERATEU.CODEOPER")
                                ->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                          });
                      });
            });
        }

        if(request()->has('statut') && (request()->statut > -2 && request()->statut < 2) )
        {
            if( request()->statut == 1 )
            {
                $req->where(function ($query) {
                    $query->has('retourtc.embarquementtc')
                        ->orHas('positionnementtcpropremoyen.retourtc.embarquementtc');
                });
            }
            else if( request()->statut == -1 )
            {
                $req->doesnthave('retourtc.embarquementtc')
                    ->doesnthave('positionnementtcpropremoyen.retourtc.embarquementtc');
            }
        }

        $displayedColumns = [
            'no_tc' => 'no_tc',
            'plomb1' => 'plomb1',
            'dateh_emb' => 'dateh_saisie',
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
        return response()->json(EmbarquementTc::orderBy('dateh_emb')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmbarquementTcCreateRequest $request)
    {
        $request->merge([
            'dateh_emb' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_emb)->toDateTimeString()
        ]);

        $embarquementTc = EmbarquementTc::create($request->all());

        $embarquementTc->escale->navire;

        return response()->json($embarquementTc, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMany(Request $request)
    {
        $request->merge([
            'dateh_emb' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_emb)->toDateTimeString()
        ]);
        
        preg_match_all("#[a-zA-Z]{4}-[0-9]{6}-[0-9]#",$request->no_tcs,$numerotcs);

        $req = AttributionTc::with([ 'retourtc', 'retourtcpropremoyen' ])
                    ->where(function ($q) {
                        $q->where(function ($query) {
                            $query->has('retourtcpropremoyen')->doesntHave('retourtcpropremoyen.embarquementtc');
                        })->orWhere(function ($query) {
                            $query->has('retourtc')->doesntHave('retourtc.embarquementtc');
                        });
                    })->whereIn('no_tc',$numerotcs[0])
                    ->get();
                
        $reqNoTcs = $req->pluck('no_tc')->toArray();
        
        $tempdiff = array_diff($numerotcs[0], $reqNoTcs);
        $diff = [];
        foreach($tempdiff as $notc)
        {
            $diff[] = [
                'no_tc' => $notc,
                'dateh_emb' => $request->dateh_emb,
                'noescale' => $request->noescale
            ];
        }

        $data = [];
        foreach($req as $attrib)
        {
            $data[] = [
                'idretour_conteneur' => $attrib->retourtc ? $attrib->retourtc->idretour_conteneur : $attrib->retourtcpropremoyen->idretour_tc,
                'dateh_emb' => $request->dateh_emb,
                'noescale' => $request->noescale
            ];
        }

        if(sizeof($data) > 0)
        {
            $embarquementTc = EmbarquementTc::insert($data);
        }

        return response()->json($diff, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmbarquementTc  $embarquementTc
     * @return \Illuminate\Http\Response
     */
    public function show(EmbarquementTc $embarquementTc)
    {
        $embarquementTc->escale->navire;
        return response()->json($embarquementTc, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmbarquementTc  $embarquementTc
     * @return \Illuminate\Http\Response
     */
    public function update(EmbarquementTcUpdateRequest $request, EmbarquementTc $embarquementTc)
    {
        $request->merge([
            'dateh_emb' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->dateh_emb)->toDateTimeString()
        ]);

        $embarquementTc->update($request->all());

        $embarquementTc->dateh_emb = Carbon::createFromFormat('Y-m-d H:i:s', $embarquementTc->dateh_emb)->format('Y-m-d\TH:i:s.u\Z');

        $embarquementTc->escale->navire;
        return response()->json($embarquementTc, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmbarquementTc  $embarquementTc
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmbarquementTc $embarquementTc)
    {
        try{
            $embarquementTc->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

}
