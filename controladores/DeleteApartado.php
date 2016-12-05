<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

     $deleteApartado = $con->prepare("DELETE FROM apartado where iduser = '".$_POST['idUser']."' ");
     $deleteApartado->execute();

?>
