<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class StocksController extends Controller
{

    public function getStockSymbolData($client, $apiToken){
    	$response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/iex/symbols' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function getAPIData(){
        $apiToken = '?token=Tpk_c6eac6ec83af498380331eb5aa54b258';
        $client = new Client();
        $symbolData = self::getStockSymbolData($client, $apiToken);
        return json_decode($symbolData, true);
    }

    public function index()
    {
        $apiSymbolsData = self::getAPIData();
        return view('stocks')->with('stock_symbol', $apiSymbolsData);
    }
}
