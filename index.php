<?php
session_start();
require_once 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Twig setup
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// --- Utility Functions ---

// Get tickets
function getTickets() {
    $ticketsFile = __DIR__ . '/data/tickets.json';
    if (file_exists($ticketsFile)) {
        $json = file_get_contents($ticketsFile);
        return json_decode($json, true) ?: [];
    }
    return [];
}

// Get users
function getUsers() {
    $usersFile = __DIR__ . '/data/users.json';
    if (file_exists($usersFile)) {
        $json = file_get_contents($usersFile);
        return json_decode($json, true) ?: [];
    }
    return [];
}

// Save users
function saveUsers(array $users) {
    $usersFile = __DIR__ . '/data/users.json';
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}

// Find user by email
function findUserByEmail($email) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) return $user;
    }
    return null;
}

// --- Routing ---
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {

    case '/':
        echo $twig->render('home.twig', ['current_page' => 'home']);
        break;

    case '/auth/login':
        $errors = [];
        $formData = ['email' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $formData['email'] = $email;

            if (!$email) $errors['email'] = "Email is required";
            if (!$password) $errors['password'] = "Password is required";

            if (empty($errors)) {
                $user = findUserByEmail($email);
                if ($user && $user['password'] === $password) { // Plain text for now
                    $_SESSION['isAuthenticated'] = true;
                    $_SESSION['user'] = $user;
                    header('Location: /dashboard');
                    exit;
                } else {
                    $loginError = "Invalid email or password";
                }
            }
        }

        echo $twig->render('login.twig', [
            'current_page' => 'login',
            'errors' => $errors,
            'formData' => $formData,
            'loginError' => $loginError ?? null
        ]);
        break;

    case '/auth/signup':
        $errors = [];
        $formData = ['name' => '', 'email' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';

            $formData['name'] = $name;
            $formData['email'] = $email;

            if (!$name) $errors['name'] = "Name is required";
            if (!$email) $errors['email'] = "Email is required";
            if (!$password) $errors['password'] = "Password is required";
            if ($password !== $confirmPassword) $errors['confirmPassword'] = "Passwords do not match";

            if (empty($errors)) {
                // Check if user exists
                if (findUserByEmail($email)) {
                    $errors['email'] = "Email already exists";
                } else {
                    // Save user
                    $users = getUsers();
                    $users[] = [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password, // Use password_hash($password, PASSWORD_DEFAULT) in production
                        'createdAt' => date('c')
                    ];
                    saveUsers($users);

                    // Auto-login after signup
                    $_SESSION['isAuthenticated'] = true;
                    $_SESSION['user'] = ['name' => $name, 'email' => $email];

                    header('Location: /dashboard');
                    exit;
                }
            }
        }

        echo $twig->render('signup.twig', [
            'current_page' => 'signup',
            'errors' => $errors,
            'formData' => $formData
        ]);
        break;

    case '/dashboard':
        if (!isset($_SESSION['isAuthenticated']) || $_SESSION['isAuthenticated'] !== true) {
            header('Location: /auth/login');
            exit;
        }

        $tickets = getTickets();
        echo $twig->render('dashboardpage.twig', [
            'current_page' => 'dashboard',
            'totalTickets' => count($tickets),
            'openTickets' => count(array_filter($tickets, fn($t) => $t['status'] === 'OPEN')),
            'inProgressTickets' => count(array_filter($tickets, fn($t) => $t['status'] === 'IN_PROGRESS')),
            'closedTickets' => count(array_filter($tickets, fn($t) => $t['status'] === 'CLOSED'))
        ]);
        break;

  case '/tickets':
    if (!isset($_SESSION['isAuthenticated']) || $_SESSION['isAuthenticated'] !== true) {
        header('Location: /auth/login');
        exit;
    }

    echo $twig->render('ticketpage.twig', [
        'current_page' => 'tickets',
        'tickets' => getTickets()
    ]);
    break;


    case '/logout':
        session_unset();
        session_destroy();
        header('Location: /auth/login');
        exit;
        break;

    default:
        http_response_code(404);
        echo $twig->render('404.twig', ['current_page' => '404']);
        break;
}
