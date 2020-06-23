<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\GbSymbols;
use App\UsSymbols;

class GetStockMarketApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getStockMarketApiData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get stock market data from IEX Cloud and store it in a database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getStockSymbolData($client, $apiToken, $filter){
    	$response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/region/gb/symbols?'. $filter . '&' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$gbBody = $response->getBody()->getContents();

        $response = $client->request('GET', ('https://sandbox.iexapis.com/stable/ref-data/region/us/symbols?'. $filter . '&' . $apiToken));
    	$statusCode = $response->getStatusCode();
    	$usBody = $response->getBody()->getContents();

        $gbBodyArray['gb'] = json_decode($gbBody, true);
        $usBodyArray['us'] = json_decode($usBody, true);

        $body = array_merge($gbBodyArray, $usBodyArray);

        return $body;
    }

    public function getAPIData(){
        $apiToken = 'token=Tpk_c6eac6ec83af498380331eb5aa54b258';
        $client = new Client();
        $filter =  'filter=symbol,exchange,region,currency';
        $symbolData = self::getStockSymbolData($client, $apiToken, $filter);
        return $symbolData;
    }

    public function storeGbSymbolData($symbolData){
        foreach ($symbolData as $symbol) {
            $symbolEntry = GbSymbols::updateOrCreate(
                ['symbol' => $symbol['symbol'], 'exchange' => $symbol['exchange']],
                ['currency' => $symbol['currency']]
            );
        }
    }

    public function storeUsSymbolData($symbolData){
        foreach ($symbolData as $symbol) {
            $symbolEntry = UsSymbols::updateOrCreate(
                ['symbol' => $symbol['symbol'], 'exchange' => $symbol['exchange']],
                ['currency' => $symbol['currency']]
            );
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $symbolData = self::getApiData();
        self::storeGbSymbolData($symbolData['gb']);
        echo 'gb done';
        self::storeUsSymbolData($symbolData['us']);
        echo 'us done';
    }
}
