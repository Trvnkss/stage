<?php
require_once BASE_PATH . '/modeles/Produit.php';
require_once BASE_PATH . '/modeles/Mouvement.php';
require_once BASE_PATH . '/modeles/Fournisseur.php';

class DashboardController
{
    private $produitModel;
    private $mouvementModel;
    private $fournisseurModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->produitModel     = new Produit();
        $this->mouvementModel   = new Mouvement();
        $this->fournisseurModel = new Fournisseur();
    }

    public function index()
    {
        $pageTitle = "Tableau de Bord";

        // Récupération des produits en alerte avec flag commande_en_cours
        $produitsEnAlerte    = $this->produitModel->getProduitsEnAlerte();
        $totalProduits       = count($this->produitModel->getAll());
        $nbAlertes           = count($produitsEnAlerte);
        $nbAlertesAvecCmd    = count(array_filter($produitsEnAlerte, fn($p) => $p['commande_en_cours']));
        $nbAlertesSansCmd    = $nbAlertes - $nbAlertesAvecCmd;

        // Alias pour la vue (compatibilité avec le template dashboard existant)
        $produits  = $produitsEnAlerte;
        $ruptures  = $nbAlertes;
        $fournisseurs = count($this->fournisseurModel->getAll());

        ob_start();
        require_once BASE_PATH . '/vues/dashboard/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }
}
?>