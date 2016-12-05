<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

if ($_POST['tipo'] == 'agregar') {
  $reserva = $con->prepare("INSERT INTO apartado(idDepartamento, idcategoria, nombreCategoria, fecha, hora, precio, idUser)
  VALUES('".$_POST['idDepartamento']."', '".$_POST['idCategoria']."', '".$_POST['nomCategoria']."',
  '".$_POST['fecha']."', '".date("H:i:s", strtotime($_POST['hora']))."', '".$_POST['precio']."', '".$_POST['idUser']."')");
  $reserva->execute();




  // foreach ($apartado as $a) {
  //   echo 'eliminar',',',$a->id,',',$a->nombreCategoria,'/';
  // }

  if ($reserva) {
    $descripcion = $con->prepare("SELECT * FROM apartado where iduser = '".$_POST['idUser']."' and  idcategoria = '".$_POST['idCategoria']."' and idDepartamento = '".$_POST['idDepartamento']."'");
    $descripcion->execute();
    $descripcion=$descripcion->fetchAll(PDO::FETCH_OBJ);

    $numero = count($descripcion);

    echo $_POST['idDepartamento'],',',$_POST['idCategoria'],',',$_POST['nomCategoria'],',',$numero;
  }
;
?>


<?php
} else {
  $reserva = $con->prepare("DELETE FROM apartado where idUser = '".$_POST['idUser']."' and  idDepartamento = '".$_POST['idDepartamento']."'
                                            and idcategoria = '".$_POST['idCategoria']."' and fecha = '".$_POST['fecha']."'
                                            and hora = '".date("H:i:s", strtotime($_POST['hora']))."' ");
  $reserva->execute();


  if ($reserva) {
    $descripcion = $con->prepare("SELECT * FROM apartado where iduser = '".$_POST['idUser']."' and  idcategoria = '".$_POST['idCategoria']."' and idDepartamento = '".$_POST['idDepartamento']."'");
    $descripcion->execute();
    $descripcion=$descripcion->fetchAll(PDO::FETCH_OBJ);

    $numero = count($descripcion);

    echo $_POST['idDepartamento'],',',$_POST['idCategoria'],',',$_POST['nomCategoria'],',',$numero;
  }
?>




<?php } ?>
