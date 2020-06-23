<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\GbSymbols;
use App\UsSymbols;

class SingleStockController extends Controller
{
    // public function getStockSymbolData($client, $apiToken, $filter){
    // 	$response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/region/gb/symbols?'. $filter . '&' . $apiToken));
    // 	$statusCode = $response->getStatusCode();
    // 	$body = $response->getBody()->getContents();

    // 	return $body;
    // }

    public function getStockData($client, $apiToken, $stock){
        $response = $client->request('GET', ('https://sandbox.iexapis.com/stable/stock/'. $stock . '/quote?' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function getAPIData($stock){
        $apiToken = 'token=Tpk_c6eac6ec83af498380331eb5aa54b258';
        $client = new Client();
        $correspondingGbSymbol = GbSymbols::where('symbol', strtoupper($stock))->first();
        $correspondingUsSymbol = UsSymbols::where('symbol', strtoupper($stock))->first();
        if(!$correspondingGbSymbol && !$correspondingUsSymbol){
            abort(404);
        }
        elseif($correspondingGbSymbol && !$correspondingUsSymbol){
            if(strtoupper($correspondingGbSymbol['symbol']) == strtoupper($stock)){
                $singleStockData = json_decode(self::getStockData($client, $apiToken, $stock), true);
                return $singleStockData;
            }
        }
        elseif($correspondingUsSymbol && !$correspondingGbSymbol){
            if(strtoupper($correspondingUsSymbol['symbol']) == strtoupper($stock)){
                $singleStockData = json_decode(self::getStockData($client, $apiToken, $stock), true);
                return $singleStockData;
            }
        }
        else{
            abort(404);
        }
    }

    public function index($stock)
    {
        $singleStockData = self::getAPIData($stock);
        return view('single_stock')->with('stock', $singleStockData);
    }
}
