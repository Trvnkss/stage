<?php
require_once BASE_PATH . '/modeles/Produit.php';
require_once BASE_PATH . '/modeles/Categorie.php';
require_once BASE_PATH . '/modeles/Fournisseur.php';
require_once BASE_PATH . '/modeles/Mouvement.php';

class ProduitController
{
    private $produitModel;
    private $categorieModel;
    private $fournisseurModel;
    private $mouvementModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->produitModel = new Produit();
        $this->categorieModel = new Categorie();
        $this->fournisseurModel = new Fournisseur();
        $this->mouvementModel = new Mouvement();
    }

    public function index()
    {
        $pageTitle = "Gestion des Produits";
        $produits = $this->produitModel->getAllWithDetails();

        // Calcul en temps réel du stock pour chaque produit + flag commande_en_cours
        foreach ($produits as &$p) {
            $p['quantite_stock']    = $this->produitModel->getStockActuel($p['id_prod']);
            $p['stock_attendu']     = $this->produitModel->getStockAttendu($p['id_prod']);
            $p['seuil_alerte']      = $p['seuil_alerte'] ?? 5;
            // TRUE si une commande en attente fera repasser le stock au-dessus du seuil
            $p['commande_en_cours'] = ($p['quantite_stock'] <= $p['seuil_alerte'])
                                      && ($p['stock_attendu'] > $p['seuil_alerte']);
        }
        unset($p);

        ob_start();
        require_once BASE_PATH . '/vues/produits/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function create()
    {
        $pageTitle = "Ajouter un Produit";

        $categories = $this->categorieModel->getAll();
        $fournisseurs = $this->fournisseurModel->getAll();

        ob_start();
        require_once BASE_PATH . '/vues/produits/create.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_prod = $_POST['nom_prod'] ?? '';
            $unite = $_POST['unite'] ?? '';
            $stock_initial = $_POST['stock_initial'] ?? 0;
            $seuil_alerte = $_POST['seuil_alerte'] ?? 5;
            $id_categ = $_POST['id_categ'] ?? null;
            $id_fourni = $_POST['id_fourni'] ?? null;

            if ($stock_initial < 0 || $seuil_alerte < 0) {
                $_SESSION['error'] = "Le stock initial et le seuil d'alerte ne peuvent pas être négatifs.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=create');
                exit();
            }

            $unitesValides = ['Pièces', 'Kg', 'Litres'];
            if (!in_array($unite, $unitesValides)) {
                $_SESSION['error'] = "Veuillez sélectionner une unité de mesure valide.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=create');
                exit();
            }

            if ($this->produitModel->create($nom_prod, $unite, $stock_initial, $seuil_alerte, $id_categ, $id_fourni)) {
                $_SESSION['success'] = "Produit ajouté avec succès.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du produit.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=create');
                exit();
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
            exit();
        }

        $produit = $this->produitModel->getById($id, 'id_prod');
        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
            exit();
        }

        $pageTitle = "Modifier un Produit";
        $categories = $this->categorieModel->getAll();
        $fournisseurs = $this->fournisseurModel->getAll();

        ob_start();
        require_once BASE_PATH . '/vues/produits/edit.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;
            $nom_prod = $_POST['nom_prod'] ?? '';
            $unite = $_POST['unite'] ?? '';
            $stock_initial = $_POST['stock_initial'] ?? 0;
            $seuil_alerte = $_POST['seuil_alerte'] ?? 5;
            $id_categ = $_POST['id_categ'] ?? null;
            $id_fourni = $_POST['id_fourni'] ?? null;

            if ($stock_initial < 0 || $seuil_alerte < 0) {
                $_SESSION['error'] = "Le stock initial et le seuil d'alerte ne peuvent pas être négatifs.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=edit&id=' . $id);
                exit();
            }

            $unitesValides = ['Pièces', 'Kg', 'Litres'];
            if (!in_array($unite, $unitesValides)) {
                $_SESSION['error'] = "Veuillez sélectionner une unité de mesure valide.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=edit&id=' . $id);
                exit();
            }

            if (!$id || empty($nom_prod) || !$id_categ || !$id_fourni) {
                $_SESSION['error'] = "Veuillez remplir correctement tous les champs obligatoires.";
                header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
                exit();
            }

            if ($this->produitModel->update($id, $nom_prod, $unite, $stock_initial, $seuil_alerte, $id_categ, $id_fourni)) {
                $_SESSION['success'] = "Produit mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }
            header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Vérifier s'il y a des mouvements de stock avant de supprimer
            require_once BASE_PATH . '/config/database.php';
            $bdd = Database::getInstance()->getConnection();
            $requeteVerif = $bdd->prepare("SELECT COUNT(*) as count FROM mouvements WHERE id_prod = :id");
            $requeteVerif->bindParam(':id', $id);
            $requeteVerif->execute();
            $aMouvements = $requeteVerif->fetch()['count'] > 0;

            if ($aMouvements) {
                $_SESSION['error'] = "Impossible de supprimer ce produit car des mouvements de stock (entrées/sorties) y sont associés.";
            } else {
                if ($this->produitModel->delete($id, 'id_prod')) {
                    $_SESSION['success'] = "Produit supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression du produit.";
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
        exit();
    }

    public function historiqueFournisseurs()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
            exit();
        }

        $produit = $this->produitModel->getById($id, 'id_prod');
        if (!$produit) {
            $_SESSION['error'] = "Produit introuvable.";
            header('Location: ' . BASE_URL . '/index.php?controleur=produit&action=index');
            exit();
        }

        $nom_produit = $produit['nom_prod'];
        $historique = $this->mouvementModel->getEntreesWithFournisseur($id);

        $pageTitle = "Historique Fournisseur - {$nom_produit}";

        ob_start();
        require_once BASE_PATH . '/vues/produits/historique_fournisseurs.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }
}
?>