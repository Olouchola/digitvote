<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AirtableController extends Controller
{
    protected $apiKey;
    protected $baseId;
    protected $tableName;
    protected $client;

    public function __construct()
    {
        $this->apiKey = 'pat1nIBbczbI3jp82.efc873ed6b2905a7957adab41ccc62722c4e392786ff56872c48c7b7fe6ba86f';
        $this->baseId = 'appdhqpf9kM1jhhjc';
        $this->tableName = 'Table%201';

        $this->client = new Client([
            'base_uri' => "https://api.airtable.com/v0/{$this->baseId}/",
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function getData()
    {
        try {
            $response = $this->client->get($this->tableName);
            $records = json_decode($response->getBody(), true)['records'];
            // dd($records);
            foreach ($records as $record) {
                $fields = $record['fields'];
                $choix = $fields['Choix'];
                $vote = $fields['Vote'];
                $Id = $fields['Id'];
                echo "Choix: $choix, Vote: $vote , ID: $Id\n";
            }
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
