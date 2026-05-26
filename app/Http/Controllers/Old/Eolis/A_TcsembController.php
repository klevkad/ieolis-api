<?php

namespace App\Http\Controllers\Old\Eolis;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Models\Old\Eolis\A_Etatcs;
use App\Models\Old\Eolis\A_Tcsemb;
use App\Models\Old\Eolis\BookingFinal;
use App\Models\Old\Acconage\EmplacementConteneur;

class A_TcsembController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:atcsembfilter')->only('filter');
        $this->middleware('permission:atcsembpaginate')->only('paginate');
        $this->middleware('permission:atcsembindex')->only('index');
        $this->middleware('permission:atcsembcreate')->only('store');
        $this->middleware('permission:atcsembshow')->only('show');
        $this->middleware('permission:atcsembupdate')->only('update');
        $this->middleware('permission:atcsembdelete')->only('destroy');

        // $this->authorizeResource(App\Models\Old\Eolis\A_Tcsemb::class, 'atcsemb');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = A_Tcsemb::with(['port_dest','port_orig','escale.navire'])->orderBy('noescale','ASC')->orderBy('no_tc','ASC');

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
        $req = A_Tcsemb::with(['port_dest','port_orig','escale.navire']);

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_tc) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(noescale) LIKE ?", ['%'.request()->search.'%'])
                      ->orWhereHas('escale.navire', function (Builder $q) {
                          $q->whereRaw("UPPER(libnavire) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libnavire','ASC');
                        })
                      ->orWhereHas('port_dest', function (Builder $q) {
                          $q->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libport','ASC');
                        })
                      ->orWhereHas('port_orig', function (Builder $q) {
                          $q->whereRaw("UPPER(libport) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])->orderBy('libport','ASC');
                        });
            });
        }
/*
        if(request()->has('statut') && request()->statut != '')
        {
            $req->where('idtransporteur',request()->statut);
        }
*/
        $displayedColumns = [
            'noescale' => 'noescale',
            'no_tc' => 'no_tc',
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
        return response()->json(A_Tcsemb::orderBy('noescale')->orderBy('no_tc')->get(), 200);
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
            
            if ($request->plomb || $request->plomb2) {
                $exists = A_Tcsemb::where('noescale', $request->noescale)
                    ->where(function ($query) use ($request) {
                        if ($request->plomb) {
                            $query->where('plomb1', $request->plomb);
                        }
                        if ($request->plomb2) {
                            $query->orWhere('plomb2', $request->plomb2);
                        }
                    })
                    ->exists(); 

                if ($exists) {
                    return response()->json([ 
                        'status' => 0,
                        'msg' => 'Le plomb saisi existe déjà pour cette escale.', 
                        'error' => null, 
                    ]);
                }
            }

            A_Etatcs::where('no_tc', $request->no_tc)->update(['last_mvt' => '']);
            $id = A_Etatcs::create([
                'noescale' => $request->noescale,
                'no_tc' => $request->no_tc,
                'date_mvt' => date('Y-m-d H:i:s'),
                'code_mvt' => 7,
                'last_mvt' => 'X',
                'top_transbordement' => $request->extbdt,
                'codeuser' => \Auth::user()->model->codeuser,
            ])->id_auto;

            $dataToStore = $request->only(['noescale', 'no_tc','plomb2','idbookingfinal','tare_tc','extbdt','port_deb','app']);
           
             $a_Tcsemb = A_Tcsemb::updateOrCreate(
                ['no_tc' => trim($request->no_tc),
                'noescale' => trim($request->noescale)], 
                $dataToStore + [
                    'date_mvt' => date('Y-m-d H:i:s'),
                    'datesaisie' => date('Y-m-d H:i:s'),
                    'port_emb' => 'CIABJ',
                    'plomb1' => $request->plomb,
                    'id_etat' => $id,
                    'codeuser' => \Auth::user()->model->codeuser,
                ]
            );
            // $a_Tcsemb = A_Tcsemb::create($dataToStore+[
            //     'date_mvt' => date('Y-m-d H:i:s'),
            //     'datesaisie' => date('Y-m-d H:i:s'),
            //     'port_emb' => 'CIABJ',
            //     'plomb1' => $request->plomb,
            //     'id_etat' => $id,
            //     'codeuser' => \Auth::user()->model->codeuser,
            // ]);
            
            BookingFinal::where('idbookingfinal', $request->idbookingfinal)->update(['etat_emb' => 2, 'embarque' => 'Emb']);
            EmplacementConteneur::where('no_tc', trim($request->no_tc))->update(['last_posit' => 0]);
            EmplacementConteneur::create([
                'no_tc'     => trim($request->no_tc),
                'id_site'      => 9,
                'last_posit' => 1,
                'sivide' => $request->nbprod==0 ? 2 : 1,
                'codeuser' => \Auth::user()->model->codeuser,
                // 'longitude' => $request->longitude,
                // 'latitude'  => $request->latitude,
            ]);
            return response()->json([
                    'status' => 1,
                    'msg' => 'Enregistrement effectué avec succès.', 
                    'error' => null, 
            ]);

            
            DB::commit();
         } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                 'status' => 0,
                 'msg' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.', 
                 'error' => $e->getMessage(), 
                ], 500);
          } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\A_Tcsemb  $a_Tcsemb
     * @return \Illuminate\Http\Response
     */
    public function show(A_Tcsemb $a_tcsemb)
    {
        $a_tcsemb->load(['port_dest','port_orig','escale.navire']);
        return response()->json($a_tcsemb, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_Tcsemb  $a_Tcsemb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_Tcsemb $a_tcsemb)
    {
        try{
            $a_tcsemb->update([
                'plomb1' => $request->p1,
                'plomb2' => $request->p2,
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_Tcsemb  $a_Tcsemb
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_Tcsemb $a_tcsemb)
    {
        try{
            $a_tcsemb->delete();
            A_Etatcs::where('id_auto', $a_tcsemb->id_etat)->delete();
            $lastEtat = A_Etatcs::where('no_tc', $a_tcsemb->no_tc)->orderBy('date_mvt', 'DESC')->first();
            if($lastEtat){  
                $lastEtat->update(['last_mvt' => 'X']);
            }
            BookingFinal::where('idbookingfinal', $a_tcsemb->idbookingfinal)->update(['etat_emb' => 1, 'embarque' => null]);

        }catch(\Illuminate\Database\QueryException $ex){
             return response()->json([
                    'status' => 0,
                    'msg' => 'Une erreur est survenue lors de l\'annulation.', 
                    'error' => null,
            ]);
        }
         return response()->json([
                    'status' => 1,
                    'msg' => 'Annulation de la ligne Réussie!', 
                    'error' => null, 
            ]);
    }

}
