<?php
require_once 'Database.php';

class Municipio extends Database
{
    private $table = "municipios";

    // Obtener todos los registros de la tabla departamentos
    public function getAll($where = null)
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
        $municipios = [];
        while ($row = $result->fetch_assoc()) {
            $municipios[] = $row;
        }

        // Retornar los departamentos
        return $municipios;
    }
}
?>
