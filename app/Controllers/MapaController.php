<?php

namespace App\Controllers;

class MapaController extends BaseController
{
    public function mostrarMapa()
    {
        $puntos = [
            // Coordenadas en formato de cadena
            "-34.9033, -56.1882",
            "-30.4000, -56.4667",
            "-34.5228, -56.2797",
            "-32.3833, -54.1667",
            "-34.4667, -57.8333",
            "-33.1289, -56.0392",
            "-33.5222, -56.8931",
            "-34.0958, -56.2142",
            "-34.3728, -54.1769",
            "-34.9083, -54.9583",
            "-32.3214, -58.0756",
            "-32.4514, -57.2361",
            "-30.9000, -55.5500",
            "-34.4833, -54.3333",
            "-31.3833, -57.9667",
            "-34.3375, -56.7136",
            "-33.5431, -58.2014",
            "-31.7167, -55.9833",
            "-33.2333, -54.3833"
        ];
    
        // Convertir las coordenadas a un formato que pueda ser interpretado por JavaScript
        $puntosFormateados = [];
        foreach ($puntos as $punto) {
            $coordenadas = explode(',', trim($punto));
            $puntosFormateados[] = [
                'lat' => floatval(trim($coordenadas[0])),
                'lng' => floatval(trim($coordenadas[1])),
            ];
        }
    
        return view('map/mapa', ['puntos' => $puntosFormateados]);
    }
    

}