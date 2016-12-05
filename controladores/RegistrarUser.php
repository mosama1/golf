<?php
session_start();
require_once('../modelos/Conexion.php');
 $con = new Conexion();

if ($_POST) {

  $userVerific = $con->prepare("SELECT id FROM usuarios where correo = '".$_POST['email']."' or  cedula = '".$_POST['codCedula'].$_POST['cedula']."'");
  $userVerific->execute();
  $userVerific=$userVerific->fetch(PDO::FETCH_OBJ);

  if (!$userVerific) {

    $new_password = password_hash($_POST['pw'], PASSWORD_DEFAULT);

    $user = $con->prepare("INSERT INTO usuarios(nombre, apellido, cedula, telefono, correo, pw, roll, habilitado)
    VALUES('".$_POST['nombre']."', '".$_POST['apellido']."', '".$_POST['codCedula'].$_POST['cedula']."',
    '".$_POST['telefono']."', '".$_POST['email']."', '".$new_password."', 'user', 1)");
    $user->execute();

      $_SESSION['user_session'] = $_POST['codCedula'].$_POST['cedula'];

      echo 1;


  } else {
    echo 0;
  }

} else {
  echo 0;
}
?>
