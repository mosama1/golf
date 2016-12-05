<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

if ($_POST['tipo'] != "procesar") {

  $habilitado = $con->prepare("UPDATE reserva set procesado = 2, detalle = '".$_POST['detalle']."' WHERE id = '".$_POST['id']."' ");
  $habilitado->execute();

  $habilitado = $con->prepare("UPDATE desc_reserva set procesado = 2 WHERE idReserva = '".$_POST['id']."'  ");
  $habilitado->execute();

  echo 1;

} else {

  $habilitado = $con->prepare("UPDATE reserva set procesado = 1 WHERE id = '".$_POST['id']."'  ");
  $habilitado->execute();

  $habilitado = $con->prepare("UPDATE desc_reserva set procesado = 1 WHERE idReserva = '".$_POST['id']."'  ");
  $habilitado->execute();

  echo 1;
}


 ?>
