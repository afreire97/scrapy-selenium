<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */



    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Registrar los escuchadores de eventos
        Event::listen(
            \App\Events\RunPythonScriptJobStarted::class,
            \App\Listeners\SendRunPythonScriptJobMessage::class
        );

        Event::listen(
            \App\Events\RunPythonScriptJobFinished::class,
            \App\Listeners\SendRunPythonScriptJobMessage::class
        );
    }
}
