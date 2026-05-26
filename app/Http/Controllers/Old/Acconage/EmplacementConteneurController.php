<?php

namespace App\Http\Controllers\Old\Acconage;


use App\Http\Controllers\Controller;
use App\Models\Old\Acconage\EmplacementConteneur;
use App\Models\Old\Acconage\Compteur;
use Illuminate\Http\Request;

class EmplacementConteneurController extends Controller
{

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = EmplacementConteneur::with(['site','tcsbase'])->where('last_posit', 1)->orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
            ->orWhereHas('site', function($query) {
                $query->whereRaw("UPPER(lib_site) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
            })
            ->where('last_posit', 1)
            ->limit(10);

            return response()->json($req->get(), 200);
        }

        return response()->json([], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(EmplacementConteneur::with(['site','tcsbase'])->where('last_posit', 1)->orderBy('lib_site','ASC')->get(), 200);
    }


    public function countAllSites(){
        $data = EmplacementConteneur::join('t_site','emplacement_conteneur.id_site','=','t_site.id_site')
            ->selectRaw(' emplacement_conteneur.id_site,t_site.lib_site,COUNT(*) as total_tc')
            ->where('last_posit', 1)
            ->groupBy('emplacement_conteneur.id_site','t_site.lib_site')
            ->orderBy('t_site.lib_site','ASC')
            ->get();

        return response()->json([
            'status' => 1,
            'data' => $data
        ]);
    }


    public function getTcBySite($id_site){
        $data = EmplacementConteneur::where('id_site', $id_site)
        ->where('last_posit', 1)
        ->get();
        return response()->json([
            'status' => 1,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
    try {

        $noTcs = $request->no_tc;

        foreach ($noTcs as $tc) {
            EmplacementConteneur::where('no_tc', trim($tc))->update(['last_posit' => 0]);
            EmplacementConteneur::create([
                'no_tc'     => trim($tc),
                'id_site'      => $request->id_site,
                'last_posit' => 1,
                'codeuser' => \Auth::user()->model->codeuser,
                // 'longitude' => $request->longitude,
                // 'latitude'  => $request->latitude,
            ]);
        }

        return response()->json([
            'status' => 1,
            'msg' => 'Enregistrements effectués avec succès'
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 0,
            'msg' => 'Erreur lors de l’enregistrement',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Old\Acconage\EmplacementConteneur  $EmplacementConteneur
     * @return \Illuminate\Http\Response
     */
    public function show(EmplacementConteneur $emplacement_tc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Old\Acconage\EmplacementConteneur  $EmplacementConteneur
     * @return \Illuminate\Http\Response
     */
    public function update(EmplacementConteneur $request, EmplacementConteneur $EmplacementConteneur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Acconage\EmplacementConteneur  $EmplacementConteneur
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmplacementConteneur $emplacement_tc)
    {
        //
    }
}
