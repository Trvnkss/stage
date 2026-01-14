<?php
require_once __DIR__ . '/Model.php';

class Categorie extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'categ_produits';
    }
}
?>