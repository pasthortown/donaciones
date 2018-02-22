<?php
class Implemento
{
   public $id;
   public $nombre;
   public $descripcion;
   public $cantidad;

   function __construct($id,$nombre,$descripcion,$cantidad){
      $this->id = $id;
      $this->nombre = $nombre;
      $this->descripcion = $descripcion;
      $this->cantidad = $cantidad;
   }
}
?>