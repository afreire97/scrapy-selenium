<?php

namespace App\Http\Controllers;

use App\Models\RelojVinted;
use App\Models\RelojWallapop;
use Illuminate\Http\Request;

class RelojController extends Controller
{



    public function index()
    {

        $relojesVinted = RelojVinted::orderBy('created_at', 'desc')->get();
        $relojesWallapop = RelojWallapop::orderBy('created_at', 'desc')->get();

        return view('relojes.index', compact('relojesVinted', 'relojesWallapop'));


    }
    public function showRelojesViejosV($reloj)
    {

        $relojEncontrado = RelojVinted::findOrFail($reloj);
        $tipo = $relojEncontrado->tipo;

        $relojesViejos = $relojEncontrado->relojesViejos;

        $relojViejoMasReciente = $relojEncontrado->relojesViejos()->latest('created_at')->first();


        return view('relojes.show', compact('relojesViejos', 'tipo'));


    }
    public function showRelojesViejosW($reloj)
    {

        $relojEncontrado = RelojWallapop::findOrFail($reloj);

        $tipo = $relojEncontrado->tipo;
        $relojesViejos = $relojEncontrado->relojesViejos;



        return view('relojes.show', compact('relojesViejos', 'tipo'));


    }
    public function datosRelojesViejosVinted($relojId)
    {
        $reloj = RelojVinted::findOrFail($relojId);
        $relojesViejos = $reloj->relojesViejos;

        $datosFormatoEspecifico = [];

        foreach ($relojesViejos as $relojViejo) {
            $datosFormatoEspecifico[] = [
                'fecha_obtencion' => $relojViejo->fecha_obtencion,
                'price' => $relojViejo->price,
                'views' => $relojViejo->views,
                'created_at' => $relojViejo->created_at->format('Y-m-d H:i:s'), // Formatea la fecha con hora

            ];
        }
        $datosFormatoEspecifico[] = [
            'fecha_obtencion' => $reloj->updated_at->format('Y-m-d H:i:s'),
            'price' => $reloj->price,
            'views' => $reloj->views,
            'created_at' => $reloj->created_at->format('Y-m-d H:i:s'),
        ];

        return response()->json($datosFormatoEspecifico);
    }

    public function datosRelojesViejosWallapop($relojId)
    {
        $reloj = RelojWallapop::findOrFail($relojId);
        $relojesViejos = $reloj->relojesViejos;

        $datosFormatoEspecifico = [];

        foreach ($relojesViejos as $relojViejo) {
            $datosFormatoEspecifico[] = [
                'fecha_obtencion' => $relojViejo->fecha_obtencion,
                'price' => $relojViejo->price,
                'views' => $relojViejo->views,
                'created_at' => $relojViejo->created_at->format('Y-m-d H:i:s'),

            ];
        }
        $datosFormatoEspecifico[] = [
            'fecha_obtencion' => $reloj->updated_at->format('Y-m-d H:i:s'),
            'price' => $reloj->price,
            'views' => $reloj->views,
            'created_at' => $reloj->created_at->format('Y-m-d H:i:s'),
        ];

        return response()->json($datosFormatoEspecifico);
    }


    public function destroy(Request $request)
    {

        $id = $request->input('relojId');


        $deleted = RelojVinted::destroy($id);

        if (!$deleted) {
            $deleted = RelojWallapop::destroy($id);
        }

        if ($deleted) {
            return redirect()->route('relojes.index')->with('success', 'Reloj eliminado correctamente');
        } else {
            return redirect()->route('relojes.index')->with('error', 'El reloj con el ID especificado no existe');
        }

    }



    public function guardarReloj(Request $request)
    {
        $reloj = json_decode($request->input('relojData'), true);

        $tipo = $reloj['tipo'];

        if ($tipo === 1) {
            $relojModel = new RelojVinted();


            $relojExiste = RelojVinted::where('identificador', $reloj['identificador'])->first();

            if ($relojExiste != null) {
                return redirect()->route('dashboard')->with('error', 'El reloj con el ID especificado ya existe');
            }


        } elseif ($tipo === 2) {
            $relojModel = new RelojWallapop();
            $relojExiste = RelojWallapop::where('identificador', $reloj['identificador'])->first();

            if ($relojExiste != null) {
                return redirect()->route('dashboard')->with('error', 'El reloj con el ID especificado ya existe');
            }
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

            return redirect()->route('dashboard')->with('success', 'Reloj guardado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Hubo un error al guardar el reloj: ' . $e->getMessage());
        }
    }
}
