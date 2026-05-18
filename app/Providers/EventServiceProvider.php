<?php

namespace App\Providers;

use App\Models\Old\Parc\Batterie;
use App\Models\Old\Parc\Chargeur;
use App\Models\Old\Parc\Prise;
use App\Models\Old\Parc\SignalPanne;
use App\Observers\Old\Parc\BatterieObserver;
use App\Observers\Old\Parc\ChargeurObserver;
use App\Observers\Old\Parc\PriseObserver;
use App\Observers\Old\Parc\SignalPanneObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Batterie::observe(BatterieObserver::class);
        Chargeur::observe(ChargeurObserver::class);
        Prise::observe(PriseObserver::class);
        SignalPanne::observe(SignalPanneObserver::class);
        //
    }
}
