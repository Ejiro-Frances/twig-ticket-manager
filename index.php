<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$featuresData = [
    [
        'title' => 'Dashboard',
        'body' => 'At-a-glance metrics for tickets and agent performance.'
    ],
    [
        'title' => 'Custom Workflows',
        'body' => 'Create triggers and automations for common ticket flows.'
    ],
    [
        'title' => 'Integrations',
        'body' => ''
    ]
];

// Render home.twig and pass the features data
echo $twig->render('home.twig', [
    'features' => $featuresData
]);