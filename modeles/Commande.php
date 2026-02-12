<?php
require_once __DIR__ . '/Model.php';

class Commande extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'commandes';
    }

    public function getAllWithDetails()
    {
        $sql = "SELECT c.*, p.nom_prod, f.nom_fourni, u.nom as nom_utilisateur 
                FROM commandes c 
                JOIN produits p ON c.id_prod = p.id_prod
                JOIN fournisseurs f ON c.id_fourni = f.id_fourni
                JOIN utilisateurs u ON c.id_utilisateur = u.id_utilisateur
                ORDER BY c.date_commande DESC";
        $requete = $this->db->prepare($sql);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function create($quantite, $id_prod, $id_fourni, $id_utilisateur)
    {
        $sql = "INSERT INTO commandes (date_commande, quantite, id_prod, id_fourni, id_utilisateur, statut) 
                VALUES (NOW(), :qte, :prod, :fourni, :user, 'En attente')";
        $requete = $this->db->prepare($sql);
        $requete->bindParam(':qte', $quantite);
        $requete->bindParam(':prod', $id_prod);
        $requete->bindParam(':fourni', $id_fourni);
        $requete->bindParam(':user', $id_utilisateur);
        return $requete->execute();
    }

    public function updateStatut($id_commande, $statut)
    {
        $sql = "UPDATE commandes SET statut = :statut WHERE id_commande = :id";
        $requete = $this->db->prepare($sql);
        $requete->bindParam(':statut', $statut);
        $requete->bindParam(':id', $id_commande);
        return $requete->execute();
    }

    /**
     * Retourne TRUE si une commande "En attente" existe pour ce produit
     * et que la quantité commandée fera repasser le stock au-dessus du seuil.
     */
    public function aCommandeCouvrantAlerte($id_prod, $stock_actuel, $seuil_alerte)
    {
        $sql = "SELECT SUM(quantite) as total_attendu FROM commandes 
                WHERE id_prod = :id AND statut = 'En attente'";
        $requete = $this->db->prepare($sql);
        $requete->bindParam(':id', $id_prod);
        $requete->execute();
        $totalAttendu = $requete->fetch()['total_attendu'] ?? 0;
        return ($stock_actuel + $totalAttendu) > $seuil_alerte;
    }
}
?>