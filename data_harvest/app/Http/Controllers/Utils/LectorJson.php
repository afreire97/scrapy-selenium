<?php

namespace App\Http\Controllers\Utils;

use App\Models\RelojViejo;
use App\Models\RelojVinted;
use App\Models\RelojWallapop;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LectorJson
{


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

                $reloj->location = $relojData['location'];
                $reloj->views = $relojData['views'];
                $reloj->url = $relojData['url'];
                $reloj->identificador = $relojData['identificador'];
                $reloj->tipo = $relojData['tipo'];
                $fecha = $relojData['fecha_guardado'];
                $reloj->fecha_obtencion = $fecha;




                $price = str_replace(',', '.', $reloj['price']); // Eliminar las comas
                $price = trim($price); // Eliminar espacios en blanco al principio y al final

                // Convertir el precio a formato decimal
                $price_decimal = floatval($price);


                // Verificar si el reloj ya existe en la base de datos y su fecha de actualización es anterior a la fecha actual
                $existingReloj = RelojVinted::where('identificador', $reloj->identificador)
                    ->where('updated_at', '<', $fecha)
                    ->first();

                if ($existingReloj) {
                    // Actualizar los datos del reloj existente en la base de datos con los datos del JSON


                    $relojViejo = new RelojViejo();
                    $relojViejo->title = $existingReloj->title;
                    $relojViejo->image_src = $existingReloj->image_src;
                    $relojViejo->price = $existingReloj->price;
                    $relojViejo->location = $existingReloj->location;
                    $relojViejo->views = $existingReloj->views;
                    $relojViejo->url = $existingReloj->url;
                    $relojViejo->identificador = $existingReloj->identificador;
                    $relojViejo->tipo = $existingReloj->tipo;
                    $relojViejo->reloj_vinted_id = $existingReloj->id;
                    $relojViejo->fecha_obtencion = $existingReloj->fecha_obtencion;

                    $relojViejo->save();

                    $existingReloj->update([
                        'title' => $reloj->title,
                        'image_src' => $reloj->image_src,
                        'price' => $price_decimal,
                        'views' => $reloj->views,
                        'url' => $reloj->url,
                        'tipo' => $reloj->tipo
                    ]);




                } else {
                    // Si el reloj no existe en la base de datos o su fecha de actualización es posterior a la fecha actual, agregarlo al array de relojes Vinted
                    $relojesVinted[] = $reloj;
                }
            }

            // Devolver el array de objetos RelojVinted
            return $relojesVinted;
        } else {
            // Si el archivo no existe, devolver un array vacío
            Log::info("No se encontró el archivo.");
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
                $reloj->tipo = $relojData['tipo'];

                $fecha = $relojData['fecha_guardado'];
                $reloj->fecha_obtencion = $fecha;


                $price = str_replace(',', '.', $reloj['price']); // Eliminar las comas
                $price = trim($price); // Eliminar espacios en blanco al principio y al final

                // Convertir el precio a formato decimal
                $price_decimal = floatval($price);
                // Verificar si el reloj ya existe en la base de datos y su fecha de actualización es anterior a la fecha actual
                $existingReloj = RelojWallapop::where('identificador', $reloj->identificador)
                    ->where('updated_at', '<', $fecha)
                    ->first();

                if ($existingReloj) {
                    // Actualizar los datos del reloj existente en la base de datos con los datos del JSON


                    $relojViejo = new RelojViejo();
                    $relojViejo->title = $existingReloj->title;
                    $relojViejo->image_src = $existingReloj->image_src;
                    $relojViejo->price = $existingReloj->price;
                    $relojViejo->location = $existingReloj->location;
                    $relojViejo->views = $existingReloj->views;
                    $relojViejo->url = $existingReloj->url;
                    $relojViejo->identificador = $existingReloj->identificador;
                    $relojViejo->tipo = $existingReloj->tipo;
                    $relojViejo->fecha_obtencion = $existingReloj->fecha_obtencion;
                    $relojViejo->reloj_wallapop_id = $existingReloj->id;


                    $relojViejo->save();


                    $existingReloj->update([
                        'title' => $reloj->title,
                        'image_src' => $reloj->image_src,
                        'price' => $price_decimal,
                        'views' => $reloj->views,
                        'url' => $reloj->url,
                    ]);
                } else {
                    // Si el reloj no existe en la base de datos o su fecha de actualización es posterior a la fecha actual, agregarlo al array de relojes Vinted
                    $relojesWallapop[] = $reloj;
                }
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
