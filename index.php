<?php

// Errors reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Import Config
require_once('./app/config/config.php');

// Autoload with Composer
require_once('./vendor/autoload.php');

// Init App
$app = new Core\App();
