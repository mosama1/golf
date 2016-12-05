<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

//BUSQUE EL MAX ID PARA SUMARLE UNO
 $maxId = $con->prepare("SELECT max(id) + 1 as id FROM reserva");
 $maxId->execute();
 $maxId=$maxId->fetch(PDO::FETCH_OBJ);

 $count = count($_POST['hora']);

 for ($i=0; $i < $count ; $i++) {
   $validarReserva = $con->prepare("SELECT fecha, hora FROM desc_reserva
                                    WHERE ( idCategoria = '".$_POST['idCategoria'][$i]."' and fecha = '".$_POST['fecha']."'
                                    and hora = '".date("H:i:s", strtotime($_POST['hora'][$i]))."' and procesado 1 )
                                    or ( idCategoria = '".$_POST['idCategoria'][$i]."' and fecha = '".$_POST['fecha']."'
                                    and hora = '".date("H:i:s", strtotime($_POST['hora'][$i]))."' and procesado 0 )");
   $validarReserva->execute();
   $validarReserva=$validarReserva->fetch(PDO::FETCH_OBJ);

   if (!$validarReserva) {

     $id = $con->prepare("SELECT id FROM reserva where id = '".$maxId->id."'");
     $id->execute();
     $id=$id->fetch(PDO::FETCH_OBJ);

     if (!$id) {
       $user = $con->prepare("SELECT * FROM usuarios WHERE id = '".$_POST['idUser']."' ");
       $user->execute();
       $user=$user->fetch(PDO::FETCH_OBJ);

        $reserva = $con->prepare("INSERT INTO reserva(id, idUsuario, nombreApellido, correo, telefono, recibo, procesado, fecha)
                                  VALUES('".$maxId->id."', '".$_POST['idUser']."', '".$user->nombre." ".$user->apellido."',
                                          '".$user->correo."', '".$user->telefono."', '".$_POST['recibo']."', 0, '".date("Y-m-d")."') ");
        $reserva->execute();
     }

     $reserva = $con->prepare("INSERT INTO desc_reserva(idReserva, idDepartamento, idcategoria, nombreCategoria, fecha, hora, precio)
                                VALUES('".$maxId->id."', '".$_POST['idDepartamento'][$i]."', '".$_POST['idCategoria'][$i]."',
                                        '".$_POST['nombre'][$i]."', '".$_POST['fecha']."', '".date("H:i:s", strtotime($_POST['hora'][$i]))."',
                                        '".$_POST['precio'][$i]."')");
     $reserva->execute();

     $deleteApartado = $con->prepare("DELETE FROM apartado where idDepartamento = '".$_POST['idDepartamento'][$i]."' and idcategoria = '".$_POST['idCategoria'][$i]."'
                                        and fecha = '".$_POST['fecha']."' and hora = '".date("H:i:s", strtotime($_POST['hora'][$i]))."'");
     $deleteApartado->execute();

     echo 1;
   } else {

     $eliminarTodaLaReserva = $con->prepare("DELETE FROM reserva WHERE id = '".$maxId->id."' ");
     $eliminarTodaLaReserva->execute();

     $eliminarTodaLaReserva = $con->prepare("DELETE FROM desc_reserva WHERE idReserva = '".$maxId->id."' ");
     $eliminarTodaLaReserva->execute();

     echo 0;

     $i = $count;
   }
 }

?>
