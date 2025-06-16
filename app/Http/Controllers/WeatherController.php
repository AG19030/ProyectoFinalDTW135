<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    // Muestra el clima de múltiples ciudades en cards (ruta: /climas)
    public function showMultiple()
    {
        $apiKey = env('WEATHER_API_KEY');

        $ciudades = [
            'San Salvador', 'Santa Ana', 'San Miguel', 'Ahuachapán Centro', //Se dejó "Ahuachapán Centro" porque solo asi reconocia la ciudad
            'La Libertad', 'Sonsonate', 'Chalatenango', 'La Unión',
            'Cabañas', 'Morazán', 'Cuscatlán', 'Usulután',
            'La Paz', 'San Vicente'
        ];

        $climas = [];

        foreach ($ciudades as $ciudad) {
            $response = Http::get('http://api.weatherapi.com/v1/current.json', [
                'key' => $apiKey,
                'q' => $ciudad,
                'lang' => 'es'
            ]);

            if ($response->successful()) {
                $climas[] = [
                    'ciudad' => $ciudad,
                    'data' => $response->json()
                ];
            } else {
                $climas[] = [
                    'ciudad' => $ciudad,
                    'data' => null,
                    'error' => $response->json()['error']['message'] ?? 'Error desconocido'
                ];
            }
        }

        return view('backend.admin.climas', ['climas' => $climas]);
    }
}
