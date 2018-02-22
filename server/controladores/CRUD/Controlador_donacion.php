<?php
include_once('../controladores/Controlador_Base.php');
include_once('../entidades/CRUD/Donacion.php');
class Controlador_donacion extends Controlador_Base
{
   function crear($args)
   {
      $donacion = new Donacion($args["id"],$args["nombreDonante"],$args["correoElectronicoDonante"],$args["idImplemento"],$args["cantidad"]);
      $sql = "INSERT INTO Donacion (nombreDonante,correoElectronicoDonante,idImplemento,cantidad) VALUES (?,?,?,?);";
      $parametros = array($donacion->nombreDonante,$donacion->correoElectronicoDonante,$donacion->idImplemento,$donacion->cantidad);
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      if(is_null($respuesta[0])){
         return true;
      }else{
         return false;
      }
   }

   function actualizar($args)
   {
      $donacion = new Donacion($args["id"],$args["nombreDonante"],$args["correoElectronicoDonante"],$args["idImplemento"],$args["cantidad"]);
      $parametros = array($donacion->nombreDonante,$donacion->correoElectronicoDonante,$donacion->idImplemento,$donacion->cantidad,$donacion->id);
      $sql = "UPDATE Donacion SET nombreDonante = ?,correoElectronicoDonante = ?,idImplemento = ?,cantidad = ? WHERE id = ?;";
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      if(is_null($respuesta[0])){
         return true;
      }else{
         return false;
      }
   }

   function borrar($args)
   {
      $id = $args["id"];
      $parametros = array($id);
      $sql = "DELETE FROM Donacion WHERE id = ?;";
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      if(is_null($respuesta[0])){
         return true;
      }else{
         return false;
      }
   }

   function leer($args)
   {
      $id = $args["id"];
      if ($id==""){
         $sql = "SELECT * FROM Donacion;";
      }else{
      $parametros = array($id);
         $sql = "SELECT * FROM Donacion WHERE id = ?;";
      }
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      return $respuesta;
   }

   function leer_paginado($args)
   {
      $pagina = $args["pagina"];
      $registrosPorPagina = $args["registros_por_pagina"];
      $desde = (($pagina-1)*$registrosPorPagina);
      $sql ="SELECT * FROM Donacion LIMIT $desde,$registrosPorPagina;";
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      return $respuesta;
   }

   function numero_paginas($args)
   {
      $registrosPorPagina = $args["registros_por_pagina"];
      $sql ="SELECT IF(ceil(count(*)/$registrosPorPagina)>0,ceil(count(*)/$registrosPorPagina),1) as 'paginas' FROM Donacion;";
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      return $respuesta[0];
   }

   function leer_filtrado($args)
   {
      $nombreColumna = $args["columna"];
      $tipoFiltro = $args["tipo_filtro"];
      $filtro = $args["filtro"];
      switch ($tipoFiltro){
         case "coincide":
            $parametros = array($filtro);
            $sql = "SELECT * FROM Donacion WHERE $nombreColumna = ?;";
            break;
         case "inicia":
            $sql = "SELECT * FROM Donacion WHERE $nombreColumna LIKE '$filtro%';";
            break;
         case "termina":
            $sql = "SELECT * FROM Donacion WHERE $nombreColumna LIKE '%$filtro';";
            break;
         default:
            $sql = "SELECT * FROM Donacion WHERE $nombreColumna LIKE '%$filtro%';";
            break;
      }
      $respuesta = $this->conexion->ejecutarConsulta($sql,$parametros);
      return $respuesta;
   }
}