<?php
require_once __DIR__ . '/../config/database.php';

abstract class Model
{
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id, $pk)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$pk} = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function delete($id, $pk)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$pk} = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>