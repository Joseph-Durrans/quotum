<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        $body[] = json_decode($gbBody, true);
        $body[] = json_decode($usBody, true);

    	return $body;
    }

    public function getAPIData(){
        $apiToken = 'token=Tpk_c6eac6ec83af498380331eb5aa54b258';
        $client = new Client();
        $filter =  'filter=symbol,exchange,region,currency';
        $symbolData = self::getStockSymbolData($client, $apiToken, $filter);
        return json_decode($symbolData, true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
    }
}
