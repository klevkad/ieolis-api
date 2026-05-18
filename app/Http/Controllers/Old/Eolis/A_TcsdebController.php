<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Old\Eolis\A_Tcsdeb;
use App\Models\Old\Eolis\A_Etatcs;
use App\Models\Old\Acconage\EmplacementConteneur;

class A_TcsdebController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:atcsdebfilter')->only('filter');
        $this->middleware('permission:atcsdebpaginate')->only('paginate');
        $this->middleware('permission:atcsdebindex')->only('index');
        $this->middleware('permission:atcsdebcreate')->only('store');
        $this->middleware('permission:atcsdebshow')->only('show');
        $this->middleware('permission:atcsdebupdate')->only('update');
        $this->middleware('permission:atcsdebdelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\A_Tcsdeb::class, 'atcsdeb');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = A_Tcsdeb::orderBy('no_tc','ASC');

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->limit(50);

            if(request()->has('searchFixe') && request()->searchFixe != '' && request()->searchFixe != 0)
            {
                $req->where('noescale', '=', request()->searchFixe);
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
        $req = A_Tcsdeb::with([]);

        if(request()->has('search') && request()->search != '')
        {
            $req->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'no_tc' => 'no_tc',
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
        return response()->json(A_Tcsdeb::orderBy('noescale')->orderBy('no_tc')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        DB::beginTransaction();
        try {
             if($request->plomb1 || $request->plomb2){
                $existingTcsdeb = A_Tcsdeb::where('noescale', $request->noescale)
                    ->where(function ($query) use ($request) {
                        $query->where('plomb1', $request->plomb1)
                            ->orWhere('plomb2', $request->plomb2);
                    })
                    ->first();
                if ($existingTcsdeb) {
                    return response()->json([ 
                        'status' => 0,
                        'msg' => 'Le plomb existe déjà pour cette escale.', 
                        'error' => null, 
                    ]);
                }
            }
            A_Etatcs::where('no_tc', $request->no_tc)->update(['last_mvt' => '']);
            $id = A_Etatcs::create([
                    'noescale' => $request->noescale,
                    'no_tc' => $request->no_tc,
                    'date_mvt' => date('Y-m-d H:i:s'),
                    'code_mvt' => 6,
                    'last_mvt' => 'X',
                    'top_transbordement' => $request->extbdt,
                    'codeuser' => \Auth::user()->model->codeuser,
                ])->id_auto;

               
            $dataToStore = $request->only(['idprev_debarq', 'no_tc', 'noescale','plein_vide','plomb1','plomb2','app']);
            $a_Tcsdeb = A_Tcsdeb::create($dataToStore+[
                'date_deb' => $request->date_deb ? date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->date_deb))) : null,
                'datesaisie' => date('Y-m-d H:i:s'),
                'codeuser' => \Auth::user()->model->codeuser,
                'top_tbdt' => $request->extbdt,
                'id_etat' => $id,
            ]);
            DB::commit();
            return response()->json([
                    'status' => 1,
                    'msg' => 'Enregistrement effectué avec succès.', 
                    'error' => null, // Only for development
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                    'status' => 0,
                    'msg' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.', // Generic message
                    'error' => $e->getMessage(), // Only for development
             ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\A_Tcsdeb  $a_Tcsdeb
     * @return \Illuminate\Http\Response
     */
    public function show(A_Tcsdeb $a_Tcsdeb)
    {
        $a_Tcsdeb->load([]);
        return response()->json($a_Tcsdeb, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_Tcsdeb  $a_Tcsdeb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_Tcsdeb $a_tcsdeb)
    {
        try{
            $a_tcsdeb->update([
                'plomb1' => $request->p1,
                'plomb2' => $request->p2,
                'date_deb' => $request->date_deb ? date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $request->date_deb))) : null,
            ]);
            return response()->json([
                    'status' => 1,
                    'msg' => 'Mise à jour de la ligne Réussie!', 
                    'error' => null, // Only for development
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'msg' => 'Une erreur est survenue lors de la mise à jour.', 
                'error' => $e->getMessage(), 
            ], 500);
        }
        /*
        $a_Tcsdeb->update($request->except(['id']));
        return response()->json($a_Tcsdeb, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_Tcsdeb  $a_Tcsdeb
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_Tcsdeb $a_tcsdeb)
    {
        try{
            $a_tcsdeb->delete();
            A_Etatcs::where('id_auto', $a_tcsdeb->id_etat)->delete();
            $lastEtat = A_Etatcs::where('no_tc', $a_tcsdeb->no_tc)->orderBy('date_mvt', 'DESC')->first();
            if($lastEtat){  
                $lastEtat->update(['last_mvt' => 'X']);
            }
        }catch(\Illuminate\Database\QueryException $ex){
             return response()->json([
                    'status' => 0,
                    'msg' => 'Une erreur est survenue lors de l\'annulation.', 
                    'error' => null, // Only for development
            ]);
        }
         return response()->json([
                    'status' => 1,
                    'msg' => 'Annulation de la ligne Réussie!', 
                    'error' => null, // Only for development
            ]);
    }

}
