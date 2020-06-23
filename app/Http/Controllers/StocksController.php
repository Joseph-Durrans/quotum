<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\GbSymbols;
use App\UsSymbols;

class StocksController extends Controller
{

    // public function getStockSymbolData($client, $apiToken, $filter){
    // 	$response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/region/gb/symbols?'. $filter . '&' . $apiToken));
    // 	$statusCode = $response->getStatusCode();
    // 	$body = $response->getBody()->getContents();

    // 	return $body;
    // }

    // public function getAPIData(){
    //     $apiToken = 'token=Tpk_c6eac6ec83af498380331eb5aa54b258';
    //     $client = new Client();
    //     $filter =  'filter=symbol';
    //     $symbolData = self::getStockSymbolData($client, $apiToken, $filter);
    //     return json_decode($symbolData, true);
    // }

    public function getDatabaseData(){
        $gbSymbols = GbSymbols::all()->toArray();
        $usSymbols = UsSymbols::all()->toArray();

        $allSymbols = array_merge($gbSymbols, $usSymbols);
        
        return $allSymbols;

    }

    public function index()
    {
        $DatabaseSymbolsData = self::getDatabaseData();
        return view('stocks')->with('stock_symbol', $DatabaseSymbolsData);
    }
}
