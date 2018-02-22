<?php
include_once('../controladores/Controlador_Base.php');
class Controlador_promesas extends Controlador_Base
{
   function leer($args)
   {
      $sql = "SELECT Donacion.idImplemento as 'id', Implemento.nombre, sum(Donacion.cantidad) as 'cantidad' FROM Donacion INNER JOIN Implemento ON Donacion.idImplemento = Implemento.id GROUP BY Donacion.idImplemento;";
      $parametros = array();
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      return $respuesta;
   }
}