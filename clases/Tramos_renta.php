<?php
require_once 'Database.php';

class Tramos_renta extends Database
{
    private $table = "tramos_renta";


     // Obtener el tramo de renta para un salario dado
     public function obtenerTramoRenta($salario)
     {
         $sql = "SELECT * FROM ".$this->table . " WHERE tramo_desde <= ? AND tramo_hasta >= ? LIMIT 1";
         $stmt = $this->conn->prepare($sql);
         $stmt->bind_param("dd", $salario, $salario);
         $stmt->execute();
         $result = $stmt->get_result();
         return $result->fetch_assoc();
     }
 
     // Calcular la renta usando los datos de la tabla
     public function calcularRenta($salario)
     {
         $tramo = $this->obtenerTramoRenta($salario);
 
         if ($tramo) {
             $exceso = $salario - $tramo['tramo_desde'];
             $renta = ($exceso * ($tramo['porcentaje_exceso'] / 100)) + $tramo['cuota_fija'];
             return $renta;
         }
 
         return 0; // Si no hay un tramo que corresponda, retorna 0
     }

     function obtenerTramosRenta(){

        $sql = "select * from tramos_renta"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();


     }
}
