<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use App\Models\Archives\Document;
use App\Models\Old\Eolis\Facentet;
use App\Models\Old\Eolis\View_Facentet;
use App\ExportDatas\FacturesClient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class FacentetController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:facentetfilter')->only('filter');
        $this->middleware('permission:facentetpaginate')->only('paginate');
        $this->middleware('permission:facentetindex')->only('index');
        $this->middleware('permission:facentetcreate')->only('store');
        $this->middleware('permission:facentetshow')->only('show');
        $this->middleware('permission:facentetupdate')->only('update');
        $this->middleware('permission:facentetdelete')->only('destroy');

//        $this->authorizeResource(View_Facentet::class, 'view_Facentet');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = View_Facentet::orderBy('no_fact','ASC');

        if(request()->has('search') && request()->search != '') 
        {
            $req->whereRaw("UPPER(no_fact) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        /*

        $data = Document::where('pages',0)->orderBy('date_enregistre','DESC')->limit(1000)->get();

        foreach($data as $datum)
        {
            try{

                $start = 15;
                $filename = str_replace('/', '\\', mb_substr($document->chemin_enregistre, $start));
                $pdftext = Storage::disk('ftp')->get(mb_strtoupper(pathinfo($filename, PATHINFO_DIRNAME).'\\'.pathinfo($filename, PATHINFO_FILENAME)).".".pathinfo($filename, PATHINFO_EXTENSION));
                $datum->update(['pages' => preg_match_all("/\/Page\W/", $pdftext, $dummy)]);
            }catch(\Illuminate\Contracts\Filesystem\FileNotFoundException $ex){
                $datum->update(['pages' => -1]);
            }catch(\ErrorException $ex){
                $datum->update(['pages' => -2]);
            }

        }

        */
 
        $req = View_Facentet::WhereExists(function ($q) {
            $q->fromRaw("ARCHIVE.DOCUMENTS")
              ->whereRaw("ARCHIVE.DOCUMENTS.NODOSSIER = EOLIS.VIEW_FACENTET.NO_FACT");
        })->with([/*'produitobj',*/ 'operateur', 'documents', 'documents2', 'bl', 'bltransit']);

        if(!Auth::user()->isUsername()) {
            $data = Auth::user()->ct_nums->pluck('ct_num')->concat([Auth::user()->ct_num]);
            $req->whereIn('code_cli', $data);
        }

        if(request()->has('status') && request()->status != '' )
        {
            $req->where('code_cli','=',request()->status);
        }

        if(request()->has('start') && request()->start != '' )
        {
            $req->whereDate('date_fact', '>=', request()->start);
        }

        if(request()->has('end') && request()->end != '' )
        {
            $req->whereDate('date_fact', '<=', request()->end);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_fact) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(lib_ent_fac) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
//                      ->orWhereRaw("UPPER(idbl) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('bl', function (Builder $q) {
                            $q->whereRaw("UPPER(nobl) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereHas('bltransit', function (Builder $q) {
                            $q->whereRaw("UPPER(nobl) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('client', function (Builder $q) {
                            $q->whereRaw("UPPER(lib_cli) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                        })
                      ->orWhereRaw("UPPER(nom_trans) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(nom_client) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(designation) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereHas('produitobj', function (Builder $q) {
                            $q->where('lib_produit',request()->search);
                        })
                      ->orWhereRaw("UPPER(justif) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])/*
                      ->orWhereRaw("UPPER(date_fact) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])*/
                      ->orWhereHas('operateur', function (Builder $q) {
                            $q->where('liboper',request()->search);
                        })
                      ->orWhereRaw("UPPER(date_echeance) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        $displayedColumns = [
            'reference_fne' => 'reference_fne',
            'no_fact' => 'no_fact',
            'lib_ent_fac' => 'lib_ent_fac',
            'idbl' => 'idbl',
            'noescale' => 'noescale',
            'code_cli' => 'code_cli',
            'nom_trans' => 'nom_trans',
            'nom_client' => 'nom_client',
            'designation' => 'designation',
            'justif' => 'justif',
            'date_fact' => 'date_fact',
            'date_echeance' => 'date_echeance',
        ];

        if(request()->has('sortby') && request()->has('sortorder') && array_key_exists(request()->sortby, $displayedColumns) && request()->sortorder != '')
        {
            $sortby = $displayedColumns[request()->sortby];
            $sortorder = strtolower(request()->sortorder) == 'desc' ? 'DESC' : 'ASC';
            $req->orderBy($sortby,$sortorder);
        }
        if(request()->has('all') && request()->all)
        {
            //return "Heollo";
            try{
                return response()->json($req->paginate(8000),200);  
            }catch(\Exception $ex){
                return response()->json(['error' => $ex->getMessage], 500);
            }
            //return response()->json($req->paginate(10000),200);//Excel::download(new FacturesClient($req->get()), 'factures.xlsx');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Eolis\Facentet  $facentet
     * @return \Illuminate\Http\Response
     */
    public function show(View_Facentet $view_Facentet)
    {
        $view_Facentet->load(['documents', 'documents2']);
        return response()->json($view_Facentet, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Eolis\Facentet  $facentet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facentet $facentet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Eolis\Facentet  $facentet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facentet $facentet)
    {
        //
    }
}
