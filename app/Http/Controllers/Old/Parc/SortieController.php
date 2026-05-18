<?php

namespace App\Http\Controllers\Old\Parc;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Old\Parc\Sortie;
use App\Models\Old\Parc\LigneSortie;
use App\Models\Old\Parc\Stockage;
use App\Models\Old\Parc\OuvertureStation;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Storage;

class SortieController extends Controller
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
        $sortie=Sortie::with('lignesorties')->orWhere('ouverture_id','=',request()->ouverture_id)->orderBy('idbon','DESC');
        if(request()->has('search') && request()->search != '')
        {
            $sortie->where(function ($query) {
                  $query->where('numbon_phys','LIKE','%'.mb_strtoupper(request()->search).'%')
                        ->orWhere('numbon_phys','LIKE','%'.mb_strtolower(request()->search).'%');
            });
        }
        return response()->json($sortie->paginate(request()->size), 200);
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
   
        DB::beginTransaction();
        try {
           
            // if (Sortie::where('numbon_phys', request()->numbon_phys)->exists()){
            //     DB::rollBack();
            //     throw new \Exception("Le numero de bon physique existe déjà. Veuillez réessayer.");
            // }
            
            $currentYearLastTwoDigits = Carbon::now()->format('y'); 
            $currentMonthTwoDigits = Carbon::now()->format('m');   
            $prefixIDBON = $currentYearLastTwoDigits;// . '00' . $currentMonthTwoDigits; 
            $lastSortieWithPrefix = Sortie::where('idbon', 'like', $prefixIDBON . '%')
                                         ->orderByDesc('idbon') 
                                         ->first();

            $sequenceNumber = 1; 

            if ($lastSortieWithPrefix && strlen($lastSortieWithPrefix->idbon) >= 9) {
                $lastSequenceString = substr($lastSortieWithPrefix->idbon, 2, 7);
                $lastSequenceInt = (int) $lastSequenceString;
                $sequenceNumber = $lastSequenceInt + 1;
            }

            $formattedSequence = str_pad($sequenceNumber, 7, '0', STR_PAD_LEFT);

            $newIDBON = $prefixIDBON . $formattedSequence;
            $attempts = 0;
            while (Sortie::where('IDBON', $newIDBON)->exists() && $attempts < 100) {
                $sequenceNumber++;
                $formattedSequence = str_pad($sequenceNumber, 7, '0', STR_PAD_LEFT);
                $newIDBON = $prefixIDBON . $formattedSequence;
                $attempts++;
            }
            if ($attempts >= 100) {
                DB::rollBack();
                throw new \Exception("Impossible de générer un IDBON unique après plusieurs tentatives. Veuillez réessayer.");
            }
            
            $filePath = $this->storeSignature(request()->signature);
            $currentStock = Stockage::where('idpiece', request()->idpiece)
                            ->value('qte_tps_reel'); 

            if ($currentStock <= 0 || $currentStock-request()->qtesortie < 0) {
                DB::rollBack();
                return response()->json([
                    'status' => 0,
                    'msg' => "Stock insuffisant pour l'article " . request()->idpiece . ". Stock actuel: {$currentStock}", // Generic message
                    'error' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.',
                ]);
            }

            $dataToStore = $request->only(['numbon_phys','ouverture_id','chauffeur','sicampagnemangue','datebon']);
            $sortie = Sortie::create($dataToStore + [
                'idbon' => $newIDBON,
                'top_abjspy' => 1,
                'top_direct_stock' => 1,
                // 'datebon' => Carbon::now(),
                'type_imp' => 1,
                'commentaire' => "SORTIE CARBURANT",
                'min_url_signature' => $filePath,
                'full_url_signature' => Storage::disk('public')->url($filePath),
                'codeuser' => \Auth::user()->model->codeuser
            ]);

           
            $ligneSortie = LigneSortie::create($request->only(['idengin', 'qtesortie','idpiece'])+ [
                'idbon' => $newIDBON,
                'idjustif_sortie' => 0,
                'datesaisie' => Carbon::now(),
                'codeservice' => 'ACC',
                'enregistre' => \Auth::user()->model->codeuser
            ]);

            
            $quantiteAReduire = request()->qtesortie;

            Stockage::where('idpiece', request()->idpiece)
            ->increment('qte_sortie', $quantiteAReduire); 
        
            Stockage::where('idpiece', request()->idpiece)
            ->decrement('qte_tps_reel', $quantiteAReduire);

            $updateIndexLogique = OuvertureStation::where('ouverture_id', (int) request()->ouverture_id)->increment('index_logique', $quantiteAReduire);
           
           
           
            DB::commit(); 
            return response()->json($sortie, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 0,
                'msg' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.', // Generic message
                'error' => $e->getMessage(), // Only for development
            ]);
        }
        
    }

    private function storeSignature($base64){
        $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $base64);
        $filePath = 'signatures/' . uniqid('signature_') . '.png';

        $res = Storage::disk('public')->put($filePath, base64_decode($image));

        return $res ? $filePath : null;
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
        
        try {
            DB::beginTransaction();
            $sortie->update($request->except(['idbon']));
            $sortie->load('lignesorties');
            $sortie->lignesorties->each(function($ligneSortie) use ($request, $sortie) {

                $ligneSortie->update([
                    'qtesortie' => $request->qtesortie,
                    'idengin' => $request->idengin,
                    'enregistre' => \Auth::user()->model->codeuser
                ]);
                $quantiteDifference = $request->qtesortie - $request->qtesortieorigine;

                Stockage::where('idpiece', $ligneSortie->idpiece)->decrement('qte_sortie', $request->qtesortieorigine); 
                Stockage::where('idpiece', $ligneSortie->idpiece)->increment('qte_tps_reel', $request->qtesortieorigine);

                Stockage::where('idpiece', $ligneSortie->idpiece)->increment('qte_sortie', $request->qtesortie); 
            
                Stockage::where('idpiece', $ligneSortie->idpiece)->decrement('qte_tps_reel', $request->qtesortie);

                $station = OuvertureStation::where('ouverture_id', (int) $sortie->ouverture_id)->first();
                if ($station) {
                    $nouvelleValeur = $station->index_logique - $request->qtesortieorigine + $request->qtesortie;
                    if ($nouvelleValeur < 0) {
                        DB::rollBack();
                        throw new \Exception("La valeur de l'index logique ne peut pas être négative.");
                    }
                    $station->update(['index_logique' => $nouvelleValeur]);
                } 
            });
            DB::commit();
            return response()->json($sortie, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 0,
                'msg' => 'Une erreur est survenue lors de l\'enregistrement. Veuillez réessayer.', // Generic message
                'error' => ""//$e->getMessage(), // Only for development
            ]);
        }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Old\Parc\Sortie  $sortie
     * @return \Illuminate\Http\Response
     */

    public function destroy(Sortie $sortie)
    {
        DB::beginTransaction();
        try {
            $filename = $sortie->min_url_signature;
            if (Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
            }
            $ligneSortie = LigneSortie::where('idbon', $sortie->idbon)->first();

            if ($ligneSortie) {
                
                $quantiteDifference = $ligneSortie->qtesortie;
                Stockage::where('idpiece', $ligneSortie->idpiece)
                ->decrement('qte_sortie', $quantiteDifference); 
            
                Stockage::where('idpiece', $ligneSortie->idpiece)
                ->increment('qte_tps_reel', $quantiteDifference);

                $ligneSortie->delete();

                OuvertureStation::where('ouverture_id', $sortie->ouverture_id)
                ->decrement('index_logique', $quantiteDifference );
            }
            

            $sortie->delete();

            DB::commit();
            return response()->json([
                'status' => 1,
                'msg' => 'Sortie supprimée avec succès et stock restauré.'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 0,
                'msg' => 'Erreur lors de la suppression de la sortie.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
