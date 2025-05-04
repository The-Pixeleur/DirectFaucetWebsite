<?php

// For debugging - display errors directly
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load environment variables from .env file
function loadEnv($path = '.env') {
    if (!file_exists($path)) {
        // Try to check if .env exists in other common paths
        $alternative_paths = [
            __DIR__ . '/../.env',
            __DIR__ . '/../../.env',
            $_SERVER['DOCUMENT_ROOT'] . '/.env'
        ];
        
        foreach ($alternative_paths as $alt_path) {
            if (file_exists($alt_path)) {
                $path = $alt_path;
                break;
            }
        }
        
        if (!file_exists($path)) {
            return false;
        }
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos(trim($line), '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            if (!array_key_exists($key, $_ENV)) {
                putenv(sprintf('%s=%s', $key, $value));
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
            }
        }
    }
    
    return true;
}

// Try to load environment variables
$env_loaded = loadEnv();

// Function to get database connection
function getDbConnection() {
    $db_config = [
        'host' => getenv('DB_HOST'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME')
    ];
    
    try {
        $conn = new mysqli(
            $db_config['host'],
            $db_config['username'],
            $db_config['password'],
            $db_config['dbname']
        );

        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        return $conn;
    } catch (Exception $e) {
        throw $e;
    }
}
