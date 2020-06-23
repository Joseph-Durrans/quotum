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

    public function getRandomDatabaseData(){
        $gbSymbols = GbSymbols::orderBy('symbol', 'asc')->take(50)->get()->toArray();
        $usSymbols = UsSymbols::orderBy('symbol', 'asc')->take(50)->get()->toArray();

        $allSymbols = array_merge($gbSymbols, $usSymbols);
        
        return $allSymbols;

    }

    public function getSearchDatabaseData($searchInput){
        $gbSymbols = GbSymbols::where('symbol', strtoupper($searchInput))->get();
        $usSymbols = UsSymbols::where('symbol', strtoupper($searchInput))->get();
        
        $searchedSymbol = array_merge($gbSymbols->toArray(), $usSymbols->toArray());

        if($searchedSymbol){
            return $searchedSymbol[0];
        }
        
        return 'There Is No Stock Data For That Symbol';
    }

    public function index()
    {
        $DatabaseSymbolsData = self::getRandomDatabaseData();
        return view('stocks')->with('random_stock_symbols', $DatabaseSymbolsData);
    }

    public function search(Request $request)
    {
        $searchInput = $request->input('search');
        $DatabaseSymbolsData = self::getRandomDatabaseData();
        $DatabaseSearchSymbolsData = self::getSearchDatabaseData($searchInput);
        var_dump($DatabaseSearchSymbolsData);
        
        if(is_array($DatabaseSearchSymbolsData)){
            return view('stocks')->with('random_stock_symbols', $DatabaseSymbolsData)->with('search_stock_symbol', $DatabaseSearchSymbolsData);
        }
        else{
            return view('stocks')->with('random_stock_symbols', $DatabaseSymbolsData)->with('search_not_found', $DatabaseSearchSymbolsData);
        }
    }
}
