<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Archives\Document::class => \App\Policies\Archives\DocumentPolicy::class,
        \App\Models\Archives\Dossarchive::class => \App\Policies\Archives\DossarchivePolicy::class,

        \App\Models\Compta\F_Comptet::class => \App\Policies\Compta\F_ComptetPolicy::class,

        \App\Models\Engins\ApproCarburant::class => \App\Policies\Engins\ApproCarburantPolicy::class,

        \App\Models\Export\AttributionClipon::class => \App\Policies\Export\AttributionCliponPolicy::class,
        \App\Models\Export\AttributionCliponRetour::class => \App\Policies\Export\AttributionCliponRetourPolicy::class,
        \App\Models\Export\AttributionCliponRetourVerif::class => \App\Policies\Export\AttributionCliponRetourVerifPolicy::class,
        \App\Models\Export\AttributionCliponVerif::class => \App\Policies\Export\AttributionCliponVerifPolicy::class,
        \App\Models\Export\AttributionTc::class => \App\Policies\Export\AttributionTcPolicy::class,
        \App\Models\Export\BookingTc::class => \App\Policies\Export\BookingTcPolicy::class,
        \App\Models\Export\BookingTcFinal::class => \App\Policies\Export\BookingTcFinalPolicy::class,
        \App\Models\Export\DemandeBooking::class => \App\Policies\Export\DemandeBookingPolicy::class,
        \App\Models\Export\EmbarquementTc::class => \App\Policies\Export\EmbarquementTcPolicy::class,
        \App\Models\Export\EmpotageTcPosit::class => \App\Policies\Export\EmpotageTcPositPolicy::class,
        \App\Models\Export\FinPositTc::class => \App\Policies\Export\FinPositTcPolicy::class,
        \App\Models\Export\FinRetourTc::class => \App\Policies\Export\FinRetourTcPolicy::class,
        \App\Models\Export\Incident::class => \App\Policies\Export\IncidentPolicy::class,
        \App\Models\Export\MotifRefusBooking::class => \App\Policies\Export\MotifRefusBookingPolicy::class,
        \App\Models\Export\ParamTcReefer::class => \App\Policies\Export\ParamTcReeferPolicy::class,
        \App\Models\Export\PositionnementTc::class => \App\Policies\Export\PositionnementTcPolicy::class,
        \App\Models\Export\RetourTc::class => \App\Policies\Export\RetourTcPolicy::class,
        
        \App\Models\Fichiers\Activites::class => \App\Policies\Fichiers\ActivitesPolicy::class,
        \App\Models\Fichiers\Chauffeur::class => \App\Policies\Fichiers\ChauffeurPolicy::class,
        \App\Models\Fichiers\EtapeSuiviBooking::class => \App\Policies\Fichiers\EtapeSuiviBookingPolicy::class,
        \App\Models\Fichiers\LieuAppro::class => \App\Policies\Fichiers\LieuApproPolicy::class,
        \App\Models\Fichiers\Panne::class => \App\Policies\Fichiers\PannePolicy::class,
        \App\Models\Fichiers\RLieu::class => \App\Policies\Fichiers\RLieuPolicy::class,
        \App\Models\Fichiers\StationEmpotage::class => \App\Policies\Fichiers\StationEmpotagePolicy::class,
        \App\Models\Fichiers\Transporteur::class => \App\Policies\Fichiers\TransporteurPolicy::class,
        \App\Models\Fichiers\TypeIncident::class => \App\Policies\Fichiers\TypeIncidentPolicy::class,

        \App\Models\Old\Eolis\A_Etatcs::class => \App\Policies\Old\Eolis\A_EtatcsPolicy::class,
        \App\Models\Old\Eolis\A_Tcsemb::class => \App\Policies\Export\A_TcsembPolicy::class,
        \App\Models\Old\Eolis\A_Tcsdeb::class => \App\Policies\Export\A_TcsdebPolicy::class,
        \App\Models\Old\Eolis\Client::class => \App\Policies\Old\Eolis\ClientPolicy::class,
        \App\Models\Old\Eolis\Compte_Tiers::class => \App\Policies\Old\Eolis\CompteTierPolicy::class,
        \App\Models\Old\Eolis\Facentet::class => \App\Policies\Old\Eolis\FacentetPolicy::class,
        \App\Models\Old\Eolis\Facture::class => \App\Policies\Old\Eolis\FacturePolicy::class,
        \App\Models\Old\Eolis\Veiw_Facture::class => \App\Policies\Old\Eolis\ViewFacturePolicy::class,
        \App\Models\Old\Eolis\Escale::class => \App\Policies\Old\Eolis\EscalePolicy::class,
        \App\Models\Old\Eolis\Navire::class => \App\Policies\Old\Eolis\NavirePolicy::class,
        \App\Models\Old\Eolis\Operateu::class => \App\Policies\Old\Eolis\OperateuPolicy::class,
        \App\Models\Old\Eolis\Port::class => \App\Policies\Old\Eolis\PortPolicy::class,
        \App\Models\Old\Eolis\Prestation_Conteneur_Dispo::class => \App\Policies\Old\Eolis\Prestation_Conteneur_DispoPolicy::class,
        \App\Models\Old\Eolis\Prestation_lavage_Conteneur::class => \App\Policies\Old\Eolis\Prestation_lavage_ConteneurPolicy::class,
        \App\Models\Old\Eolis\Prestation_Pti_Conteneur::class => \App\Policies\Old\Eolis\Prestation_Pti_ConteneurPolicy::class,
        \App\Models\Old\Eolis\Produit::class => \App\Policies\Old\Eolis\ProduitPolicy::class,
        \App\Models\Old\Eolis\Reglement_Achat::class => \App\Policies\Old\Eolis\ReglementAchatPolicy::class,
        \App\Models\Old\Eolis\TcsBase::class => \App\Policies\Old\Eolis\TcsBasePolicy::class,
        \App\Models\Old\Eolis\Username::class => \App\Policies\Old\Eolis\UsernamePolicy::class,

        \App\Models\Old\Parc\Batterie::class => \App\Policies\Old\Parc\BatteriePolicy::class,
        \App\Models\Old\Parc\BatterieEtat::class => \App\Policies\Old\Parc\BatterieEtatPolicy::class,
        \App\Models\Old\Parc\BatterieType::class => \App\Policies\Old\Parc\BatterieTypePolicy::class,
        \App\Models\Old\Parc\Engin::class => \App\Policies\Old\Parc\EnginPolicy::class,
        \App\Models\Old\Parc\LigneSortie::class => \App\Policies\Old\Parc\LigneSortiePolicy::class,
        \App\Models\Old\Parc\OT::class => \App\Policies\Old\Parc\OTPolicy::class,
        \App\Models\Old\Parc\OuvertureStation::class => \App\Policies\Old\Parc\OuvertureStationPolicy::class,
        \App\Models\Old\Parc\Prise::class => \App\Policies\Old\Parc\PrisePolicy::class,
        \App\Models\Old\Parc\ReptcAction::class => \App\Policies\Old\Parc\ReptcActionPolicy::class,
        \App\Models\Old\Parc\Reptc::class => \App\Policies\Old\Parc\ReptcPolicy::class,
        \App\Models\Old\Parc\ReptcSide::class => \App\Policies\Old\Parc\ReptcSidePolicy::class,
        \App\Models\Old\Parc\Sortie::class => \App\Policies\Old\Parc\SortiePolicy::class,
        \App\Models\Old\Parc\Typengin::class => \App\Policies\Old\Parc\TypenginPolicy::class,

        \Spatie\Permission\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \Spatie\Permission\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(7));
        Passport::personalAccessTokensExpireIn(now()->addDays(365));
    }
}
