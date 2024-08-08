<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $client = new Client();

        $apiUrl = "https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11";

        try {
            $response = $client->get($apiUrl);
            $data = json_decode($response->getBody(), true);

            return response()->json($data, 200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }
}
