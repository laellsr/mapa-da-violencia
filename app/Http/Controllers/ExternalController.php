<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

class ExternalController extends Controller
{
    /**
     * Retrive external site data
     */
    public function index(Request $request)
    {
        $client = new Client();

        $response = $client->request('GET', $request->url);

        $body = $response->getBody();

        return $body;
    }
}
