<?php

namespace App\Http\Controllers\Old\Parc;

use App\Http\Controllers\Controller;
use App\Models\Old\Parc\Sortie;
use Illuminate\Http\Request;

class SortieControllerOld extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:sortiefilter')->only('filter');
        $this->middleware('permission:sortiepaginate')->only('paginate');
        $this->middleware('permission:sortieindex')->only('index');
        $this->middleware('permission:sortiecreate')->only('store');
        $this->middleware('permission:sortieshow')->only('show');
        $this->middleware('permission:sortieupdate')->only('update');
        $this->middleware('permission:sortiedelete')->only('destroy');

        $this->authorizeResource(\App\Models\Old\Parc\Sortie::class, 'sortie');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $to = date('Y-m-d');
        $from = date('Y-m-d', strtotime('-60 days',strtotime($to)));

        $req = Sortie::with('lignesorties');

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function($query) {
                    $query->where('numbon_phys','LIKE','%'.mb_strtoupper(request()->search).'%')
                        ->orWhere('numbon_phys','LIKE','%'.mb_strtolower(request()->search).'%');
                })->whereIn('idbon', function($query) use ($to, $from) {
                    $query->select('sortie.idbon')
                        ->from('sortie')
                        ->join('lignesor','sortie.idbon','=','lignesor.idbon')
                        ->join('piece','lignesor.idpiece','=','piece.idpiece')
                        ->where([
                            ['lignesor.idengin','like',request()->has('type') && request()->type == 'cam' ? '%CAM%' : 'CLI%'], 
                            ['piece.codefam','002'], 
                            ['piece.codepiece','0002']
                        ])->orWhere([
                            ['lignesor.idengin','like',request()->has('type') && request()->type == 'cam' ? '%LOCA%' : 'CLI%'], 
                            ['piece.codefam','002'], 
                            ['piece.codepiece','0002']
                        ])->whereBetween('lignesor.datesaisie',[$from, $to]);
                })->orderBy('numbon_phys','ASC')
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
        return response()->json(Sortie::orderBy('numbon_phys','ASC')->paginate(request()->size), 200);
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
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return \Illuminate\Http\Response
     */
    public function show(Sortie $sortie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sortie $sortie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sortie $sortie)
    {
        //
    }
}
