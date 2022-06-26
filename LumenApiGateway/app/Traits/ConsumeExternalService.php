<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalService{


    /**
     * Send a request to any service
     * @return string info from the services requested
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = []){

        // Create a client from GuzzleHttp
        $client = new Client([
            'base_uri' => $this->baseUri, // baseUri comes from the class that is using this trait in this case any Service.php in Services folder
        ]);

        // if the secret is set in  the services from env --> config services the add another header with Autorization name if there isnt a secret it'll fail 
        if ( isset( $this->secret ) ) {
            $headers['Authorization'] = $this->secret;
        }


        $response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);

        return $response->getBody()->getContents();

    }

}