<?php
require_once BASE_PATH . '/modeles/Fournisseur.php';

class FournisseurController
{
    private $fournisseurModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }

        $this->fournisseurModel = new Fournisseur();
    }

    public function index()
    {
        $pageTitle = "Gestion des Fournisseurs";
        $fournisseurs = $this->fournisseurModel->getAll();

        ob_start();
        require_once BASE_PATH . '/vues/fournisseurs/index.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function create()
    {
        $pageTitle = "Ajouter un Fournisseur";

        ob_start();
        require_once BASE_PATH . '/vues/fournisseurs/create.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_fourni = $_POST['nom_fourni'] ?? '';
            $tel_fourni = $_POST['tel_fourni'] ?? '';
            $rue_fourni = $_POST['rue_fourni'] ?? '';
            $cp_fourni = $_POST['cp_fourni'] ?? '';
            $ville_fourni = $_POST['ville_fourni'] ?? '';

            if ($this->fournisseurModel->create($nom_fourni, $tel_fourni, $rue_fourni, $cp_fourni, $ville_fourni)) {
                $_SESSION['success'] = "Fournisseur ajouté avec succès.";
                header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du fournisseur.";
                header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=create');
                exit();
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
            exit();
        }

        $fournisseur = $this->fournisseurModel->getById($id, 'id_fourni');
        if (!$fournisseur) {
            $_SESSION['error'] = "Fournisseur introuvable.";
            header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
            exit();
        }

        $pageTitle = "Modifier un Fournisseur";

        ob_start();
        require_once BASE_PATH . '/vues/fournisseurs/edit.php';
        $content = ob_get_clean();

        global $controllerName;
        require_once BASE_PATH . '/vues/layout.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;
            $nom_fourni = $_POST['nom_fourni'] ?? '';
            $tel_fourni = $_POST['tel_fourni'] ?? '';
            $rue_fourni = $_POST['rue_fourni'] ?? '';
            $cp_fourni = $_POST['cp_fourni'] ?? '';
            $ville_fourni = $_POST['ville_fourni'] ?? '';

            if (!$id || empty($nom_fourni)) {
                $_SESSION['error'] = "Données invalides pour la mise à jour.";
                header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
                exit();
            }

            if ($this->fournisseurModel->update($id, $nom_fourni, $tel_fourni, $rue_fourni, $cp_fourni, $ville_fourni)) {
                $_SESSION['success'] = "Fournisseur mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour.";
            }
            header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            // Vérifier s'il y a des produits liés
            require_once BASE_PATH . '/config/database.php';
            $db = Database::getInstance()->getConnection();
            $stmtCheck = $db->prepare("SELECT COUNT(*) as count FROM produits WHERE id_fourni = :id");
            $stmtCheck->bindParam(':id', $id);
            $stmtCheck->execute();
            $hasProducts = $stmtCheck->fetch()['count'] > 0;

            if ($hasProducts) {
                $_SESSION['error'] = "Impossible de supprimer ce fournisseur car des produits y sont associés.";
            } else {
                if ($this->fournisseurModel->delete($id, 'id_fourni')) {
                    $_SESSION['success'] = "Fournisseur supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression.";
                }
            }
        }
        header('Location: ' . BASE_URL . '/index.php?controleur=fournisseur&action=index');
        exit();
    }
}
?>