<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

if ($_POST['tipo'] != "agregar") {

  $habilitado = $con->prepare("UPDATE categorias_departamento set habilitado = 0 WHERE id = '".$_POST['id']."' ");
  $habilitado->execute();

  echo 1;

} else {

  $habilitado = $con->prepare("UPDATE categorias_departamento set habilitado = 1 WHERE id = '".$_POST['id']."'  ");
  $habilitado->execute();

  echo 1;
}


 ?>
