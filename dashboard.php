<?php
session_start();
require_once 'vendor/autoload.php';

// Check if user is authenticated
if (!isset($_SESSION['isAuthenticated']) || $_SESSION['isAuthenticated'] !== true) {
    header('Location: login.php');
    exit;
}

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// Get tickets from database or session/file storage
$tickets = getTickets(); // Your function to retrieve tickets

// Calculate statistics
$totalTickets = count($tickets);
$openTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'OPEN'));
$inProgressTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'IN_PROGRESS'));
$closedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'CLOSED'));

echo $twig->render('dashboard.twig', [
    'totalTickets' => $totalTickets,
    'openTickets' => $openTickets,
    'inProgressTickets' => $inProgressTickets,
    'closedTickets' => $closedTickets
]);
?>