<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\LectorJson;
use App\Models\RelojVinted;
use App\Models\RelojWallapop;


class WebController extends Controller
{


    public function indexAction()
    {



        $relojesWallapop = LectorJson::leerJsonWallapop();
        $identificadoresW = RelojWallapop::all()->pluck('identificador')->toArray();

        $relojesFiltradosWallapop = array_filter($relojesWallapop, function ($reloj) use ($identificadoresW) {
            return !in_array($reloj->identificador, $identificadoresW);
        });

        $relojesFiltradosWallapop = array_values($relojesFiltradosWallapop);
        $relojesVinted = LectorJson::leerJsonVinted();
        $identificadoresV = RelojVinted::all()->pluck('identificador')->toArray();

        $relojesFiltradosV = array_filter($relojesVinted, function ($reloj) use ($identificadoresV) {
            return !in_array($reloj->identificador, $identificadoresV);
        });

        $relojesFiltradosV = array_values($relojesFiltradosV);

        return view('dashboard', ['relojesVinted' => $relojesFiltradosV, 'relojesWallapop' => $relojesFiltradosWallapop]);
    }


}
