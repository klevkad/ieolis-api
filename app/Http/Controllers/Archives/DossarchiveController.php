<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Models\Archives\Dossarchive;
use App\Models\Old\Eolis\View_Facentet;
use Illuminate\Http\Request;

class DossarchiveController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:dossarchivefilter')->only('filter');
        $this->middleware('permission:dossarchivepaginate')->only('paginate');
        $this->middleware('permission:dossarchiveindex')->only('index');
        $this->middleware('permission:dossarchivecreate')->only('store');
        $this->middleware('permission:dossarchiveshow')->only('show');
        $this->middleware('permission:dossarchiveupdate')->only('update');
        $this->middleware('permission:dossarchivedelete')->only('destroy');

        $this->authorizeResource(Dossarchive::class, 'dossarchive');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = Dossarchive::orderBy('nodossier','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(nodossier) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
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
        $req = Dossarchive::with(['documents']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(nodossier) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            });
        }

        $displayedColumns = [
            'nodossier' => 'nodossier',
            'date_creation' => 'date_creation',
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
     * @param  \App\Models\Archives\Dossarchive  $dossarchive
     * @return \Illuminate\Http\Response
     */
    public function show(Dossarchive $dossarchive)
    {
        $dossarchive->documents;
        $darr = $dossarchive->toArray();
        if (sizeof($dossarchive->documents) == 1) {
            $view_Facentet = View_Facentet::where('no_fact',$dossarchive->nodossier)->with(['documents', 'documents2'])->get();
            if(sizeof($view_Facentet) != 0) {
                $view_Facentet = $view_Facentet->first();
                $darr['documents'] = collect($view_Facentet->documents)->merge($view_Facentet->documents2)->merge($view_Facentet->documents3);
            }
        }
        return response()->json($darr, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Archives\Dossarchive  $dossarchive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dossarchive $dossarchive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archives\Dossarchive  $dossarchive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dossarchive $dossarchive)
    {
        //
    }
}
