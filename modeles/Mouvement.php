<?php
require_once __DIR__ . '/Model.php';

class Mouvement extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'mouvements';
    }

    public function getAllWithDetails($id_prod = null)
    {
        $sql = "SELECT m.*, p.nom_prod, tm.libelle_type_mouvement, u.nom as nom_utilisateur 
                FROM mouvements m 
                JOIN produits p ON m.id_prod = p.id_prod
                JOIN type_mouvements tm ON m.id_type_mouvement = tm.id_type_mouvement
                JOIN utilisateurs u ON m.id_utilisateur = u.id_utilisateur";

        if ($id_prod) {
            $sql .= " WHERE m.id_prod = :id_prod";
        }

        $sql .= " ORDER BY m.date_mouv DESC";
        $stmt = $this->db->prepare($sql);

        if ($id_prod) {
            $stmt->bindParam(':id_prod', $id_prod);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getEntreesWithFournisseur($id_prod)
    {
        $sql = "SELECT m.date_mouv, m.qte_mouv, f.nom_fourni, p.nom_prod 
                FROM mouvements m 
                JOIN produits p ON m.id_prod = p.id_prod
                JOIN fournisseurs f ON p.id_fourni = f.id_fourni
                JOIN type_mouvements tm ON m.id_type_mouvement = tm.id_type_mouvement
                WHERE m.id_prod = :id_prod AND tm.libelle_type_mouvement = 'Entrée'
                ORDER BY m.date_mouv DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_prod', $id_prod);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($qte_mouv, $id_prod, $id_type_mouvement, $id_utilisateur)
    {
        $sql = "INSERT INTO mouvements (qte_mouv, date_mouv, id_prod, id_type_mouvement, id_utilisateur) 
                VALUES (:qte, NOW(), :prod, :type_m, :user)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':qte', $qte_mouv);
        $stmt->bindParam(':prod', $id_prod);
        $stmt->bindParam(':type_m', $id_type_mouvement);
        $stmt->bindParam(':user', $id_utilisateur);
        return $stmt->execute();
    }
}
?>