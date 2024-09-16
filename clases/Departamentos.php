<?php
require_once 'Database.php';

class Departamento extends Database
{
    private $table = "departamentos";

   
    public function obtenerTodosLosDepartamentos($where = null)
    {
       
        $sql = "SELECT * FROM " . $this->table;

        // Añadir condición WHERE si existe
        if ($where) {
            $sql .= " WHERE " . $where;
        }


        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

   
        $departamentos = [];
        while ($row = $result->fetch_assoc()) {
            $departamentos[] = $row;
        }

        return $departamentos;
    }
}
?>
