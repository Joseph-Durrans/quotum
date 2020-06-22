<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SingleStockController extends Controller
{
    public function getStockSymbolData($client, $apiToken){
    	$response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/iex/symbols' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function getStockData($client, $apiToken, $stock){
        $response = $client->request('GET', ('https://sandbox.iexapis.com/stable/stock/'. $stock . '/quote' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function getAPIData($stock){
        $apiToken = '?token=Tpk_c6eac6ec83af498380331eb5aa54b258';
        $client = new Client();
        $symbolData = self::getStockSymbolData($client, $apiToken);
        $apiData = json_decode($symbolData, true);
        foreach ($apiData as $singleApiData) {
            if (strtolower($singleApiData['symbol']) == strtolower($stock) ) {
                $stockData = self::getStockData($client, $apiToken, $stock);
            }
        }
        return json_decode($stockData, true);
    }

    public function index($stock)
    {
        $singleApiData = self::getAPIData($stock);
        return view('single_stock')->with('stock', $singleApiData);
    }
}
