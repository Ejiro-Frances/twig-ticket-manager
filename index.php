<?php
require_once 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Twig setup
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);



// Get current route (path only)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routing logic
switch ($uri) {
    case '/':
        echo $twig->render('home.twig', [
            
            'current_page' => 'home'
        ]);
        break;

    case '/auth/login':
        echo $twig->render('login.twig', [
            'current_page' => 'login'
        ]);
        break;

    case '/auth/signup':
        echo $twig->render('signup.twig', [
            'current_page' => 'signup'
        ]);
        break;

    default:
        http_response_code(404);
        echo $twig->render('404.twig', [
            'current_page' => '404'
        ]);
        break;
}
