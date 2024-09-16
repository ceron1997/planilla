<?php
require_once 'Database.php';

class DescuentosFijos extends Database
{
    private $table = "descuentos_fijos";

    // Obtener el porcentaje de un descuento dado (ISSS o AFP)
    public function obtenerPorcentaje($nombreDescuento)
    {
        $sql = "SELECT porcentaje FROM " . $this->table . " WHERE nombre = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nombreDescuento);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Calcular el descuento de ISSS basado en el salario
    public function calcularISSS($salario)
    {
        $isss = $this->obtenerPorcentaje('ISSS');
        if ($isss) {
            return $salario * $isss['porcentaje'];
        }
        return 0;
    }

    // Calcular el descuento de AFP basado en el salario
    public function calcularAFP($salario)
    {
        $afp = $this->obtenerPorcentaje('AFP');
        if ($afp) {
            return $salario * $afp['porcentaje'];
        }
        return 0;
    }
}
