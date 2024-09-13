<?php
require_once 'Database.php';

class Usuario extends Database
{
    private $table = "usuarios";

    // Obtener un usuario por su nombre de usuario
    public function getUsuarioPorNombre($nombre_usuario)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE nombre = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc(); // Devolver la fila del usuario
        } else {
            return null; // No existe el usuario
        }
    }
}
