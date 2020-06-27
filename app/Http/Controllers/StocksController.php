<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\LonSymbols;
use App\NysSymbols;

class StocksController extends Controller
{
    public function getRandomDatabaseData(){
        $gbSymbols = LonSymbols::orderBy('symbol', 'asc')->take(50)->get()->toArray();
        $usSymbols = NysSymbols::orderBy('symbol', 'asc')->take(50)->get()->toArray();

        $allSymbols = array_merge($gbSymbols, $usSymbols);
        
        return $allSymbols;
    }

    public function getSearchDatabaseData($searchInput){
        $gbSymbols = LonSymbols::where('symbol', strtoupper($searchInput))->get();
        $usSymbols = NysSymbols::where('symbol', strtoupper($searchInput))->get();
        
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
        if(is_array($DatabaseSearchSymbolsData)){
            return view('stocks')->with('random_stock_symbols', $DatabaseSymbolsData)->with('search_stock_symbol', $DatabaseSearchSymbolsData);
        }
        else{
            return view('stocks')->with('random_stock_symbols', $DatabaseSymbolsData)->with('search_not_found', $DatabaseSearchSymbolsData);
        }
    }
}
