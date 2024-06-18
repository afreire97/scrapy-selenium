<?php

namespace App\Listeners;

use App\Events\RunPythonScriptJobStarted;
use App\Events\RunPythonScriptJobFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SendRunPythonScriptJobMessage implements ShouldQueue
{
    public function __construct()
    {
        //
    }
    public function handle($event)
    {
        if ($event instanceof RunPythonScriptJobStarted) {
            Session::flash('jobStatusMessage', 'El job de ejecución de script Python ha comenzado.');
        } elseif ($event instanceof RunPythonScriptJobFinished) {
            Session::flash('jobStatusMessage', 'El job de ejecución de script Python ha finalizado.');
        }

        Log::info('Mensaje de estado del job establecido en la sesión.');
    }
}
