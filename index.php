<?php

// load the (optional) Composer auto-loader
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
}

// load application class
require 'App/Core/Application.php';

// start the application
$app = new Application();
