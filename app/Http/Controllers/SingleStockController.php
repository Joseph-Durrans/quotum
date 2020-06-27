<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\LonSymbols;
use App\NysSymbols;

class SingleStockController extends Controller
{
    private $apiStockUrl;
    private $apiStockHistoryUrl;

    public function assembleApiUrls($stock){
        $this->apiStockUrl = env('IEX_CLOUD_TESTING_HOST') . '/stable/stock/'. $stock . '/quote?token=' . env('IEX_CLOUD_TESTING_TOKEN');
        $this->apiStockHistroyUrl = env('IEX_CLOUD_TESTING_HOST') . '/stable/stock/'. $stock . '/quote?token=' . env('IEX_CLOUD_TESTING_TOKEN');
    }

    public function getStockData(){
        $client = new Client();
        $response = $client->request('GET', $this->apiStockUrl);
    	$statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function getAPIData($stock){
        self::assembleApiUrls($stock);
        $correspondingGbSymbol = LonSymbols::where('symbol', strtoupper($stock))->first();
        $correspondingUsSymbol = NysSymbols::where('symbol', strtoupper($stock))->first();
        if(!$correspondingGbSymbol && !$correspondingUsSymbol){
            abort(404);
        }
        elseif($correspondingGbSymbol && !$correspondingUsSymbol){
            if(strtoupper($correspondingGbSymbol['symbol']) == strtoupper($stock)){
                $singleStockData = json_decode(self::getStockData(), true);
                return $singleStockData;
            }
        }
        elseif($correspondingUsSymbol && !$correspondingGbSymbol){
            if(strtoupper($correspondingUsSymbol['symbol']) == strtoupper($stock)){
                $singleStockData = json_decode(self::getStockData(), true);
                return $singleStockData;
            }
        }
        else{
            abort(404);
        }
    }

    public function updateGraph($stock){
        self::assembleApiUrls($stock);
        $client = new Client();
        $response = $client->request('GET', $this->apiStockHistroyUrl);
        $statusCode = $response->getStatusCode();
    	$body = $response->getBody()->getContents();

    	return $body;
    }

    public function index($stock)
    {
        $singleStockData = self::getAPIData($stock);
        return view('single_stock')->with('stock', $singleStockData);
    }
}
