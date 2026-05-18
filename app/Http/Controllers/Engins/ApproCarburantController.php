<?php

namespace App\Http\Controllers\Engins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Engins\ApproCarburantCreateRequest;
use App\Http\Requests\Engins\ApproCarburantUpdateRequest;
use App\Models\Engins\ApproCarburant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApproCarburantController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:approcarburantfilter')->only('filter');
        $this->middleware('permission:approcarburantpaginate')->only('paginate');
        $this->middleware('permission:approcarburantindex')->only('index');
        $this->middleware('permission:approcarburantcreate')->only('store');
        $this->middleware('permission:approcarburantshow')->only('show');
        $this->middleware('permission:approcarburantupdate')->only('update');
        $this->middleware('permission:approcarburantdelete')->only('destroy');

        $this->authorizeResource(\App\Models\Engins\ApproCarburant::class, 'appro_carburant');
    }

    /**
     * Display a paging of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $req = ApproCarburant::with(['lieuappro','model','engin']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(idengin) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(bon_appro) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("qte_appro LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("date_appro LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('lieuappro', function (Builder $q) {
                          $q->whereRaw("UPPER(libelle_lieu_appro) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        });
            });
        }

        if(request()->has('statut') && request()->statut != 0)
        {
            $req->where('idlieu_appro',request()->statut);
        }

        $displayedColumns = [
            'idengin' => 'idengin',
            'bon_appro' => 'bon_appro',
            'qte_appro' => 'qte_appro',
            'date_appro' => 'date_appro',
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
        return response()->json(ApproCarburant::orderBy('date_appro')->orderBy('idengin')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Engins\ApproCarburantCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApproCarburantCreateRequest $request)
    {
        $approCarburant = ApproCarburant::create($request->all());
        return response()->json($approCarburant, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return \Illuminate\Http\Response
     */
    public function show(ApproCarburant $approCarburant)
    {
        $approCarburant->load(['lieuappro','model','engin']);
        return response()->json($approCarburant, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\Engins\ApproCarburantUpdateRequest  $request
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return \Illuminate\Http\Response
     */
    public function update(ApproCarburantUpdateRequest $request, ApproCarburant $approCarburant)
    {
        $request->merge([
            'date_appro' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->date_appro)->toDateTimeString()
        ]);

        $approCarburant->update($request->except(['id']));
        $approCarburant->load(['lieuappro','model','engin']);
        return response()->json($approCarburant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engins\ApproCarburant  $approCarburant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApproCarburant $approCarburant)
    {
        try{
            $approCarburant->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }
}
