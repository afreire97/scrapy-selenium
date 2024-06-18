<?php

namespace App\Jobs;

use App\Events\RunPythonScriptJobStarted;
use App\Events\RunPythonScriptJobFinished;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class RunPythonScriptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        // Disparar evento de inicio
        event(new RunPythonScriptJobStarted());

        // Obtener la ruta base de la aplicación Laravel
        $basePath = base_path();

        // Construir rutas absolutas basadas en la ruta base
        $pythonScriptPath = $basePath . '/../web_crawler/web_crawler/run_spiders.py';
        $virtualEnvPath = $basePath . '/../.venv/Scripts/python.exe'; // Para Windows

        $command = "$virtualEnvPath $pythonScriptPath";

        // Ejecutar el comando
        exec($command, $output, $returnCode);

        // Disparar evento de finalización
        event(new RunPythonScriptJobFinished());

        Log::info('Eventos disparados correctamente.');

    }
}
