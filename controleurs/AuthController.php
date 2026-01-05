<?php
require_once BASE_PATH . '/modeles/Utilisateur.php';

class AuthController
{
    private $utilisateurModel;

    public function __construct()
    {
        $this->utilisateurModel = new Utilisateur();
    }

    public function login()
    {
        // Si l'utilisateur est déjà connecté, on le redirige directement vers le tableau de bord
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?controleur=dashboard&action=index');
            exit();
        }

        // Afficher la vue de connexion
        require_once BASE_PATH . '/vues/auth/login.php';
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifiant = $_POST['login'] ?? '';
            $motDePasse = $_POST['password'] ?? '';

            if (empty($identifiant) || empty($motDePasse)) {
                $erreur = "Veuillez remplir tous les champs.";
                require_once BASE_PATH . '/vues/auth/login.php';
                return;
            }

            $utilisateur = $this->utilisateurModel->login($identifiant, $motDePasse);

            if ($utilisateur) {
                // Définition des variables de session de l'utilisateur
                $_SESSION['user_id'] = $utilisateur['id_utilisateur'];
                $_SESSION['user_nom'] = $utilisateur['nom'];
                $_SESSION['user_role'] = $utilisateur['libelle_role'];
                $_SESSION['user_login'] = $utilisateur['login'];

                header('Location: ' . BASE_URL . '/index.php?controleur=dashboard&action=index');
                exit();
            } else {
                $erreur = "Identifiants incorrects.";
                require_once BASE_PATH . '/vues/auth/login.php';
            }
        } else {
            // Ce n'est pas une requête POST, on renvoie à la connexion
            header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
            exit();
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/index.php?controleur=auth&action=login');
        exit();
    }
}
?>