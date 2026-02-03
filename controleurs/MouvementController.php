<?php
require_once BASE_PATH . '/modeles/Mouvement.php';
require_once BASE_PATH . '/modeles/Produit.php';
require_once BASE_PATH . '/modeles/TypeMouvement.php';

class MouvementController
{
    private $mouvementModel;
    private $produitModel;
    private $typeMouvementModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->mouvementModel = new Mouvement();
        $this->produitModel = new Produit();
        $this->typeMouvementModel = new TypeMouvement();
    }

    public function index()
    {
        $pageTitle = "Historique des Mouvements de Stock";
        $id_prod = $_GET['id_prod'] ?? null;
        $mouvements = $this->mouvementModel->getAllWithDetails($id_prod);

        ob_start();
        require_once BASE_PATH . '/vues/mouvements/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function create()
    {
        $pageTitle = "Enregistrer un Mouvement";

        $produits = $this->produitModel->getAll();
        $typesMouvement = $this->typeMouvementModel->getAll();

        ob_start();
        require_once BASE_PATH . '/vues/mouvements/create.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_prod = $_POST['id_prod'] ?? null;
            $id_type_mouvement = $_POST['id_type_mouvement'] ?? null;
            $qte_mouv = $_POST['qte_mouv'] ?? 0;
            $id_utilisateur = $_SESSION['user_id']; // L'utilisateur actuellement connecté

            // Validation de base des champs du formulaire
            if (!$id_prod || !$id_type_mouvement || $qte_mouv <= 0) {
                $_SESSION['error'] = "Veuillez remplir tous les champs correctement.";
                header('Location: ' . BASE_URL . '/index.php?controleur=mouvement&action=create');
                exit();
            }

            // Vérifier si le stock est suffisant pour une 'Sortie'
            $typeMouvement = $this->typeMouvementModel->getById($id_type_mouvement, 'id_type_mouvement');
            if ($typeMouvement && $typeMouvement['libelle_type_mouvement'] === 'Sortie') {
                $stockActuel = $this->produitModel->getStockActuel($id_prod);
                if ($qte_mouv > $stockActuel) {
                    $_SESSION['error'] = "Pas assez de stock.";
                    header('Location: ' . BASE_URL . '/index.php?controleur=mouvement&action=create');
                    exit();
                }
            }

            if ($this->mouvementModel->create($qte_mouv, $id_prod, $id_type_mouvement, $id_utilisateur)) {
                $_SESSION['success'] = "Mouvement de stock enregistré avec succès.";
                header('Location: ' . BASE_URL . '/index.php?controleur=mouvement&action=index');
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de l'enregistrement du mouvement.";
                header('Location: ' . BASE_URL . '/index.php?controleur=mouvement&action=create');
                exit();
            }
        }
    }
}
?>