<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GeocodeController extends Controller
{
    public function geocode(Request $request)
    {
        $address = $request->input('address');
        $client = new Client();
        
        $response = $client->get('https://nominatim.openstreetmap.org/search', [
            'query' => [
                'q' => $address,
                'format' => 'json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (!empty($data)) {
            $firstResult = $data[0];
            $latitude = $firstResult['lat'];
            $longitude = $firstResult['lon'];
            return response()->json(['latitude' => $latitude, 'longitude' => $longitude]);
        } else {
            return response()->json(['error' => 'Endereço não encontrado.']);
        }
    }
}
