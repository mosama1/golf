<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

     $deleteCategoria = $con->prepare("DELETE FROM categorias_departamento where id = '".$_POST['id']."' ");
     $deleteCategoria->execute();

     echo 1;

?>
