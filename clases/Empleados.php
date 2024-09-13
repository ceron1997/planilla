<?php
require_once 'Database.php';
class Empleado extends Database
{
    private $table = "empleados";

    // Obtener un empleado por su nombre de usuario
    public function getEmpleadoPorNombre($nombre) {}


    public function obtenerTodosLosEmpleados($where = null)
    {
        $sql = "SELECT * FROM " . $this->table;
        if ($where) {
            $sql .= " WHERE " . $where;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $empleados = [];
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }

        return $empleados;
    }

    


    public function guardarEmpleado($nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio)
    {
        $sql = "INSERT INTO " . $this->table . " (nombres, apellidos, salario, fecha_ingreso, id_departamento, id_municipio) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdsii", $nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio);
        
        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            return false; // Error
        }
    }

    public function actualizarEmpleado($id_empleado, $nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio) {
        $sql = "UPDATE empleados
                SET nombres = ?, apellidos = ?, salario = ?, fecha_ingreso = ?, id_departamento = ?, id_municipio = ?
                WHERE id_empleado = ?";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdsiii", $nombres, $apellidos, $salario, $fecha_ingreso, $id_departamento, $id_municipio, $id_empleado);
    
        return $stmt->execute();
    }
    public function eliminarEmpleado($id_empleado) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE id_empleado = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id_empleado);
            
            // Ejecutar la sentencia
            if ($stmt->execute()) {
                return true; //  exitosa
            } else {
                return false; //  problema
            }
        } catch (mysqli_sql_exception $e) {
            // Manejo de excepciones en caso de error
            echo "Error al eliminar el empleado: " . $e->getMessage();
            return false;
        }
    }
}
