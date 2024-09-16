<?php
require_once 'Database.php';

class Municipio extends Database
{
    private $table = "municipios";

   
    public function getAll($where = null)
    {
        $sql = "SELECT * FROM " . $this->table;

        // Añadir condición WHERE si existe
        if ($where) {
            $sql .= " WHERE " . $where;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $municipios = [];
        while ($row = $result->fetch_assoc()) {
            $municipios[] = $row;
        }

        return $municipios;
    }
}
?>
