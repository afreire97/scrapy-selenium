<?php

namespace App\Http\Controllers;

use App\Models\RelojVinted;
use App\Models\RelojWallapop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RelojController extends Controller
{



    public function index()
    {

        $relojesVinted = RelojVinted::orderBy('created_at', 'desc')->get();
        $relojesWallapop = RelojWallapop::orderBy('created_at', 'desc')->get();

        return view('relojes.index', compact('relojesVinted', 'relojesWallapop'));


    }


    public function destroy(Request $request){

        $id = $request->input('relojId');


        $deleted = RelojVinted::destroy($id);

        // Si no se encontró en RelojVinted, intenta eliminarlo de RelojWallapop
        if (!$deleted) {
            $deleted = RelojWallapop::destroy($id);
        }

        // Verifica si se eliminó correctamente
        if ($deleted) {
            return redirect()->route('relojes.index')->with('success', 'Reloj eliminado correctamente');
        } else {
            return  redirect()->route('relojes.index')->with('error', 'El reloj con el ID especificado no existe');
        }

    }










    /**
     * Guarda un reloj en la base de datos.
     */



    public function guardarReloj(Request $request)
    {
        $reloj = json_decode($request->input('relojData'), true);

        $tipo = $reloj['tipo'];

        if ($tipo === 1) {
            $relojModel = new RelojVinted();
        } elseif ($tipo === 2) {
            $relojModel = new RelojWallapop();
        } else {
            return redirect()->route('dashboard')->with('error', 'Tipo de reloj no válido');
        }

        try {
            $relojModel->fill($reloj);
            $price = str_replace(',', '.', $reloj['price']); // Eliminar las comas
            $price = trim($price); // Eliminar espacios en blanco al principio y al final

            // Convertir el precio a formato decimal
            $price_decimal = floatval($price);

            // Guardar el precio en la base de datos
            $relojModel->price = $price_decimal;
            $relojModel->save();

            return redirect()->route('relojes.index')->with('success', 'Reloj guardado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Hubo un error al guardar el reloj: ' . $e->getMessage());
        }
    }
}
