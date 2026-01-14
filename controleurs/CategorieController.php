<?php
require_once BASE_PATH . '/modeles/Categorie.php';

class CategorieController
{
    private $categorieModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->categorieModel = new Categorie();
    }

    public function index()
    {
        $pageTitle = "Gestion des Catégories";
        $categories = $this->categorieModel->getAll();

        ob_start();
        require_once BASE_PATH . '/vues/categories/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libelle_categ = $_POST['libelle_categ'] ?? '';

            if (empty($libelle_categ)) {
                $_SESSION['error'] = "Le nom de la catégorie ne peut pas être vide.";
                header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
                exit();
            }

            // TypeMouvement n'a pas de méthode create par défaut dans le modèle standard
            // mais nous pouvons utiliser du SQL brut ou ajouter une méthode create.
            // Utilisons simplement la connexion à la base de données depuis le modèle.
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("INSERT INTO categ_produits (libelle_categ) VALUES (:libelle)");
            $stmt->bindParam(':libelle', $libelle_categ);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Catégorie ajoutée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout.";
            }
            header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
            exit();
        }

        $categorie = $this->categorieModel->getById($id, 'id_categ');
        if (!$categorie) {
            $_SESSION['error'] = "Catégorie introuvable.";
            header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
            exit();
        }

        $pageTitle = "Modifier une Catégorie";

        ob_start();
        require_once BASE_PATH . '/vues/categories/edit.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;
            $libelle_categ = $_POST['libelle_categ'] ?? '';

            if (!$id || empty($libelle_categ)) {
                $_SESSION['error'] = "Données invalides pour la mise à jour.";
                header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
                exit();
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("UPDATE categ_produits SET libelle_categ = :libelle WHERE id_categ = :id");
            $stmt->bindParam(':libelle', $libelle_categ);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Catégorie mise à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }
            header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Vérifier s'il y a des produits liés avant de supprimer
            $db = Database::getInstance()->getConnection();
            $stmtCheck = $db->prepare("SELECT COUNT(*) as count FROM produits WHERE id_categ = :id");
            $stmtCheck->bindParam(':id', $id);
            $stmtCheck->execute();
            $hasProducts = $stmtCheck->fetch()['count'] > 0;

            if ($hasProducts) {
                $_SESSION['error'] = "Impossible de supprimer cette catégorie car des produits y sont associés.";
            } else {
                if ($this->categorieModel->delete($id, 'id_categ')) {
                    $_SESSION['success'] = "Catégorie supprimée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression.";
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?controleur=categorie&action=index');
        exit();
    }
}
?>