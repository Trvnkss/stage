<?php
class DashboardController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }
    }
    public function index()
    {
        $pageTitle = "Tableau de Bord";
        $content = "<h3>Bienvenue sur l'application de gestion de stock La Baraque !</h3><p>La structure initiale est en place. Utilisez le menu pour naviguer.</p>";
        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }
}
