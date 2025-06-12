<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    // Muestra el clima de una ciudad (ruta: /clima o /clima/{ciudad})
    public function show($ciudad = null)
    {
        $ciudad = request('ciudad', $ciudad ?? 'Santa Ana'); 

        $apiKey = env('WEATHER_API_KEY');

        $response = Http::get('http://api.weatherapi.com/v1/current.json', [
            'key' => $apiKey,
            'q' => $ciudad,
            'lang' => 'es'
        ]);

        if ($response->successful()) {
            return view('clima', [
                'clima' => $response->json(),
                'ciudad' => ucfirst($ciudad)
            ]);  
        } else {
            $error = $response->json()['error']['message'] ?? 'No se pudo obtener el clima.';
            return view('clima', [
                'clima' => null,
                'ciudad' => ucfirst($ciudad),
                'error' => $error
            ]);
        }
    }

    // Muestra el clima de múltiples ciudades en cards (ruta: /climas)
    public function showMultiple()
    {
        $apiKey = env('WEATHER_API_KEY');

        $ciudades = [
            'San Salvador', 'Santa Ana', 'San Miguel', 'Ahuachapán centro',
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

        return view('climas', ['climas' => $climas]);
    }
}
