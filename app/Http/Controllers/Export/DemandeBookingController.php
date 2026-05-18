<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Requests\Export\DemandeBookingCreateRequest;
use App\Http\Requests\Export\DemandeBookingTpCreateRequest;
use App\Http\Requests\Export\DemandeBookingTpUpdateRequest;
use App\Http\Requests\Export\DemandeBookingUpdateRequest;
use App\Mail\NouvelleDemandeBooking;
use App\Mail\NouvelleDemandeBookingTp;
use App\Models\Export\BookingTc;
use App\Models\Export\DemandeBooking;
use App\Models\Export\ParamTcReefer;
use App\Models\Old\Eolis\Escale;
use App\Models\Old\Eolis\Navire;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Image;

class DemandeBookingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:demandebookingfilter')->only('filter');
        $this->middleware('permission:demandebookingpaginate')->only('paginate');
        $this->middleware('permission:demandebookingindex')->only('index');
        $this->middleware('permission:demandebookingcreate')->only('store');
        $this->middleware('permission:demandebookingshow')->only('show');
        $this->middleware('permission:demandebookingupdate')->only('update');
        $this->middleware('permission:demandebookingdelete')->only('destroy');
        $this->middleware('permission:validationdemandebooking')->only('validationDemandeBooking');
        

        $this->authorizeResource(\App\Models\Export\DemandeBooking::class, 'demande_booking');
    }

    /**
     * Display a filtering of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $req = DemandeBooking::with(['bookingtc.attributiontcs', 'bookingtcfinal', 'destination', 'escale', 'client'])->orderBy('no_booking','DESC');

        if(request()->has('search') && request()->search != '')
        {
            if( request()->has('trans_eolis') && (request()->trans_eolis == 0 || request()->trans_eolis == 1) )
            {
                $req->where("si_transporteur_eolis",request()->trans_eolis);
            }

            $req->whereRaw("no_booking LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])/*
                ->orWhereRaw("date_demande LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                ->orWhereRaw("noescale LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])*/
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
        $req = DemandeBooking::with([
            'bookingtcfinal',
            'bookingtc.attributiontcs', 
            'bookingtc.paramtcreefer',
            'client',
            'destination',
            'transporteur',
            'escale.navire',
        ]);

        if(!\Auth::user()->isUsername()) {
            $req->where('ct_num',\Auth::user()->ct_num);
        }

        if(request()->has('search') && request()->search != '')
        {
            $req->where(function ($query) {
                $query->whereRaw("UPPER(no_booking) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereRaw("UPPER(noescale) LIKE ?", ['%'.mb_strtoupper(request()->search).'%'])
                      ->orWhereExists(function ($q) {
                          $q->fromRaw("EOLIS.OPERATEU")
                            ->whereRaw("BOOKING.P_DEMANDE_BOOKING.CT_NUM = EOLIS.OPERATEU.CODEOPER")
                            ->whereRaw("UPPER(liboper) LIKE ?", ['%'.mb_strtoupper(request()->search).'%']);
                      });
            });
        }

        if(request()->has('statut') && is_numeric(request()->statut) && request()->statut >= -1 && request()->statut <= 1 )
        {
            $req->where('si_valider','=',request()->statut);
        }

        $displayedColumns = [
            'no_booking' => 'no_booking',
            'qty' => 'nb_tcs',/*
            'type' => '',*/
            'date_dmd' => 'date_demande',/*
            'date_posit' => '',*/
            'trans' => 'si_transporteur_eolis',
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
        $req = DemandeBooking::orderBy('date_demande','DESC');
        if(!\Auth::user()->isUsername()) {
            $req->where('ct_num',\Auth::user()->ct_num);
        }

        /*
        $data = $req->get();
        foreach($data as $datum)
        {
            $this->generateBookingQrCodeF($datum);
        }
        */

        return response()->json($req->get(), 200);
    }

    public function generateBookingQrCodeF(DemandeBooking $dmd)
    {
        $path = Storage::disk('public')->path($dmd->qrcodefolder);
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $path = Storage::disk('public')->path($dmd->qrcode);
        Storage::delete($path);

        $pathmini = Storage::disk('public')->path($dmd->qrcode_minifolder);
        if(!File::isDirectory($pathmini)){
            File::makeDirectory($pathmini, 0777, true, true);
        }
        $pathmini = Storage::disk('public')->path($dmd->qrcode_mini);
        Storage::delete($pathmini);

        QrCode::size(500)->format('png')->merge('/public/storage/logoi.png',0.4)->errorCorrection('H')->generate($dmd->no_booking, $path);

        $imgQr = Image::make($path)->resize(300,300);
//        $imgQr->resize(300,300)->save($pathmini);

        return ['path' => $dmd->qrcodelink];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemandeBookingCreateRequest $request)
    {
        $request->merge([
            'date_demande' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->date_demande)->format('Y-m-d 00:00:00'),
            'date_posit_souhait' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->date_posit_souhait)->toDateTimeString(),
            'ct_num' => \Auth::user()->isUsername() ? $request->ct_num : \Auth::user()->ct_num,
        ]);

        $demandeBooking = DemandeBooking::create($request->all() + [
            'no_booking' => 'BOOK'.date('YmdHis'),
            'idutilisateur_client' => \Auth::user()->id,
            'si_valider' => -1
        ]); 
		$bookingTC = BookingTc::create($request->all() + [
            'codetype_tc' => 'FRI40',
            'iddemande_booking' => $demandeBooking->iddemande_booking
        ]);
		$paramTCReefer = ParamTcReefer::create($request->all() + [
            'idbooking_conteneur' => $bookingTC->idbooking_conteneur
        ]);

        // Write File
        $newJsonString = json_encode($request->only([
            'destinataire', 'carrier', 'anotifier', 'agent', 
            'pretrans', 'destfin', 'descrmarch', 'poidsbrut', 
            'dimensions', 'detailsfret', 'bldirectoui', 'bldirectnon',
            'conventionnel', 'vrac', 'conteneurFCLFCL', 'conteneurLCLLCL',
            'solas', 'chargeur', 'fretpay',
        ]), JSON_PRETTY_PRINT);
        Storage::disk('public')->makeDirectory('fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/');
        file_put_contents(base_path('storage/app/public/fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json'), $newJsonString);

        if($demandeBooking->si_valider == 1)
        {
            $this->generateBookingQrCodeF($demandeBooking);
            $pdf = PDF::loadView('documents.export.demande-booking', [ 'data' => ['dmd' => $demandeBooking, 'req' => $request] ]);
            $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.pdf') );

            Mail::send(new NouvelleDemandeBooking($demandeBooking));
        }

        return response()->json($demandeBooking, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTp(DemandeBookingTpCreateRequest $request)
    {
        $request->merge([
            'no_booking' => \Auth::user()->ct_num.'-'.substr(date('Y'),2,2).'-'.$request->no_booking,
            'date_demande' => date('Y-m-d'),
            'date_posit_souhait' => Carbon::createFromFormat('Y-m-d\TH:i:sP', $request->date_posit_souhait)->toDateTimeString(),
            'ct_num' => \Auth::user()->ct_num,
            'type_demande' => 0, //Booking TP
        ]);

        $demandeBooking = DemandeBooking::create($request->except(['noescale']) + [
            'idutilisateur_client' => \Auth::user()->id,
            'si_valider' => -1,
            'si_transporteur_eolis' => 1,
        ]);
		$bookingTC = BookingTc::create($request->all() + [
            'codetype_tc' => 'FRI40',
            'nb_tcs' => 1,
            'iddemande_booking' => $demandeBooking->iddemande_booking
        ]);
		$paramTCReefer = ParamTcReefer::create($request->all() + [
            'idbooking_conteneur' => $bookingTC->idbooking_conteneur
        ]);

        // Write File
        $newJsonString = json_encode($request->except(['file']), JSON_PRETTY_PRINT);
        Storage::disk('public')->makeDirectory('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/');
        file_put_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json'), $newJsonString);

        $request->file('file')->storeAs(
            'public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp',
            $demandeBooking->no_booking.'.pdf'
        );

        if($demandeBooking->si_valider == 1)
        {
            $this->generateBookingQrCodeF($demandeBooking);
            $pdf = PDF::loadView('documents.export.demande-booking-tp', [ 'data' => ['dmd' => $demandeBooking, 'req' => $request] ]);
            $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/EOL-'.$demandeBooking->no_booking.'.pdf') );

            Mail::send(new NouvelleDemandeBookingTp($demandeBooking));
        }

        return response()->json($demandeBooking, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function show(DemandeBooking $demandeBooking)
    {
        $demandeBooking->load([
            'client',
            'destination',
            'escale.navire',
            'transporteur',
            'produitdmd',
            'bookingtc.paramtcreefer',
            'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc.embarquementtc.escale.navire', 
            'bookingtc.attributiontcs.positionnementtc.portdep', 
            'bookingtc.attributiontcs.positionnementtc.portarr', 
            'bookingtc.attributiontcs.positionnementtc.transporteur', 
            'bookingtc.attributiontcs.positionnementtc.chauffeur', 
            'bookingtc.attributiontcs.positionnementtc.camion', 
            'bookingtc.attributiontcs.positionnementtc.remorque', 
            'bookingtc.attributiontcs.positionnementtc.finposit', 
            'bookingtc.attributiontcs.positionnementtc.empotagetc.stationempotage.lieu', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.attributionclipon', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.transporteur', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.chauffeur', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.camion', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.remorque', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.finretour', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.embarquementtc.escale.navire'
        ]);

        $demandeBooking->date_demande = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->date_demande)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->bookingtc->date_posit_souhait = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->bookingtc->date_posit_souhait)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->pdfdata = [];

        if( Storage::disk('public')->exists('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json') )
        {
            // Read File
            $jsonString = file_get_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json'));
            $data = json_decode($jsonString, true);
            $demandeBooking->pdfdata = $data;
        }

        if( Storage::disk('public')->exists('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json') )
        {
            // Read File
            $jsonString = file_get_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json'));
            $data = json_decode($jsonString, true);
            $demandeBooking->pdfdata = $data;
        }
/*
        Mail::send(new NouvelleDemandeBooking($demandeBooking));
*/
        return response()->json($demandeBooking, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function showByNoBooking(Request $request)
    {
        $demandeBooking = DemandeBooking::with([
            'client',
            'destination',
            'escale.navire',
            'transporteur',
            'produitdmd',
            'bookingtc.paramtcreefer',
            'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc.embarquementtc.escale.navire', 
            'bookingtc.attributiontcs.positionnementtc.portdep', 
            'bookingtc.attributiontcs.positionnementtc.portarr', 
            'bookingtc.attributiontcs.positionnementtc.transporteur', 
            'bookingtc.attributiontcs.positionnementtc.chauffeur', 
            'bookingtc.attributiontcs.positionnementtc.camion', 
            'bookingtc.attributiontcs.positionnementtc.remorque', 
            'bookingtc.attributiontcs.positionnementtc.finposit', 
            'bookingtc.attributiontcs.positionnementtc.empotagetc.stationempotage.lieu', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.attributionclipon', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.transporteur', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.chauffeur', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.camion', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.remorque', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.finretour', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.embarquementtc.escale.navire'
        ])->where('no_booking',$request->no_booking)->first();

        $demandeBooking->date_demande = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->date_demande)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->bookingtc->date_posit_souhait = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->bookingtc->date_posit_souhait)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->pdfdata = [];

        if( Storage::disk('public')->exists('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json') )
        {
            // Read File
            $jsonString = file_get_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json'));
            $data = json_decode($jsonString, true);
            $demandeBooking->pdfdata = $data;
        }

        return response()->json($demandeBooking, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function update(DemandeBookingUpdateRequest $request, DemandeBooking $demandeBooking)
    {
        Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.pdf');
        Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json');

        $request->merge([
            'date_demande' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->date_demande)->format('Y-m-d 00:00:00'),
            'date_posit_souhait' => Carbon::createFromFormat('Y-m-d\TH:i:s.u\Z', $request->date_posit_souhait)->toDateTimeString(),
            'ct_num' => \Auth::user()->isUsername() ? $request->ct_num : \Auth::user()->ct_num,
        ]);
        $demandeBooking->update($request->all());
        $demandeBooking->bookingtc->update($request->all());
        $demandeBooking->bookingtc->paramtcreefer->update($request->all());

        // Write File
        $newJsonString = json_encode($request->only([
            'destinataire', 'carrier', 'anotifier', 'agent', 
            'pretrans', 'destfin', 'descrmarch', 'poidsbrut', 
            'dimensions', 'detailsfret', 'bldirectoui', 'bldirectnon',
            'conventionnel', 'vrac', 'conteneurFCLFCL', 'conteneurLCLLCL',
            'solas', 'chargeur', 'fretpay',
        ]), JSON_PRETTY_PRINT);
        Storage::makeDirectory(base_path('storage/app/public/fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/'));
        file_put_contents(base_path('storage/app/public/fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json'), $newJsonString);

        if($demandeBooking->si_valider == 1)
        {
            $pdf = PDF::loadView('documents.export.demande-booking', [ 'data' => ['dmd' => $demandeBooking, 'req' => $request] ]);
            $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.pdf') );

            Mail::send(new NouvelleDemandeBooking($demandeBooking));
        }

        return response()->json($demandeBooking, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Export\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function updateTp(DemandeBookingTpUpdateRequest $request, DemandeBooking $demandeBooking)
    {
        Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/EOL-'.$demandeBooking->no_booking.'.pdf');
        Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json');

        $request->merge([
            'date_posit_souhait' => Carbon::createFromFormat('Y-m-d\TH:i:sP', $request->date_posit_souhait)->toDateTimeString(),
        ]);
        $demandeBooking->update($request->except(['noescale']));
        $demandeBooking->bookingtc->update($request->all());
        $demandeBooking->bookingtc->paramtcreefer->update($request->all());

        // Write File
        $newJsonString = json_encode($request->except(['file']), JSON_PRETTY_PRINT);
        Storage::makeDirectory(base_path('storage/app/public/fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'bookingtp/'));
        file_put_contents(base_path('storage/app/public/fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json'), $newJsonString);

        if($request->file('file'))
        {
            $request->file('file')->storeAs(
                'public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp',
                $demandeBooking->no_booking.'.pdf'
            );
        }

        if($demandeBooking->si_valider == 1)
        {
            $pdf = PDF::loadView('documents.export.demande-booking-tp', [ 'data' => ['dmd' => $demandeBooking, 'req' => $request] ]);
            $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($request->date_demande,0,4).'/'.substr($request->date_demande,5,2).'/'.'bookingtp/EOL-'.$demandeBooking->no_booking.'.pdf') );

            Mail::send(new NouvelleDemandeBookingTp($demandeBooking));
        }

        return response()->json($demandeBooking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemandeBooking $demandeBooking)
    {
        try{
            if($demandeBooking->type_demande)
            {
                Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.pdf');
                Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json');
            }
            else
            {
                Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/EOL-'.$demandeBooking->no_booking.'.pdf');
                Storage::disk('public')->delete('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json');
            }

            $demandeBooking->bookingtc->paramtcreefer->delete();
            $demandeBooking->bookingtc->delete();
            $demandeBooking->delete();
        }catch(\Illuminate\Database\QueryException $ex){
            return response()->json(['message' => 'Echec de suppression de la ligne: '.$ex->getMessage()], 403);
        }
        return response()->json(['message' => 'Suppression de la ligne Réussie!'], 200);
    }

    public function countTcFromDmd($demandeBooking)
    {
        $etatTcs = array(
            'tcmad' => ['title' => 'TC Mis à Dispo','url' => '/app/export/attribution-tc', 'queryparams' => ['status' => 1]],
            'tcem' => ['title' => 'TC En Posit','url' => '/app/export/positionnement', 'queryparams' => ['status' => 1]],
            'tcak' => ['title' => 'TC En Fin Posit','url' => '/app/export/positionnement', 'queryparams' => ['status' => 2]],
            'tcee' => ['title' => 'TC En Empotage','url' => '/app/export/empotage-tc', 'queryparams' => ['status' => -1]],
            'tcefe' => ['title' => 'TC En Fin Empotage','url' => '/app/export/empotage-tc', 'queryparams' => ['status' => 1]],
            'tced' => ['title' => 'TC En Retour','url' => '/app/export/retour-tc', 'queryparams' => ['status' => -1]],
            'tcaqf' => ['title' => 'TC au TMFA','url' => '/app/export/embarquement-tc', 'queryparams' => ['status' => -1]],
            'tcemb' => ['title' => 'TC Embarqué','url' => '/app/export/embarquement-tc', 'queryparams' => ['status' => 1]]
        );

        $recap = array();//step -> no_tc -> no_booking;
        $recapDet = array();//no_booking -> no_tc -> step
        $recapDet2 = array();//no_booking -> step -> no_tc;
        $recapIdBkg = array();//no_booking -> iddemande_booking;
        for($i=0; $i<sizeof($demandeBooking); $i++){
            $nobk = $demandeBooking[$i]->no_booking;
            $recapDet[$nobk] = array();
            $recapIdBkg[$nobk] = ['id' => $demandeBooking[$i]->iddemande_booking, 'cli' => $demandeBooking[$i]->ct_num, 'libcli' => $demandeBooking[$i]->client->liboper];
            if($demandeBooking[$i]->bookingtc != null){
                if( $demandeBooking[$i]->bookingtc->attributiontcs->count() ){
                    for($j=0; $j<sizeof($demandeBooking[$i]->bookingtc->attributiontcs); $j++){
                        $notc = $demandeBooking[$i]->bookingtc->attributiontcs[$j]->no_tc;
                        $recapDet[$nobk][$notc] = 'tcmad';

                        if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc != null){
                            $recapDet[$nobk][$notc] = 'tcem';

                            if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->finposit != null){
                                $recapDet[$nobk][$notc] = 'tcak';

                                if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->empotagetc != null){
                                    if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->empotagetc->datefin_empot != null){
                                        $recapDet[$nobk][$notc] = 'tcee';
                                    }else{
                                        $recapDet[$nobk][$notc] = 'tcefe';
                                    }

                                    if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->retourtc != null){
                                        $recapDet[$nobk][$notc] = 'tced';

                                        if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->retourtc->finretour != null){
                                            $recapDet[$nobk][$notc] = 'tcaqf';

                                            if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->retourtc->embarquementtc != null){
                                                $recapDet[$nobk][$notc] = 'tcemb';
                                                $recapDet2[$nobk]['tcemb'][] = $notc;
                                                $recap['tcemb'][$notc] = $nobk;
                                            }else{
                                                $recapDet2[$nobk]['tcaqf'][] = $notc;
                                                $recap['tcaqf'][$notc] = $nobk;
                                            }
                                        }else{
                                            $recapDet2[$nobk]['tced'][] = $notc;
                                            $recap['tced'][$notc] = $nobk;
                                        }
                                    }else{
                                        if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtc->empotagetc->datefin_empot != null){
                                            $recapDet2[$nobk]['tcee'][] = $notc;
                                            $recap['tcee'][$notc] = $nobk;
                                        }else{
                                            $recapDet2[$nobk]['tcefe'][] = $notc;
                                            $recap['tcefe'][$notc] = $nobk;
                                        }
                                    }
                                }else{
                                    $recapDet2[$nobk]['tcak'][] = $notc;
                                    $recap['tcak'][$notc] = $nobk;
                                }
                            }else{
                                $recapDet2[$nobk]['tcem'][] = $notc;
                                $recap['tcem'][$notc] = $nobk;
                            }
                        }else{
                            if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtcpropremoyen != null){
                                $recapDet[$nobk][$notc] = 'tcee';

                                if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtcpropremoyen->retourtc != null){
                                    $recapDet[$nobk][$notc] = 'tcaqf';

                                    if($demandeBooking[$i]->bookingtc->attributiontcs[$j]->positionnementtcpropremoyen->retourtc->embarquementtc != null){
                                        $recapDet[$nobk][$notc] = 'tcemb';
                                        $recapDet2[$nobk]['tcemb'][] = $notc;
                                        $recap['tcemb'][$notc] = $nobk;
                                    }else{
                                        $recapDet2[$nobk]['tcaqf'][] = $notc;
                                        $recap['tcaqf'][$notc] = $nobk;
                                    }
                                }else{
                                    $recapDet2[$nobk]['tcee'][] = $notc;
                                    $recap['tcee'][$notc] = $nobk;
                                }
                            }else{
                                $recapDet2[$nobk]['tcmad'][] = $notc;
                                $recap['tcmad'][$notc] = $nobk;
                            }
                        }
                    }
                }else{
                    $recapDet2[$nobk] = array();
                }
            }
        }

        $byStep = [];
        foreach($etatTcs as $key => $value)
        {
            $byStep[] = [
                'code' => $key, 
                'title' => $value['title'], 
                'qty' => isset($recap[$key]) ? sizeof($recap[$key]) : 0,
                'link' => $value
            ];
        }

        $byNoBooking = [];
        $byCliTemp = [];
        foreach($recapDet2 as $no_booking => $steps)
        {
            if(!isset($byCliTemp[$recapIdBkg[$no_booking]['cli']]))
            {
                $byCliTemp[$recapIdBkg[$no_booking]['cli']]['qty'] = 0;
                $byCliTemp[$recapIdBkg[$no_booking]['cli']]['libcli'] = $recapIdBkg[$no_booking]['libcli'];
            }

            $temp = [ 'iddemande_booking' => $recapIdBkg[$no_booking]['id'], 'ct_num' => $recapIdBkg[$no_booking]['cli'], 'libcli' => $recapIdBkg[$no_booking]['libcli'], 'no_booking' => $no_booking, 'tcmad' => 0, 'tcem' => 0, 'tcak' => 0, 'tcee' => 0, 'tcefe' => 0, 'tced' => 0, 'tcaqf' => 0, 'tcemb' => 0 ];
            foreach($steps as $step => $no_tcs)
            {
                $temp[$step] = sizeof($no_tcs);
                $byCliTemp[$recapIdBkg[$no_booking]['cli']]['qty'] += sizeof($no_tcs);
            }
            $byNoBooking[] = $temp;
        }

        $byCli = [];
        foreach($byCliTemp as $key => $value)
        {
            $byCli[] = ['code' => $key, 'title' => $value['libcli'], 'qty' => $value['qty']];
        }

        return ['bycli' => $byCli, 'bystep' => $byStep, 'bynobooking' => $byNoBooking];
    }

    public function validationDemandeBooking(Request $request, DemandeBooking $demandeBooking)
    {
        $demandeBooking->update($request->only('si_valider'));
        if($request->si_valider == 1)
        {
            $demandeBooking->bookingtc->update($request->only('nb_tcs_def'));

            if($demandeBooking->type_demande)
            {
                // Read File
                $jsonString = file_get_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.json'));

                $pdf = PDF::loadView('documents.export.demande-booking', [ 'data' => ['dmd' => $demandeBooking, 'req' => json_decode($jsonString)] ]);
                $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'booking/'.$demandeBooking->no_booking.'.pdf') );

                Mail::send(new NouvelleDemandeBooking($demandeBooking));
            }
            else
            {
                // Read File
                $jsonString = file_get_contents(base_path('storage/app/public/fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/'.$demandeBooking->no_booking.'.json'));
                $json = json_decode($jsonString);

                // Create ESCALE
                $navire = Navire::updateOrCreate(
                    ['libnavire' => mb_strtoupper($json->navire)],
                    ['codenavire' => substr($json->noescale,0,6),'typenavire' => 'RE']
                );
                $escale = Escale::updateOrCreate(
                    ['noescale' => $json->noescale, 'codenavire' => $navire->codenavire],
                    ['etad' => $json->eta]
                );
                $demandeBooking->update(['noescale' => $escale->noescale]);

                $pdf = PDF::loadView('documents.export.demande-booking-tp', [ 'data' => ['dmd' => $demandeBooking, 'req' => $json] ]);
                $pdf->save( Storage::disk('public')->path('fichiers/export/'.substr($demandeBooking->date_demande,0,4).'/'.substr($demandeBooking->date_demande,5,2).'/'.'bookingtp/EOL-'.$demandeBooking->no_booking.'.pdf') );

                Mail::send(new NouvelleDemandeBookingTp($demandeBooking));
            }
        }

        return response()->json($demandeBooking, 200);
    }

    public function recapDemandeBookings(Request $request /*$year = date('Y')*/)
    {
        $year = Is_Numeric($request->year) && $request->year >= 2019 ? $request->year : date('Y');
        $reqAttente = DemandeBooking::where('si_valider','-1')->whereYear('date_demande','=',$year);
        $reqRejet = DemandeBooking::where('si_valider','0')->whereYear('date_demande','=',$year);
        $reqCurr = DemandeBooking::doesntHave('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year);
        $reqReal = DemandeBooking::has('bookingtcfinal')->where('si_valider','1')->whereYear('date_demande','=',$year);
        $reqDmdBks = DemandeBooking::with([
            'client',
            'bookingtc.attributiontcs.positionnementtc.finposit', 
            'bookingtc.attributiontcs.positionnementtc.empotagetc', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.finretour', 
            'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc.embarquementtc', 
            'bookingtc.attributiontcs.positionnementtc.retourtc.embarquementtc'
        ])->where('si_valider','1')->whereYear('date_demande','=',$year);
        
        if(!\Auth::user()->isUsername()) {
            $reqAttente->where('ct_num',\Auth::user()->ct_num);
            $reqRejet->where('ct_num',\Auth::user()->ct_num);
            $reqCurr->where('ct_num',\Auth::user()->ct_num);
            $reqReal->where('ct_num',\Auth::user()->ct_num);
            $reqDmdBks->where('ct_num',\Auth::user()->ct_num);
        }
        
        $currDmd = $reqCurr->pluck('iddemande_booking')->toArray();
        $recapDmd = [
            ['code' => 'dbrjet','title' => 'Bookings rejétés', 'qty' => $reqRejet->count()],
            ['code' => 'dbcurr','title' => 'Bookings en cours', 'qty' => sizeof($currDmd)],
            ['code' => 'dbreal','title' => 'Bookings realisés', 'qty' => $reqReal->count()],
        ];

        $currDmdBks = $reqDmdBks/*->whereIn('iddemande_booking', $currDmd)*/->get();
        $data = $this->countTcFromDmd($currDmdBks);

        $data['dmd'] = $recapDmd;

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function showAttributions(DemandeBooking $demandeBooking)
    {
        $demandeBooking = DemandeBooking::with([
            'produitdmd',
            'bookingtc.paramtcreefer',
            'bookingtc.attributiontcs.attributionclipon.approcarburant',
            'bookingtc.attributiontcs.positionnementtc',
        ])->find($demandeBooking->iddemande_booking);

        $demandeBooking->date_demande = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->date_demande)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->bookingtc->date_posit_souhait = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->bookingtc->date_posit_souhait)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($demandeBooking, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking\DemandeBooking  $demandeBooking
     * @return \Illuminate\Http\Response
     */
    public function showPositionnements(DemandeBooking $demandeBooking)
    {
        if($demandeBooking->si_transporteur_eolis == 1) 
        {
            $demandeBooking->load([
                'bookingtc.attributiontcs.positionnementtc.portdep', 
                'bookingtc.attributiontcs.positionnementtc.portarr', 
                'bookingtc.attributiontcs.positionnementtc.transporteur', 
                'bookingtc.attributiontcs.positionnementtc.chauffeur', 
                'bookingtc.attributiontcs.positionnementtc.camion', 
                'bookingtc.attributiontcs.positionnementtc.remorque', 
                'bookingtc.attributiontcs.positionnementtc.finposit.finpositcliponverif', 
                'bookingtc.attributiontcs.positionnementtc.empotagetc', 
            ]);

            $demandeBooking->bookingtc->attributiontcs->each(function($attributiontc,$key){
                if( $attributiontc->positionnementtc &&  $attributiontc->positionnementtc->finposit ) {
                    $attributiontc->positionnementtc->finposit->dateh_arrive = Carbon::createFromFormat('Y-m-d H:i:s', $attributiontc->positionnementtc->finposit->dateh_arrive)->format('Y-m-d\TH:i:s.u\Z');
                }
                return $attributiontc;
            });
        }
        else
        {
            $demandeBooking->load([
                'bookingtc.attributiontcs.positionnementtcpropremoyen.retourtc', 
            ]);
        }

        $demandeBooking->date_demande = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->date_demande)->format('Y-m-d\TH:i:s.u\Z');
        $demandeBooking->bookingtc->date_posit_souhait = Carbon::createFromFormat('Y-m-d H:i:s', $demandeBooking->bookingtc->date_posit_souhait)->format('Y-m-d\TH:i:s.u\Z');

        return response()->json($demandeBooking, 200);
    }

}
