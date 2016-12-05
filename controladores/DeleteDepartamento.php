<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

     $deleteDepartamento = $con->prepare("DELETE FROM departamento where id = '".$_POST['id']."' ");
     $deleteDepartamento->execute();

     $deleteCategoria = $con->prepare("DELETE FROM categorias_departamento where idDepartamento = '".$_POST['id']."' ");
     $deleteCategoria->execute();

     echo 1;

?>
