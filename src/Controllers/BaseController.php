<?php

declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    /**
     * App
     *
     * @var Slim\App
     */
    protected $app;

    /**
     * Contructor
     */
    function __construct()
    {
        $this->app = $GLOBALS['app'];
    }
}