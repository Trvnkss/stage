<?php
require_once __DIR__ . '/Model.php';

class Produit extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'produits';
    }

    public function getAllWithDetails()
    {
        $sql = "SELECT p.*, c.libelle_categ, f.nom_fourni 
                FROM produits p 
                LEFT JOIN categ_produits c ON p.id_categ = c.id_categ 
                LEFT JOIN fournisseurs f ON p.id_fourni = f.id_fourni";
        $requete = $this->db->prepare($sql);
        $requete->execute();
        return $requete->fetchAll();
    }

    public function create($nom_prod, $unite, $stock_initial, $seuil_alerte, $id_categ, $id_fourni)
    {
        $sql = "INSERT INTO produits (nom_prod, unite, stock_initial, seuil_alerte, id_categ, id_fourni) 
                VALUES (:nom, :unite, :stock, :seuil, :categ, :fourni)";
        $requete = $this->db->prepare($sql);
        $requete->bindParam(':nom', $nom_prod);
        $requete->bindParam(':unite', $unite);
        $requete->bindParam(':stock', $stock_initial);
        $requete->bindParam(':seuil', $seuil_alerte);
        $requete->bindParam(':categ', $id_categ);
        $requete->bindParam(':fourni', $id_fourni);
        return $requete->execute();
    }

    public function update($id_prod, $nom_prod, $unite, $stock_initial, $seuil_alerte, $id_categ, $id_fourni)
    {
        $sql = "UPDATE produits SET 
                nom_prod = :nom, 
                unite = :unite, 
                stock_initial = :stock, 
                seuil_alerte = :seuil,
                id_categ = :categ, 
                id_fourni = :fourni 
                WHERE id_prod = :id";
        $requete = $this->db->prepare($sql);
        $requete->bindParam(':id', $id_prod);
        $requete->bindParam(':nom', $nom_prod);
        $requete->bindParam(':unite', $unite);
        $requete->bindParam(':stock', $stock_initial);
        $requete->bindParam(':seuil', $seuil_alerte);
        $requete->bindParam(':categ', $id_categ);
        $requete->bindParam(':fourni', $id_fourni);
        return $requete->execute();
    }

    public function getStockActuel($id_prod)
    {
        $produit = $this->getById($id_prod, 'id_prod');
        if (!$produit)
            return 0;

        $sqlEntrees = "SELECT SUM(qte_mouv) as total FROM mouvements m 
                       JOIN type_mouvements tm ON m.id_type_mouvement = tm.id_type_mouvement 
                       WHERE m.id_prod = :id AND tm.libelle_type_mouvement = 'Entrée'";
        $requeteEntrees = $this->db->prepare($sqlEntrees);
        $requeteEntrees->bindParam(':id', $id_prod);
        $requeteEntrees->execute();
        $entrees = $requeteEntrees->fetch()['total'] ?? 0;

        $sqlSorties = "SELECT SUM(qte_mouv) as total FROM mouvements m 
                       JOIN type_mouvements tm ON m.id_type_mouvement = tm.id_type_mouvement 
                       WHERE m.id_prod = :id AND tm.libelle_type_mouvement = 'Sortie'";
        $requeteSorties = $this->db->prepare($sqlSorties);
        $requeteSorties->bindParam(':id', $id_prod);
        $requeteSorties->execute();
        $sorties = $requeteSorties->fetch()['total'] ?? 0;

        return $produit['stock_initial'] + $entrees - $sorties;
    }

    public function getStockAttendu($id_prod)
    {
        $stockActuel = $this->getStockActuel($id_prod);

        $sqlCmd = "SELECT SUM(quantite) as total FROM commandes 
                   WHERE id_prod = :id AND statut = 'En attente'";
        $requete = $this->db->prepare($sqlCmd);
        $requete->bindParam(':id', $id_prod);
        $requete->execute();
        $enAttente = $requete->fetch()['total'] ?? 0;

        return $stockActuel + $enAttente;
    }

    /**
     * Retourne tous les produits dont le stock actuel <= seuil_alerte,
     * enrichis avec : stock_actuel, stock_attendu, commande_en_cours.
     * 
     * commande_en_cours = TRUE si une commande "En attente" couvre le seuil
     *   → produit en alerte MAIS commande passée (affichage orange)
     * commande_en_cours = FALSE → alerte pure (affichage rouge)
     */
    public function getProduitsEnAlerte()
    {
        $tousProduits = $this->getAllWithDetails();
        $produitsEnAlerte = [];

        foreach ($tousProduits as $produit) {
            $stockActuel = $this->getStockActuel($produit['id_prod']);
            $seuilAlerte = $produit['seuil_alerte'] ?? 5;

            if ($stockActuel <= $seuilAlerte) {
                $stockAttendu = $this->getStockAttendu($produit['id_prod']);
                $produit['stock_actuel']       = $stockActuel;
                $produit['stock_attendu']      = $stockAttendu;
                // Commande en cours ET elle suffira à couvrir le seuil
                $produit['commande_en_cours']  = ($stockAttendu > $seuilAlerte);
                $produitsEnAlerte[] = $produit;
            }
        }

        return $produitsEnAlerte;
    }
}
?>