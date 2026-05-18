<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\Archives\DocumentController;
use App\Http\Controllers\Archives\DossarchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Compta\F_ComptetController;
use App\Http\Controllers\Engins\ApproCarburantController;
use App\Http\Controllers\Engins\ControleGensetController;

use App\Http\Controllers\Export\AttributionCliponController;
use App\Http\Controllers\Export\AttributionCliponRetourController;
use App\Http\Controllers\Export\AttributionCliponRetourVerifController;
use App\Http\Controllers\Export\AttributionCliponVerifController;
use App\Http\Controllers\Export\AttributionTcController;
use App\Http\Controllers\Export\BookingTcController;
use App\Http\Controllers\Export\BookingTcFinalController;
use App\Http\Controllers\Export\DemandeBookingController;
use App\Http\Controllers\Export\EmbarquementTcController;
use App\Http\Controllers\Export\EmpotageTcPositController;
use App\Http\Controllers\Export\FinPositTcController;
use App\Http\Controllers\Export\FinRetourTcController;
use App\Http\Controllers\Export\IncidentController;
use App\Http\Controllers\Export\MotifRefusBookingController;
use App\Http\Controllers\Export\ParamTcReeferController;
use App\Http\Controllers\Export\PositionnementTcController;
use App\Http\Controllers\Export\RetourTcController;

use App\Http\Controllers\Fichiers\ActivitesController;
use App\Http\Controllers\Fichiers\ApkController;
use App\Http\Controllers\Fichiers\ChauffeurController;
use App\Http\Controllers\Fichiers\EtapeSuiviBookingController;
use App\Http\Controllers\Fichiers\LieuApproController;
use App\Http\Controllers\Fichiers\PanneController;
use App\Http\Controllers\Fichiers\RLieuController;
use App\Http\Controllers\Fichiers\StationEmpotageController;
use App\Http\Controllers\Fichiers\TransporteurController;
use App\Http\Controllers\Fichiers\TypeIncidentController;
use App\Http\Controllers\Old\Acconage\BranchementController;
use App\Http\Controllers\Old\Acconage\CompteurController;
use App\Http\Controllers\Old\Acconage\CompteurEauController;
use App\Http\Controllers\Old\Acconage\EmplacementConteneurController;
use App\Http\Controllers\Old\Acconage\Mod_DockerController;
use App\Http\Controllers\Old\Acconage\ReleveIndexCompteurController;
use App\Http\Controllers\Old\Acconage\ReleveIndexEauController;
use App\Http\Controllers\Old\Acconage\ReleveShiftController;
use App\Http\Controllers\Old\Acconage\ReleveTemperatureReeferController;
use App\Http\Controllers\Old\Acconage\StatutTcController;
use App\Http\Controllers\Old\Acconage\TrafficController;
use App\Http\Controllers\Old\Acconage\T_SiteController;
use App\Http\Controllers\Old\Eolis\A_EtatcsController;
use App\Http\Controllers\Old\Eolis\A_TcsdebController;
use App\Http\Controllers\Old\Eolis\A_TcsembController;
use App\Http\Controllers\Old\Eolis\ClientController;
//use App\Http\Controllers\Old\Eolis\ClientController;
use App\Http\Controllers\Old\Eolis\EscaleController;
use App\Http\Controllers\Old\Eolis\FacentetController;
use App\Http\Controllers\Old\Eolis\NavireController;
use App\Http\Controllers\Old\Eolis\OperateuController;
use App\Http\Controllers\Old\Eolis\PortController;
use App\Http\Controllers\Old\Eolis\ProduitController;
use App\Http\Controllers\Old\Eolis\PrestationConteneurDispoController;
use App\Http\Controllers\Old\Eolis\PrestationLavageController;
use App\Http\Controllers\Old\Eolis\PrestationPtiController;
use App\Http\Controllers\Old\Eolis\ReglementAchatController;
use App\Http\Controllers\Old\Eolis\TcsBaseController;
use App\Http\Controllers\Old\Eolis\UsernameController;
use App\Http\Controllers\Old\Etf\EnginController as EtfEnginController;
use App\Http\Controllers\Old\Etf\SuiviKmController;
use App\Http\Controllers\Old\Parc\BatterieController;
use App\Http\Controllers\Old\Parc\BatterieEtatController;
use App\Http\Controllers\Old\Parc\BatterieTypeController;
use App\Http\Controllers\Old\Parc\ChargeurController;
use App\Http\Controllers\Old\Parc\EnginController;
use App\Http\Controllers\Old\Parc\LigneSortieController;
use App\Http\Controllers\Old\Parc\OIController;
use App\Http\Controllers\Old\Parc\OTController;
use App\Http\Controllers\Old\Parc\OuvertureStationController;
use App\Http\Controllers\Old\Parc\PriseController;
use App\Http\Controllers\Old\Parc\SignalPanneController;
use App\Http\Controllers\Old\Parc\SortieController;
use App\Http\Controllers\Old\Parc\TypenginController;
use App\Http\Controllers\Old\Parc\PieceController;
use App\Http\Controllers\Old\Parc\DistributeurController;
use App\Http\Controllers\Old\Parc\StationController;
use App\Http\Controllers\Old\Parc\StockageController;

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Syntheses\CarburantController;
use App\Http\Controllers\Syntheses\ExportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function () {
    Route::post('login/{type}', [AuthController::class, 'login']);

    Route::group(['middleware' =>  ['auth:api']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });
});


