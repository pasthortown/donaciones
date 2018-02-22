<?php
class Donante
{
   public $id;
   public $nombre;
   public $correoElectronico;

   function __construct($id,$nombre,$correoElectronico){
      $this->id = $id;
      $this->nombre = $nombre;
      $this->correoElectronico = $correoElectronico;
   }
}
?>