<?php

namespace App\Http\Controllers\Utils;
use App\Models\RelojVinted;
use App\Models\RelojWallapop;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LectorJson{


public static function leerJsonVinted()
    {
        // Ruta al archivo JSON
        $rutaJson = __DIR__ . '/../../../../../web_crawler/web_crawler/vinted.json';



        // Verificar si el archivo JSON existe
        if (File::exists($rutaJson)) {




            // Leer el contenido del archivo JSON
            $contenidoJson = File::get($rutaJson);

            // Decodificar el contenido JSON a un array de objetos
            $relojesVintedData = json_decode($contenidoJson, true);

            // Array para almacenar instancias de RelojVinted
            $relojesVinted = [];

            // Iterar sobre los datos del JSON y crear instancias de RelojVinted
            foreach ($relojesVintedData as $relojData) {
                $reloj = new RelojVinted();
                $reloj->title = $relojData['title'];
                $reloj->image_src = $relojData['image_src'];
                $reloj->price = $relojData['price'];
                $reloj->brand = $relojData['brand'];
                $reloj->location = $relojData['location'];
                $reloj->views = $relojData['views'];
                $reloj->url = $relojData['url'];
                $reloj->identificador = $relojData['identificador'];

                // Agregar el objeto RelojVinted al array
                $relojesVinted[] = $reloj;
            }

            // Devolver el array de objetos RelojVinted
            return $relojesVinted;
        } else {
            // Si el archivo no existe, devolver un array vacío
            Log::info("no se encontro el archivo.");


            return [];
        }
    }
    public static function leerJsonWallapop()
    {
        // Ruta al archivo JSON
        $rutaJson = __DIR__ . '/../../../../../web_crawler/web_crawler/wallapop.json';

        // Verificar si el archivo JSON existe
        if (File::exists($rutaJson)) {
            // Leer el contenido del archivo JSON
            $contenidoJson = File::get($rutaJson);

            // Decodificar el contenido JSON a un array de objetos
            $relojesWallapopData = json_decode($contenidoJson, true);

            // Array para almacenar instancias de RelojWallapop
            $relojesWallapop = [];

            // Iterar sobre los datos del JSON y crear instancias de RelojWallapop
            foreach ($relojesWallapopData as $relojData) {
                $reloj = new RelojWallapop();
                $reloj->title = $relojData['title'];
                $reloj->image_src = $relojData['image_src'];
                $reloj->price = $relojData['price'];
                $reloj->location = $relojData['location'];
                $reloj->views = $relojData['views'];
                $reloj->url = $relojData['url'];
                $reloj->identificador = $relojData['identificador'];

                // Agregar el objeto RelojWallapop al array
                $relojesWallapop[] = $reloj;
            }

            // Devolver el array de objetos RelojWallapop
            return $relojesWallapop;
        } else {
            // Si el archivo no existe, devolver un array vacío
            Log::info("No se encontró el archivo JSON de Wallapop.");
            return [];
        }
    }

}
