<?php

use Slim\App;

return function (App $app) {

    /**
     * Converter Moeda - Endpoint
     * 
     * @url /currencies
     * @method GET
     * @queryParam string from
     * @queryParam string to
     * @queryParam float amount
     */
    $app->get('/currencies', 'App\Controllers\CurrencyController:convertCurrency');

};