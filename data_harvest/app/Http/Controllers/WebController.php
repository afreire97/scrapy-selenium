<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utils\LectorJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebController extends Controller
{


public function indexAction(){



    $relojesVinted = LectorJson::leerJsonVinted();
    $relojesWallapop = LectorJson::leerJsonWallapop();





    return view('dashboard', ['relojesVinted' => $relojesVinted, 'relojesWallapop' => $relojesWallapop]);
}


}
