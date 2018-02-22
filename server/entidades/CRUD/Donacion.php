<?php
class Donacion
{
   public $id;
   public $nombreDonante;
   public $correoElectronicoDonante;
   public $idImplemento;
   public $cantidad;

   function __construct($id,$nombreDonante,$correoElectronicoDonante,$idImplemento,$cantidad){
      $this->id = $id;
      $this->nombreDonante = $nombreDonante;
      $this->correoElectronicoDonante = $correoElectronicoDonante;
      $this->idImplemento = $idImplemento;
      $this->cantidad = $cantidad;
   }
}
?>