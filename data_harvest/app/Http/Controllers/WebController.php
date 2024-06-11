<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\LectorJson;
use App\Models\RelojVinted;
use App\Models\RelojWallapop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebController extends Controller
{


    public function indexAction()
    {



        $relojesWallapop = LectorJson::leerJsonWallapop();
        $identificadoresW = RelojWallapop::all()->pluck('identificador')->toArray();

        // Filtrar los relojes de $relojesWallapop que no están en $identificadoresW
        $relojesFiltradosWallapop = array_filter($relojesWallapop, function ($reloj) use ($identificadoresW) {
            return !in_array($reloj->identificador, $identificadoresW);
        });

        // Si necesitas reiniciar los índices del array
        $relojesFiltradosWallapop = array_values($relojesFiltradosWallapop);
        $relojesVinted = LectorJson::leerJsonVinted();
        $identificadoresV = RelojVinted::all()->pluck('identificador')->toArray();

        // Filtrar los relojes de $relojesVinted que no están en $identificadoresV
        $relojesFiltradosV = array_filter($relojesVinted, function ($reloj) use ($identificadoresV) {
            return !in_array($reloj->identificador, $identificadoresV);
        });

        // Si necesitas reiniciar los índices del array
        $relojesFiltradosV = array_values($relojesFiltradosV);

        return view('dashboard', ['relojesVinted' => $relojesFiltradosV, 'relojesWallapop' => $relojesFiltradosWallapop]);
    }


}
