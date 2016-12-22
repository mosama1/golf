<?php
require_once('../modelos/Conexion.php');
$conexion = new Conexion();
  $user = $conexion->prepare("SELECT * FROM usuarios WHERE id = '".$_POST['idUser']."'");
  $user->execute();
  $user=$user->fetch(PDO::FETCH_OBJ);

  $categorias = $conexion->prepare("SELECT * FROM categorias_departamento where idDepartamento = '".$_POST['id']."' and habilitado = 1");
  $categorias->execute();
  $categorias=$categorias->fetchAll(PDO::FETCH_OBJ);

  //SE BUSCA LA HORA DE INICIO Y LA HORA FIN PARA HACER EL ENCABEZADOY LOS CACULOS NECESAROS
  $hora = $conexion->prepare("SELECT idDepartamento, min(horaInicio) as horaInicio, max(horaFin) as horaFin
                              FROM categorias_departamento where idDepartamento = '".$_POST['id']."' ");
  $hora->execute();
  $hora=$hora->fetch(PDO::FETCH_OBJ);


  $horaInicio= date("h", strtotime($hora->horaInicio)); //selecciono la mayor hora de inicio de la BD de pendiendo del departamento
  $horaFin= date("H", strtotime($hora->horaFin));//selecciono la mayor hora de fin de la BD de pendiendo del departamento
  //END

  //IMG DEPENDE EL DEPARTAMENTO
  $departamentoImg = $conexion->prepare("SELECT * FROM departamento where id = '".$hora->idDepartamento."' ");
  $departamentoImg->execute();
  $departamentoImg=$departamentoImg->fetch(PDO::FETCH_OBJ);


?>
      <?php foreach ($categorias as $c) { ?>
        <div class="cancha li_actividades_<?php echo $c->id; ?>">
         <?php
          $horaInicio1 = date("h", strtotime($c->horaInicio))." ";
          $horaFin1 = date("H", strtotime($c->horaFin))." ";
          $total1 = ($horaFin1 - $horaInicio1 + 01)." ";
              //SI HAY ESPACIOS DE HORA DE INICIO DE HORA CALCULAMOS LOS ESPACIOS Y PONEMOS LA HORA Q PERTENECE
                for ($h=0; $h <= $total1; $h++) {
                  if (date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) == $_POST['hora']) {

                    //SE BUSCA LA HORA Y FECHA SI EXISTE SE DESHABILITA EL CHECK
                    $reserva = $conexion->prepare("SELECT * from desc_reserva
                                                    where ( idDepartamento = '".$_POST['id']."' and idCategoria = '".$c->id."'
                                                    and  hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'
                                                    and fecha = '".date("Y-m-d")."' and procesado = 0 )
                                                    or ( idDepartamento = '".$_POST['id']."' and idCategoria = '".$c->id."'
                                                    and  hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'
                                                    and fecha = '".date("Y-m-d")."' and procesado = 1 )");
                    $reserva->execute();
                    $reserva=$reserva->fetch(PDO::FETCH_OBJ);

                    if (!$reserva) {
                      //hacer acumulador para ir sumando una hora
                      ?>
                          <?php
                            $apartado = $conexion->prepare("SELECT * FROM apartado where idUser = '".$user->id."' and nombreCategoria = '".$c->nombre."' and fecha = '".date("Y-m-d")."'  and hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'");
                            $apartado->execute();
                            $apartado=$apartado->fetchAll(PDO::FETCH_OBJ);

                            if ($apartado) {
                          ?>
                          <div class="image active valign-wrapper pointer" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>"  onclick="procesarCategoria('eliminar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>, '<?php echo date("Y-m-d") ?>')">

                          <!-- Imagen 2  -->
                            <?php
                              } else {
                            ?>
                            <div class="image valign-wrapper pointer" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>" onclick="procesarCategoria('agregar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>, '<?php echo date("Y-m-d") ?>')">

                              <?php
                                }
                              ?>
                          <div class="img valign img_1" >
                            <img src="../img/icons/<?php echo $departamentoImg->imgDis ?>.png" alt="" />
                            <img src="../img/icons/<?php echo $departamentoImg->imgSelect ?>.png" alt="" />
                          </div>
                          <div class="titulo valign-wrapper">
                            <h5 class="valign"><?php echo $c->nombre ?></h5>
                          </div>
                          <!-- Imagen 2  -->

                        <div class="img valign img_2">
                          <img src="../img/icons/<?php echo $departamentoImg->imgDis ?>_1.png" alt="" />
                          <img src="../img/icons/<?php echo $departamentoImg->imgSelect ?>_1.png" alt="" />
                        </div>


                      </div>
                      <?php
                    } else {
                      ?>
                      <div class="image no_disp valign-wrapper">
                          <div class="img img_1 valign">
                            <img src="../img/icons/<?php echo $departamentoImg->imgNoDis ?>.png" alt="" />
                          </div>
                          <div class="titulo valign-wrapper">
                            <h5 class="valign"><?php echo $c->nombre ?></h5>
                          </div>
                          <div class="img img_2 valign">
                            <img src="../img/icons/<?php echo $departamentoImg->imgNoDis ?>_1.png" alt="" />
                          </div>
                      </div>
                      <?php
                    }
                  }
                }
          ?>
        </div>
        <?php	} ?>


<script type="text/javascript">
$('.reservas .reservas-cont .contBuscar .cancha .image').click(function(){
  var image = $(this);
  if (!image.hasClass('active')) {
    image.addClass("active");
  }else {
    image.removeClass("active");
  }
});

</script>
