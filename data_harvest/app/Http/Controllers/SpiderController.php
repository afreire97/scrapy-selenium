<?php

namespace App\Http\Controllers;

use App\Jobs\RunPythonScriptJob;
use Illuminate\Http\Request;

class SpiderController extends Controller
{
    public function runPythonScript()
    {
        dispatch(new RunPythonScriptJob());

        return response()->json(['success' => true, 'message' => 'Job para ejecutar el script de Python encolado correctamente.']);
    }
}
