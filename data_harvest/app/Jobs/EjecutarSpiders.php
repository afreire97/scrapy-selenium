<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class EjecutarSpiders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $spiderName;

    /**
     * Create a new job instance.
     *
     * @param string $spiderName
     */
    public function __construct($spiderName)
    {
        $this->spiderName = $spiderName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $baseDir = realpath(__DIR__ . '/../../../');
        $pythonExecutable = $baseDir . '/.venv/Scripts/python.exe';

        $process = new Process([$pythonExecutable, '-m', 'scrapy', 'crawl', $this->spiderName]);
        $process->setTimeout(null);

        try {
            $process->mustRun();

            // Obtiene la salida del proceso
            $output = $process->getOutput();

            Log::info("Salida de la ejecución del comando Scrapy:");
            Log::info($output);

            Log::info("Ejecución del comando Scrapy completada correctamente.");
        } catch (ProcessFailedException $exception) {
            Log::error("Error al ejecutar el comando Scrapy: " . $exception->getMessage());
        }
    }
}
