<?php
require_once __DIR__ . '/Model.php';

class Utilisateur extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'comptes';
    }

    public function login($login, $password)
    {
        $sql = "SELECT c.*, u.nom, u.email, r.libelle_role 
                FROM comptes c 
                JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                JOIN role r ON c.id_role = r.id_role
                WHERE c.login = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }
}
?>