<?php
    session_start();
    require_once('../modelos/Conexion.php');
    $conexion = new Conexion();

    if (!$_SESSION['user_session']) {
      echo '<script type="text/javascript">
      window.location.assign("../index.html");
      </script>';
    } else {
      $user_roll = $_SESSION['user_session'];
    }

    $stmt = $conexion->prepare("SELECT roll FROM usuarios WHERE cedula=:user_id");
    $stmt->execute(array(":user_id"=>$user_roll));
    $roll=$stmt->fetch(PDO::FETCH_OBJ);

    if ($roll->roll != 'user') {

        // El fragmento de html que contiene la cabecera de nuestra web
        require_once 'index_admin.php';

    } else {

      // El fragmento de html que contiene la cabecera de nuestra web
      require_once 'index_user.php';
    }

?>
