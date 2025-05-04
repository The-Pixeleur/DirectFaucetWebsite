<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

// Home route
Router::get('/', function() {
    include './Pages/home.php';
});

Router::get('/faucet', function() {
    include './Pages/faucet.php';
});



Router::get('/faq', function() {
    include './Pages/faq.php';
});
Router::get('/getting-started', function() {
    include './Pages/getting-started.php';
});
Router::get('/privacy-policy', function() {
    include './Pages/privacy.php';
});
Router::get('/tos', function() {
    include './Pages/tos.php';
});
Router::get('/cookies', function() {
    include './Pages/cookie.php';
});

// API Routes
Router::group(['prefix' => '/api'], function () {
    // Middleware to check if request is from admin.pixeleur.fr
    $adminMiddleware = function() {
        $allowedOrigin = 'admin.pixeleur.fr';
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) : '';
        $referer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : '';
        
        if ($origin !== $allowedOrigin && $referer !== $allowedOrigin) {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode(['error' => 'Access denied']);
            exit();
        }
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: https://admin.pixeleur.fr');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json');
    };
    
    // Get all faucets
    Router::get('/faucet', function() use ($adminMiddleware) {
        $adminMiddleware();
        include './API/getFaucets.php';
    });
    
    // Add new faucet
    Router::post('/faucet', function() use ($adminMiddleware) {
        $adminMiddleware();
        include './API/addFaucet.php';
    });
    
    // Update existing faucet
    Router::put('/faucet/{id}', function($id) use ($adminMiddleware) {
        $adminMiddleware();
        $_POST['id'] = $id; // Make ID available to the script
        include './API/updateFaucet.php';
    });
    
    // Delete faucet
    Router::delete('/faucet/{id}', function($id) use ($adminMiddleware) {
        $adminMiddleware();
        $_POST['id'] = $id; // Make ID available to the script
        include './API/deleteFaucet.php';
    });
});

