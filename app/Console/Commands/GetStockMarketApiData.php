<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\LonSymbols;
use App\NysSymbols;

class GetStockMarketApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:getStockMarketApiData';

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

    protected $apiLonUrl;
    protected $apiNysUrl;

    public function assembleApiUrls($filter){
        $this->apiLonUrl = env('IEX_CLOUD_TESTING_HOST') . '/stable/ref-data/exchange/lon/symbols?'. $filter . '&token=' . env('IEX_CLOUD_TESTING_TOKEN');
        $this->apiNysUrl = env('IEX_CLOUD_TESTING_HOST') . '/stable/ref-data/exchange/nys/symbols?'. $filter . '&token=' . env('IEX_CLOUD_TESTING_TOKEN');
    }

    public function getStockSymbolData($client, $filter){
    	$response = $client->request('GET', $this->apiLonUrl);
    	$statusCode = $response->getStatusCode();
    	$gbBody = $response->getBody()->getContents();

        $response = $client->request('GET', $this->apiNysUrl);
    	$statusCode = $response->getStatusCode();
    	$usBody = $response->getBody()->getContents();

        $gbBodyArray['gb'] = json_decode($gbBody, true);
        $usBodyArray['us'] = json_decode($usBody, true);

        $body = array_merge($gbBodyArray, $usBodyArray);

        return $body;
    }

    public function getAPIData(){
        $filter =  'filter=symbol,name,exchange,region,currency';
        self::assembleApiUrls($filter);
        $client = new Client();
        $symbolData = self::getStockSymbolData($client, $filter);
        return $symbolData;
    }

    public function storeGbSymbolData($symbolData){
        foreach ($symbolData as $symbol) {
            $symbolEntry = LonSymbols::updateOrCreate(
                ['symbol' => $symbol['symbol'], 'exchange' => $symbol['exchange']],
                ['name' => $symbol['name'], 'currency' => $symbol['currency']]
            );
        }
    }

    public function storeUsSymbolData($symbolData){
        foreach ($symbolData as $symbol) {
            $symbolEntry = NysSymbols::updateOrCreate(
                ['symbol' => $symbol['symbol'], 'exchange' => $symbol['exchange']],
                ['name' => $symbol['name'], 'currency' => $symbol['currency']]
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
