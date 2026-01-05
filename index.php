<?php
session_start();

// Définition des constantes de chemin de base
define('BASE_PATH', __DIR__);
define('BASE_URL', '/stage');

// Le chargement automatique des contrôleurs et modèles pourrait se faire ici, ou être requis selon les besoins.
// Pour plus de simplicité, nous allons requérir les contrôleurs nécessaires en fonction de la route.

// Routage simple basé sur les paramètres URL 'controller' et 'action'
$controllerName = isset($_GET['controleur']) ? $_GET['controleur'] : 'dashboard';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// Vérification de l'authentification : Redirection vers la page de connexion si non authentifié lors de l'accès à une zone sécurisée
$publicRoutes = [
    'auth' => ['login', 'authenticate', 'logout']
];

$isPublicRoute = isset($publicRoutes[$controllerName]) && in_array($actionName, $publicRoutes[$controllerName]);

if (!isset($_SESSION['user_id']) && !$isPublicRoute) {
    // Redirection forcée vers la page de connexion
    header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
    exit();
}

// Routage du contrôleur
$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = BASE_PATH . '/controleurs/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerClass();

    if (method_exists($controller, $actionName)) {
        // Appel final de l'action souhaitée
        $controller->$actionName();
    } else {
        // Action introuvable
        http_response_code(404);
        echo "404 - Action not found";
    }
} else {
    // Contrôleur introuvable
    http_response_code(404);
    echo "404 - Controller not found";
}
?>