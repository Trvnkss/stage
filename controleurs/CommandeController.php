<?php
require_once BASE_PATH . '/modeles/Commande.php';
require_once BASE_PATH . '/modeles/Produit.php';
require_once BASE_PATH . '/modeles/Fournisseur.php';
require_once BASE_PATH . '/modeles/Mouvement.php';
require_once BASE_PATH . '/modeles/TypeMouvement.php';

class CommandeController
{
    private $commandeModel;
    private $produitModel;
    private $fournisseurModel;
    private $mouvementModel;
    private $typeMouvementModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->commandeModel      = new Commande();
        $this->produitModel       = new Produit();
        $this->fournisseurModel   = new Fournisseur();
        $this->mouvementModel     = new Mouvement();
        $this->typeMouvementModel = new TypeMouvement();
    }

    public function index()
    {
        $pageTitle = "Gestion des Commandes";
        $commandes = $this->commandeModel->getAllWithDetails();

        ob_start();
        require_once BASE_PATH . '/vues/commandes/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function create()
    {
        $pageTitle = "Passer une Commande";

        // Tous les produits + produits en alerte pour mise en avant
        $produits         = $this->produitModel->getAllWithDetails();
        $fournisseurs     = $this->fournisseurModel->getAll();
        $produitsEnAlerte = $this->produitModel->getProduitsEnAlerte();
        $idsEnAlerte      = array_column($produitsEnAlerte, 'id_prod');

        ob_start();
        require_once BASE_PATH . '/vues/commandes/create.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_prod      = $_POST['id_prod']   ?? null;
            $quantite     = $_POST['quantite']   ?? 0;
            $id_fourni    = $_POST['id_fourni']  ?? null;
            $id_utilisateur = $_SESSION['user_id'];

            if (!$id_prod || $quantite <= 0 || !$id_fourni) {
                $_SESSION['error'] = "Veuillez remplir correctement tous les champs.";
                header('Location: ' . BASE_URL . '/index.php?controleur=commande&action=create');
                exit();
            }

            if ($this->commandeModel->create($quantite, $id_prod, $id_fourni, $id_utilisateur)) {
                $_SESSION['success'] = "Commande passée avec succès. Elle est en attente de livraison.";
                header('Location: ' . BASE_URL . '/index.php?controleur=commande&action=index');
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de la création de la commande.";
                header('Location: ' . BASE_URL . '/index.php?controleur=commande&action=create');
                exit();
            }
        }
    }

    public function recevoir()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $commande = $this->commandeModel->getById($id, 'id_commande');
            if ($commande && $commande['statut'] === 'En attente') {
                // Mettre à jour le statut
                $this->commandeModel->updateStatut($id, 'Reçue');

                // Trouver l'ID du type de mouvement "Entrée"
                $types = $this->typeMouvementModel->getAll();
                $idTypeEntree = null;
                foreach ($types as $type) {
                    if (strtolower($type['libelle_type_mouvement']) === 'entrée' || strtolower($type['libelle_type_mouvement']) === 'entree') {
                        $idTypeEntree = $type['id_type_mouvement'];
                        break;
                    }
                }

                // Enregistrer l'entrée en stock
                if ($idTypeEntree) {
                    $this->mouvementModel->create($commande['quantite'], $commande['id_prod'], $idTypeEntree, $_SESSION['user_id']);
                    $_SESSION['success'] = "Commande marquée comme Reçue. Le stock réel a été mis à jour automatiquement.";
                } else {
                    $_SESSION['error'] = "Commande reçue, mais impossible de trouver le type 'Entrée' pour mettre à jour le stock.";
                }
            } else {
                $_SESSION['error'] = "Commande impossible à réceptionner (introuvable ou déjà traitée).";
            }
        }
        header('Location: ' . BASE_URL . '/index.php?controleur=commande&action=index');
        exit();
    }

    public function annuler()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $commande = $this->commandeModel->getById($id, 'id_commande');
            if ($commande && $commande['statut'] === 'En attente') {
                $this->commandeModel->updateStatut($id, 'Annulée');
                $_SESSION['success'] = "Commande annulée avec succès.";
            } else {
                $_SESSION['error'] = "Impossible d'annuler cette commande.";
            }
        }
        header('Location: ' . BASE_URL . '/index.php?controleur=commande&action=index');
        exit();
    }
}
?>