Route::group(['prefix' => 'apk'], function () {
    Route::get('check', [ApkController::class, 'check']);
    Route::get('download', [ApkController::class, 'download']);
});


Route::middleware('auth:api')->group(function() {
    Route::get('/alert/booking', [AlertController::class, 'booking']);

    Route::prefix('fichiers')->group(function() {
        Route::get('/activites/paginate', [ActivitesController::class, 'paginate']);
        Route::get('/chauffeur/paginate', [ChauffeurController::class, 'paginate']);
        Route::get('/etape-suivi-booking/paginate', [EtapeSuiviBookingController::class, 'paginate']);
        Route::get('/lieu-appro/paginate', [LieuApproController::class, 'paginate']);
        Route::get('/panne/paginate', [PanneController::class, 'paginate']);
        Route::get('/permission/paginate', [PermissionController::class, 'paginate']);
        Route::get('/r-lieu/paginate', [RLieuController::class, 'paginate']);
        Route::get('/role/paginate', [RoleController::class, 'paginate']);
        Route::get('/station-empotage/paginate', [StationEmpotageController::class, 'paginate']);
        Route::get('/transporteur/paginate', [TransporteurController::class, 'paginate']);
        Route::get('/type-incident/paginate', [TypeIncidentController::class, 'paginate']);
        Route::get('/user/paginate', [UserController::class, 'paginate']);

        Route::get('/chauffeur/filter', [ChauffeurController::class, 'filter']);
        Route::get('/lieu-appro/filter', [LieuApproController::class, 'filter']);
        Route::get('/panne/filter', [PanneController::class, 'filter']);
        Route::get('/r-lieu/filter', [RLieuController::class, 'filter']);
        Route::get('/transporteur/filter', [TransporteurController::class, 'filter']);
        Route::get('/type-incident/filter', [TypeIncidentController::class, 'filter']);

        Route::put('/user/{user}/state', [UserController::class, 'setUserState']);
        Route::post('/user/reset-pwd/{user}', [UserController::class, 'resetPassword']);
        Route::post('/user/reset-self-pwd', [UserController::class, 'resetSelfPassword']);

        Route::resource('/activites', ActivitesController::class);
        Route::resource('/apk', ApkController::class);
        Route::resource('/chauffeur', ChauffeurController::class);
        Route::resource('/etape-suivi-booking', EtapeSuiviBookingController::class);
        Route::resource('/lieu-appro', LieuApproController::class);
        Route::resource('/panne', PanneController::class);
        Route::resource('/permission', PermissionController::class);
        Route::resource('/r-lieu', RLieuController::class);
        Route::resource('/role', RoleController::class);
        Route::resource('/station-empotage', StationEmpotageController::class);
        Route::resource('/transporteur', TransporteurController::class);
        Route::resource('/type-incident', TypeIncidentController::class);
        Route::resource('/user', UserController::class);
    });

    Route::prefix('engins')->group(function() {
        Route::get('/appro-carburant/paginate', [ApproCarburantController::class, 'paginate']);

        Route::get('/appro-carburant/filter', [ApproCarburantController::class, 'filter']);

        Route::get('/controle-genset/paginate', [ControleGensetController::class, 'paginate']);
        Route::post('/controle-genset/depart/{attributionClipon}', [ControleGensetController::class, 'storeDepart']);
        Route::put('/controle-genset/depart/{attributionCliponVerif}', [ControleGensetController::class, 'updateDepart']);
        Route::delete('/controle-genset/depart/{attributionCliponVerif}', [ControleGensetController::class, 'destroyDepart']);
        Route::get('/controle-genset/depart/{attributionCliponVerif}', [ControleGensetController::class, 'showDepart']);

        Route::post('/controle-genset/fin-retour/{attributionCliponRetour}', [ControleGensetController::class, 'storeFinRetour']);
        Route::put('/controle-genset/fin-retour/{finRetourCliponVerif}', [ControleGensetController::class, 'updateFInRetour']);
        Route::delete('/controle-genset/fin-retour/{finRetourCliponVerif}', [ControleGensetController::class, 'destroyFinRetour']);
        Route::get('/controle-genset/fin-retour/{finRetourCliponVerif}', [ControleGensetController::class, 'showFInRetour']);

        Route::resource('/appro-carburant', ApproCarburantController::class);
    });

    Route::prefix('export')->group(function() {
        Route::put('/demande-booking/validation/{demandeBooking}', [DemandeBookingController::class, 'validationDemandeBooking']);

        Route::get('/demande-booking/{no_booking}/byno', [DemandeBookingController::class, 'showByNoBooking']);
        Route::get('/demande-booking/attribution/{demandeBooking}', [DemandeBookingController::class, 'showAttributions']);
        Route::get('/demande-booking/filter', [DemandeBookingController::class, 'filter']);
        Route::get('/demande-booking/positionnement/{demandeBooking}', [DemandeBookingController::class, 'showPositionnements']);
        Route::get('/demande-booking/recap/demande-booking', [DemandeBookingController::class, 'recapDemandeBookings']);
        Route::get('/demande-booking/recap/etapes-par-demande-booking', [DemandeBookingController::class, 'recapEtapesDemandeBookings']);

        Route::get('/attribution-clipon/paginate', [AttributionCliponController::class, 'paginate']);
        Route::get('/attribution-clipon-retour/paginate', [AttributionCliponRetourController::class, 'paginate']);
        Route::get('/attribution-clipon-retour-verif/paginate', [AttributionCliponRetourVerifController::class, 'paginate']);
        Route::get('/attribution-clipon-verif/paginate', [AttributionCliponVerifController::class, 'paginate']);
        Route::get('/attribution-tc/paginate', [AttributionTcController::class, 'paginate']);
        Route::post('/attribution-tc/reattrib', [AttributionTcController::class, 'reAttributionTc']);
        Route::get('/booking-tc/paginate', [BookingTcController::class, 'paginate']);
        Route::get('/booking-tc-final/paginate', [BookingTcFinalController::class, 'paginate']);
        Route::get('/demande-booking/paginate', [DemandeBookingController::class, 'paginate']);
        Route::get('/embarquement-tc/paginate', [EmbarquementTcController::class, 'paginate']);
        Route::get('/empotage-tc-posit/paginate', [EmpotageTcPositController::class, 'paginate']);
        Route::put('/empotage-tc-posit/datehfin/{empotage_tc_posit}', [EmpotageTcPositController::class, 'setDatehFinEmpotage']);
        Route::get('/fin-posit-tc/paginate', [FinPositTcController::class, 'paginate']);
        Route::get('/fin-retour-tc/paginate', [FinRetourTcController::class, 'paginate']);
        Route::get('/incident/paginate', [IncidentController::class, 'paginate']);
        Route::get('/motif-refus-booking/paginate', [MotifRefusBookingController::class, 'paginate']);
        Route::get('/param-tc-reefer/paginate', [ParamTcReeferController::class, 'paginate']);
        Route::get('/positionnement-tc/paginate', [PositionnementTcController::class, 'paginate']);
        Route::get('/retour-tc/paginate', [RetourTcController::class, 'paginate']);

        Route::post('/positionnement-tc-propre-moyen', [PositionnementTcController::class, 'storePropreMoyen']);
        Route::put('/positionnement-tc-propre-moyen/{positionnementTcPropreMoyen}', [PositionnementTcController::class, 'updatePropreMoyen']);
        Route::delete('/positionnement-tc-propre-moyen/{positionnementTcPropreMoyen}', [PositionnementTcController::class, 'destroyPropreMoyen']);
        Route::get('/positionnement-tc-propre-moyen/{positionnementTcPropreMoyen}', [PositionnementTcController::class, 'showPropreMoyen']);

        Route::post('/retour-tc-propre-moyen', [RetourTcController::class, 'storePropreMoyen']);
        Route::put('/retour-tc-propre-moyen/{retourTcPropreMoyen}', [RetourTcController::class, 'updatePropreMoyen']);
        Route::delete('/retour-tc-propre-moyen/{retourTcPropreMoyen}', [RetourTcController::class, 'destroyPropreMoyen']);
        Route::get('/retour-tc-propre-moyen/{retourTcPropreMoyen}', [RetourTcController::class, 'showPropreMoyen']);


        Route::post('/embarquement-tc/many', [EmbarquementTcController::class, 'storeMany']);


        Route::resource('/attribution-clipon', AttributionCliponController::class);
        Route::resource('/attribution-clipon-retour', AttributionCliponRetourController::class);
        Route::resource('/attribution-tc', AttributionTcController::class);
        Route::resource('/booking-tc', BookingTcController::class);
        Route::resource('/booking-tc-final', BookingTcFinalController::class);
        Route::resource('/demande-booking', DemandeBookingController::class);
        Route::resource('/embarquement-tc', EmbarquementTcController::class);
        Route::resource('/empotage-tc-posit', EmpotageTcPositController::class);
        Route::resource('/fin-posit-tc', FinPositTcController::class);
        Route::resource('/fin-retour-tc', FinRetourTcController::class);
        Route::resource('/incident', IncidentController::class);
        Route::resource('/motif-refus-booking', MotifRefusBookingController::class);
        Route::resource('/param-tc-reefer', ParamTcReeferController::class);
        Route::resource('/positionnement-tc', PositionnementTcController::class);
        Route::resource('/retour-tc', RetourTcController::class);
    });

    Route::prefix('compta')->group(function() {
        Route::get('/tiers/paginate', [F_ComptetController::class, 'paginate']);
        Route::get('/tiers/filter', [F_ComptetController::class, 'filter']);

        Route::resource('/tiers', F_ComptetController::class);
    });

    Route::prefix('acconage')->group(function() {
        Route::get('/branchement/paginate', [BranchementController::class, 'paginate']);
        Route::get('/branchement/filter', [BranchementController::class, 'filter']);
        Route::post('/branchement/fin/{branchement}', [BranchementController::class, 'debranch']);

        Route::get('/compteur/filter', [CompteurController::class, 'filter']);

        Route::get('/compteur-eau/filter', [CompteurEauController::class, 'filter']);

        Route::get('/emplacement_tc/filter', [EmplacementConteneurController::class, 'filter']);
        Route::get('/emplacement_tc/countallsite', [EmplacementConteneurController::class, 'countAllSites']);
        Route::get('/emplacement_tc/{id_site}', [EmplacementConteneurController::class, 'getTcBySite']);

        Route::get('/mod-docker/paginate', [Mod_DockerController::class, 'paginate']);
        Route::get('/mod-docker/filter', [Mod_DockerController::class, 'filter']);

        Route::get('/releve-index-compteur/paginate', [ReleveIndexCompteurController::class, 'paginate']);
        Route::get('/releve-index-compteur/filter', [ReleveIndexCompteurController::class, 'filter']);

        Route::get('/releve-index-eau/paginate', [ReleveIndexEauController::class, 'paginate']);
        Route::get('/releve-index-eau/filter', [ReleveIndexEauController::class, 'filter']);

        Route::get('/releve-shift/paginate', [ReleveShiftController::class, 'paginate']);
        Route::get('/releve-shift/filter', [ReleveShiftController::class, 'filter']);

        Route::get('/releve-temperature-reefer/paginate', [ReleveTemperatureReeferController::class, 'paginate']);
        Route::get('/releve-temperature-reefer/filter', [ReleveTemperatureReeferController::class, 'filter']);

        Route::get('/t_site/filter', [T_SiteController::class, 'filter']);

        Route::resource('/branchement', BranchementController::class);
        Route::resource('/compteur', CompteurController::class);
        Route::resource('/compteur-eau', CompteurEauController::class);
         Route::resource('/emplacement_tc', EmplacementConteneurController::class);
        Route::resource('/mod-docker', Mod_DockerController::class);
        Route::resource('/releve-index-compteur', ReleveIndexCompteurController::class);
        Route::resource('/releve-index-eau', ReleveIndexEauController::class);
        Route::resource('/releve-shift', ReleveShiftController::class);
        Route::resource('/releve-temperature-reefer', ReleveTemperatureReeferController::class);
        Route::resource('/statut-tc', StatutTcController::class);
        Route::resource('/traffic', TrafficController::class);
        Route::resource('/t_site', T_SiteController::class);
    });

    Route::prefix('archive')->group(function() {
        Route::get('/document/file/{id}', [DocumentController::class, 'file']);
        Route::get('/dossarchive/paginate', [DossarchiveController::class, 'paginate']);
        Route::get('/dossarchive/{dossarchive}', [DossarchiveController::class, 'show']);
    });

    Route::prefix('eolis')->group(function() {
        Route::get('/a_etatcs/paginate', [A_EtatcsController::class, 'paginate']);
        Route::get('/a_etatcs/paginate-view', [A_EtatcsController::class, 'paginateView']);
        Route::get('/a_etatcs/index-view', [A_EtatcsController::class, 'indexView']);
        Route::get('/a_etatcs/branch/{id}', [A_EtatcsController::class, 'getDetailBranch']);
        Route::get('/a_etatcs/tcsdeb/{id}', [A_EtatcsController::class, 'getDetailTcDeb']);
        Route::get('/a_etatcs/tcsemb/{id}', [A_EtatcsController::class, 'getDetailTcEmb']);
        Route::get('/a_etatcs/deptcimp/{id}', [A_EtatcsController::class, 'getDetailDepTcImp']);
        Route::get('/a_etatcs/mvtcs/{id}', [A_EtatcsController::class, 'getDetailMvtTc']);

        Route::get('/a_etatcs/filter/nobl', [A_EtatcsController::class, 'filterNobl']);
        Route::get('/a_etatcs/filter/tc', [A_EtatcsController::class, 'filterTc']);
        Route::get('/a_etatcs/filter/escale', [A_EtatcsController::class, 'filterEscale']);


        Route::get('/client/paginate', [ClientController::class, 'paginate']);
        Route::get('/client/filter', [ClientController::class, 'filter']);

        Route::get('/escale/openav/{escale}', [EscaleController::class, 'operationNavire']);
        Route::get('/escale/paginate', [EscaleController::class, 'paginate']);
        Route::get('/escale/filter-escale', [EscaleController::class, 'filterEscale']);
        Route::get('/escale/filter-voyage', [EscaleController::class, 'filterVoyage']);
        Route::get('/escale/filter-listetc-a-debarque', [EscaleController::class, 'filterListeTcDebVoyage']);
        Route::get('/escale/liste-escale-a-debarquer', [EscaleController::class, 'ListeEscaleADebarquer']);
        Route::get('/escale/liste-escale-a-embarquer', [EscaleController::class, 'ListeEscaleAEmbarquer']);
        Route::get('/escale/filter-listetc-a-embarque', [EscaleController::class, 'filterListeTcEmbVoyage']);

        Route::get('/facentet/paginate', [FacentetController::class, 'paginate']);
        Route::get('/facentet/filter', [FacentetController::class, 'filter']);
        Route::get('/facentet/{view_Facentet}', [FacentetController::class, 'show']);
        Route::get('/facentet/export', [FacentetController::class, 'export']);

        Route::get('/operateu/paginate', [OperateuController::class, 'paginate']);
        Route::get('/operateu/filter', [OperateuController::class, 'filter']);

        Route::get('/mise-a-disposition/paginate', [PrestationConteneurDispoController::class, 'paginate']);
        Route::get('/mise-a-disposition/filter', [PrestationConteneurDispoController::class, 'filter']);
        Route::get('/mise-a-disposition/count', [PrestationConteneurDispoController::class, 'count']);

        Route::get('/port/paginate', [PortController::class, 'paginate']);
        Route::get('/port/filter', [PortController::class, 'filter']);

        Route::get('/prestation-lavage-conteneur/paginate', [PrestationLavageController::class, 'paginate']);
        Route::get('/prestation-lavage-conteneur/filter', [PrestationLavageController::class, 'filter']);
        Route::get('/prestation-lavage-conteneur/last/{no_tc}', [PrestationLavageController::class, 'getLastLavageByTc']);
        Route::get('/prestation-pti-conteneur/paginate', [PrestationPtiController::class, 'paginate']);
        Route::get('/prestation-pti-conteneur/filter', [PrestationPtiController::class, 'filter']);
        Route::get('/prestation-pti-conteneur/last/{no_tc}', [PrestationPtiController::class, 'getLastPtiByTc']);

        Route::get('/produit/paginate', [ProduitController::class, 'paginate']);
        Route::get('/produit/filter', [ProduitController::class, 'filter']);

        Route::get('/reglement-achat/paginate', [ReglementAchatController::class, 'paginate']);
        Route::get('/reglement-achat/filter', [ReglementAchatController::class, 'filter']);
        Route::get('/reglement-achat/{reglement_Achat}', [ReglementAchatController::class, 'show']);

        Route::get('/tcs-base/paginate', [TcsBaseController::class, 'paginate']);
        Route::get('/tcs-base/filter', [TcsBaseController::class, 'filter']);

        Route::resource('/a_etatcs', A_EtatcsController::class);
        Route::resource('/a_tcsdeb', A_TcsdebController::class);
        Route::resource('/a_tcsemb', A_TcsembController::class);
        Route::resource('/escale', EscaleController::class);
        Route::resource('/navire', NavireController::class);
        Route::resource('/operateu', OperateuController::class);
        Route::resource('/mise-a-disposition', PrestationConteneurDispoController::class);
        Route::resource('/prestation-lavage-conteneur', PrestationLavageController::class);
        Route::resource('/prestation-pti-conteneur', PrestationPtiController::class);
        Route::resource('/port', PortController::class);
        Route::resource('/produit', ProduitController::class);
        Route::resource('/tcs-base', TcsBaseController::class);
        Route::resource('/username', UsernameController::class);
    });

    Route::prefix('etf')->group(function() {
        Route::post('/engin/qrcode', [EtfEnginController::class, 'generateEnginQrCodes']);
        Route::post('/engin/qrcode/{engin}', [EtfEnginController::class, 'generateEnginQrCode']);

        Route::get('/engin/paginate', [EtfEnginController::class, 'paginate']);
        Route::get('/engin/filter', [EtfEnginController::class, 'filter']);

        Route::get('/suivi-km/paginate', [SuiviKmController::class, 'paginate']);

        Route::resource('/engin', EtfEnginController::class);
        Route::resource('/suivi-km', SuiviKmController::class);
    });

     Route::prefix('parc')->group(function() {
        Route::get('/batterie/code/{code}', [BatterieController::class, 'showByCode']);
        Route::get('/batterie/sdc', [BatterieController::class, 'statBatterieSDC']);
        Route::get('/batterie/paginate', [BatterieController::class, 'paginate']);
        Route::get('/batterie/export-data', [BatterieController::class, 'exportData']);
        Route::post('/batterie/upload', [BatterieController::class, 'storeWithPhoto']);
        Route::post('/batterie/upload/{batterie}', [BatterieController::class, 'updateWithPhoto']);
        Route::get('/batterie/attribution', [BatterieController::class, 'getAttribution']);
        Route::get('/batterie/attribution/paginate', [BatterieController::class, 'paginateAttribution']);
        Route::post('/batterie/attribution', [BatterieController::class, 'storeBatterieAttribution']);
        Route::post('/batterie/attribution/wt/{batterie_Engin}/start', [BatterieController::class, 'startBatterieWorkingTime']);
        Route::post('/batterie/attribution/wt/{batterie_Engin}/stop', [BatterieController::class, 'stopBatterieWorkingTime']);
        Route::post('/batterie/attribution/{batterie}', [BatterieController::class, 'updateBatterieAttribution']);
        Route::post('/batterie/charge', [BatterieController::class, 'storeBatterieCharge']);
        Route::post('/batterie/charge/{batterie}', [BatterieController::class, 'updateBatterieCharge']);
        Route::post('/batterie/reception', [BatterieController::class, 'storeBatterieReception']);
        Route::post('/batterie/reception/{batterie}', [BatterieController::class, 'updateBatterieReception']);
        Route::post('/batterie/qrcode', [BatterieController::class, 'generateBatterieQrCodes']);
        Route::post('/batterie/qrcode/{batterie}', [BatterieController::class, 'generateBatterieQrCode']);

        Route::get('/chargeur/paginate', [ChargeurController::class, 'paginate']);
        Route::get('/chargeur/filter', [ChargeurController::class, 'filter']);
        Route::post('/chargeur/qrcode', [ChargeurController::class, 'generateChargeurQrCodes']);
        Route::post('/chargeur/qrcode/{chargeur}', [ChargeurController::class, 'generateChargeurQrCode']);
        Route::resource('/distributeurs', DistributeurController::class);
        Route::get('/engin/paginate', [EnginController::class, 'paginate']);
        Route::get('/engin/filter', [EnginController::class, 'filter']);
        Route::post('/engin/qrcode', [EnginController::class, 'generateEnginQrCodes']);
        Route::post('/engin/qrcode/{engin}', [EnginController::class, 'generateEnginQrCode']);
        Route::get('/oi/paginate', [OIController::class, 'paginate']);
        Route::get('/oi/filter', [OIController::class, 'filter']);

        Route::get('/prise/paginate', [PriseController::class, 'paginate']);
        Route::post('/prise/qrcode', [PriseController::class, 'generatePriseQrCodes']);
        Route::post('/prise/qrcode/{prise}', [PriseController::class, 'generatePriseQrCode']);

        Route::get('/signal-panne/paginate', [SignalPanneController::class, 'paginate']);
        Route::post('/signal-panne/upload', [SignalPanneController::class, 'storeWithVideo']);

        Route::get('/sortie/paginate', [SortieController::class, 'paginate']);
        Route::get('/sortie/filter', [SortieController::class, 'filter']);

        Route::get('/typengin/paginate', [TypenginController::class, 'paginate']);
        Route::get('/typengin/filter', [TypenginController::class, 'filter']);

        Route::resource('/batterie', BatterieController::class);
        Route::resource('/batterie-etat', BatterieEtatController::class);
        Route::resource('/batterie-type', BatterieTypeController::class);
        Route::resource('/chargeur', ChargeurController::class);
        Route::resource('/engin', EnginController::class);
        Route::resource('/ligne-sortie', LigneSortieController::class);
        Route::resource('/oi', OIController::class);
        Route::resource('/ot', OTController::class);
        Route::get('/ouverture-station/paginate', [OuvertureStationController::class, 'paginate']);
        Route::get('/ouverture-station/filter', [OuvertureStationController::class, 'filter']);
        Route::post('/ouverture-station/fin/{ouverturestation}', [OuvertureStationController::class, 'finouverture']);
        Route::get('/ouverture-station/check-ouverture-encour/{stationid}', [OuvertureStationController::class, 'checkouvertureencour']);
         Route::resource('/ouverture-station', OuvertureStationController::class);
        Route::resource('piece', PieceController::class);
        Route::resource('/prise', PriseController::class);
        Route::resource('/signal-panne', SignalPanneController::class);
        Route::resource('/sortie', SortieController::class);
        Route::get('/station-approvisionnement/filter', [StationController::class, 'filter']);
        Route::resource('/station-approvisionnement', StationController::class);
        Route::get('/stockage/filter', [StockageController::class, 'filter']);
        Route::resource('/typengin', TypenginController::class);       
     });

    Route::prefix('syntheses')->group(function() {
        Route::get('/booking-tc/paginate', [ExportController::class, 'paginate']);
        Route::get('/booking-tc/details/escale/{escale}', [ExportController::class, 'detailsEmbarquementNavire']);

        Route::get('/carburant/recap/clipons', [CarburantController::class, 'recapConsoClipons']);
        Route::get('/carburant/recap/camions', [CarburantController::class, 'recapConsoCamions']);

        Route::get('/carburant/details/clipon/{idengin}', [CarburantController::class, 'detailsConsoClipon']);
        Route::get('/carburant/details/camion/{idengin}', [CarburantController::class, 'detailsConsoCamion']);
    });
});

