<?php
require_once __DIR__ . '/Model.php';

class Fournisseur extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'fournisseurs';
    }

    public function create($nom_fourni, $tel_fourni, $rue_fourni, $cp_fourni, $ville_fourni)
    {
        $sql = "INSERT INTO fournisseurs (nom_fourni, tel_fourni, rue_fourni, cp_fourni, ville_fourni) 
                VALUES (:nom, :tel, :rue, :cp, :ville)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nom', $nom_fourni);
        $stmt->bindParam(':tel', $tel_fourni);
        $stmt->bindParam(':rue', $rue_fourni);
        $stmt->bindParam(':cp', $cp_fourni);
        $stmt->bindParam(':ville', $ville_fourni);
        return $stmt->execute();
    }

    public function update($id_fourni, $nom_fourni, $tel_fourni, $rue_fourni, $cp_fourni, $ville_fourni)
    {
        $sql = "UPDATE fournisseurs SET 
                nom_fourni = :nom, 
                tel_fourni = :tel, 
                rue_fourni = :rue, 
                cp_fourni = :cp, 
                ville_fourni = :ville 
                WHERE id_fourni = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_fourni);
        $stmt->bindParam(':nom', $nom_fourni);
        $stmt->bindParam(':tel', $tel_fourni);
        $stmt->bindParam(':rue', $rue_fourni);
        $stmt->bindParam(':cp', $cp_fourni);
        $stmt->bindParam(':ville', $ville_fourni);
        return $stmt->execute();
    }
}
?>