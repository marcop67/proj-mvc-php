<?php

// load application Config (error reporting etc.)
require 'App/Config/config.php';
require 'Router.php';
require 'Controller.php';

class Application
{
    public function __construct()
    {
        new Router();
    }
}