<?php

require_once './vendor/autoload.php'; // Load Composer dependencies
use Pecee\SimpleRouter\SimpleRouter as Router;

// Include the routes file
require_once './router.php';

// Start the router
Router::start();
