<?php
require_once __DIR__ . '/Model.php';

class TypeMouvement extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'type_mouvements';
    }
}
?>