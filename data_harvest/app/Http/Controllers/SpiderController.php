<?php

namespace App\Http\Controllers;

use App\Jobs\EjecutarSpiders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SpiderController extends Controller
{
    //

    public function ejectuarSpiders()
    {
        $spiderName = "vinted"; // Nombre de la araña que deseas ejecutar
        Log::info("Ejecutar spider entramos con la araña: $spiderName");

        // Despacha el trabajo de ejecución de la araña específica
        EjecutarSpiders::dispatchSync($spiderName);

        return response()->json(['message' => 'Araña ejecutada correctamente'], 200);
    }
}
