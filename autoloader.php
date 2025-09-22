<?php
// Load Composer's autoloader so we can use external libraries (like phpdotenv)
require __DIR__ . '/vendor/autoload.php';

// Load environment variables from the .env.local file into $_ENV
// This makes DB_HOST, DB_NAME, DB_USER, DB_PASS available everywhere
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '.env.local');
$dotenv->safeLoad();


// Register a function that will automatically load PHP classes when they are needed
spl_autoload_register('myAutoLoader');

/**
 * Autoloader function:
 * Whenever you use a class that hasn't been included yet,
 * PHP will call this function. It will look inside the "Model/" folder,
 * build the expected file path (e.g. Model/Database.php),
 * and include the file if it exists.
 *
 * This avoids having to write "require" statements for each class manually.
 */
function myAutoLoader($className)
{
    $path = "Model/";   // folder where class files live
    $ext = ".php";      // expected file extension
    $fullPath = $path . $className . $ext;  // e.g. Model/Database.php

    if (!file_exists($fullPath)) {
        return false;   // class file not found
    }

    include_once $fullPath;  // load the class definition
}
