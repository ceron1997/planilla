<?php
require_once 'Database.php';

class Departamento extends Database
{
    private $table = "departamentos";

    // Obtener todos los registros de la tabla departamentos
    public function obtenerTodosLosDepartamentos($where = null)
    {
        // Consulta base para obtener todos los departamentos
        $sql = "SELECT * FROM " . $this->table;

        // Añadir condición WHERE si existe
        if ($where) {
            $sql .= " WHERE " . $where;
        }


        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        // Arreglo para almacenar los departamentos
        $departamentos = [];
        while ($row = $result->fetch_assoc()) {
            $departamentos[] = $row;
        }

        // Retornar los departamentos
        return $departamentos;
    }
}
?>
