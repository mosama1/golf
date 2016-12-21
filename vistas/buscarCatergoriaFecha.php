<!-- <?php
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
          <div class="titulo valign-wrapper">
            <h5 class="valign"><?php echo $c->nombre ?></h5>
          </div>
         <?php
          $horaInicio1 = date("h", strtotime($c->horaInicio))." ";
          $horaFin1 = date("H", strtotime($c->horaFin))." ";
          $total1 = ($horaFin1 - $horaInicio1 + 01)." ";

         ?>

          <?php

              //SI HAY ESPACIOS DE HORA DE INICIO DE HORA CALCULAMOS LOS ESPACIOS Y PONEMOS LA HORA Q PERTENECE
                for ($h=0; $h <= $total1; $h++) {
                  if (date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) == $_POST['hora']) {

                    //SE BUSCA LA HORA Y FECHA SI EXISTE SE DESHABILITA EL CHECK
                    $reserva = $conexion->prepare("SELECT * from desc_reserva
                                                    where ( idDepartamento = '".$_POST['id']."' and idCategoria = '".$c->id."'
                                                    and  hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'
                                                    and fecha = '".date("Y-m-d", strtotime($_POST['date']))."' and procesado = 0 )
                                                    or ( idDepartamento = '".$_POST['id']."' and idCategoria = '".$c->id."'
                                                    and  hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'
                                                    and fecha = '".date("Y-m-d", strtotime($_POST['date']))."' and procesado = 1 )");
                    $reserva->execute();
                    $reserva=$reserva->fetch(PDO::FETCH_OBJ);

                    if (!$reserva) {
                      //hacer acumulador para ir sumando una hora
                      ?>
                      <div class="image valign-wrapper">
                        <center>
                          <?php
                            $apartado = $conexion->prepare("SELECT * FROM apartado where idUser = '".$user->id."' and nombreCategoria = '".$c->nombre."' and fecha = '".date("Y-m-d", strtotime($_POST['date']))."'  and hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'");
                            $apartado->execute();
                            $apartado=$apartado->fetchAll(PDO::FETCH_OBJ);

                            if ($apartado) {
                          ?>

                          <div class="img valign active" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>" onclick="procesarCategoria('eliminar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>)">
                            <?php
                              } else {
                            ?>
                            <div class="img valign" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>" onclick="procesarCategoria('agregar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>)">
                              <?php
                                }
                              ?>
                            <img src="../img/icons/<?php echo $departamentoImg->imgDis ?>" alt="" />
                            <img src="../img/icons/<?php echo $departamentoImg->imgSelect ?>" alt="" />
                          </div>
                        </center>
                      </div>
                      <?php
                    } else {
                      ?>
                      <div class="image valign-wrapper">
                        <center>
                          <div class="img valign">
                            <img src="../img/icons/<?php echo $departamentoImg->imgNoDis ?>" alt="" />
                          </div>
                        </center>
                      </div>
                      <?php
                    }
                  }
                }
                //DE LO CONTRARIO HAY SE PONE LA HORA Q PERTENECE
          ?>
        </div>
        <?php	} ?>


<script type="text/javascript">
$('.reservas .reservas-cont .contBuscar .cancha .image .img').click(function(){
  if (!$(this).hasClass('active')) {
    $(this).addClass("active");
  }else {
    $(this).removeClass("active");
  }
});

</script> -->


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
                                                    and fecha = '".date("Y-m-d", strtotime($_POST['date']))."' and procesado = 0 )
                                                    or ( idDepartamento = '".$_POST['id']."' and idCategoria = '".$c->id."'
                                                    and  hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'
                                                    and fecha = '".date("Y-m-d", strtotime($_POST['date']))."' and procesado = 1 )");
                    $reserva->execute();
                    $reserva=$reserva->fetch(PDO::FETCH_OBJ);

                    if (!$reserva) {
                      //hacer acumulador para ir sumando una hora
                      ?>
                          <?php
                            $apartado = $conexion->prepare("SELECT * FROM apartado where idUser = '".$user->id."' and nombreCategoria = '".$c->nombre."' and fecha = '".date("Y-m-d", strtotime($_POST['date']))."'  and hora = '".date("H:i:s", strtotime($hora->horaInicio)+(3600*$h))."'");
                            $apartado->execute();
                            $apartado=$apartado->fetchAll(PDO::FETCH_OBJ);

                            if ($apartado) {
                          ?>
                          <div class="image active valign-wrapper" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>" onclick="procesarCategoria('eliminar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>, '<?php echo date("Y-m-d", strtotime($_POST['date'])) ?>')">

                            <?php
                              } else {
                            ?>
                            <div class="image valign-wrapper" id="<?php echo $c->id.date("h", strtotime($hora->horaInicio)+(3600*$h)) ?>" onclick="procesarCategoria('agregar',<?php echo $c->id ?>,<?php echo $user->id ?>,<?php echo $c->idDepartamento ?>,'<?php echo $c->nombre ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$h)) ?>',<?php echo $c->precio ?>, '<?php echo date("Y-m-d", strtotime($_POST['date'])) ?>')">

                              <?php
                                }
                              ?>
                          <div class="img valign img_1" >
                            <img src="../img/icons/<?php echo $departamentoImg->imgDis ?>" alt="" />
                            <img src="../img/icons/<?php echo $departamentoImg->imgSelect ?>" alt="" />
                          </div>
                          <div class="titulo valign-wrapper">
                            <h5 class="valign"><?php echo $c->nombre ?></h5>
                          </div>
                          <!-- Imagen 2  -->

                        <div class="img valign img_2">
                          <img src="../img/icons/<?php echo $departamentoImg->imgDis ?>" alt="" />
                          <img src="../img/icons/<?php echo $departamentoImg->imgSelect ?>" alt="" />
                        </div>


                      </div>
                      <?php
                    } else {
                      ?>
                      <div class="image no_disp valign-wrapper">
                          <div class="img img_1 valign">
                            <img src="../img/icons/<?php echo $departamentoImg->imgNoDis ?>" alt="" />
                          </div>
                          <div class="titulo valign-wrapper">
                            <h5 class="valign"><?php echo $c->nombre ?></h5>
                          </div>
                          <div class="img img_2 valign">
                            <img src="../img/icons/<?php echo $departamentoImg->imgNoDis ?>" alt="" />
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

function procesarCategoria(tipo, id, idUser, idDepartamento, nombre, hora, precio, fecha__){
  console.log(tipo, id, idUser, idDepartamento, nombre, hora, precio, fecha__);
  var hora_ = hora.split(':');
  hora_ = hora_[0];

  // console.log();
  if (tipo == 'agregar') {
    $.ajax({
      type: "POST",
      url: "../controladores/Apartado.php",
      data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:fecha__, hora:hora, precio:precio, idUser:idUser, tipo:tipo},
      success: function(data){
        var separar = data.split(',');
        var idDepartamento_ = parseInt(separar[0]);
        var idCategoria_ = parseInt(separar[1]);
        var nombre_ = separar[2];
        var numero_ = separar[3];
        var depCat = idDepartamento_+'_'+idCategoria_;

        if (numero_ > 0) {
          var ej;
          var cuenta = 0;
          $('.detalle-reservas-cont .detalle .titulo .texto .text').each(function(){
            cuenta++;
            if ($(this).attr('id') == depCat) {
              ej = true;
            }
          });
          if (ej !== true) {
            var muestra = '<div class="text" id="'+depCat+'" onmouseout="textHover(2,'+depCat+') onmouseover="textHover(1,'+depCat+')">';
            muestra += '<h5>'+nombre_+'</h5>';
            // muestra += '';
            muestra +=	'</div>';
            $('.detalle-reservas-cont .detalle .titulo .texto').append(muestra);
            $('#script').html($('#locura').html());
          }
        }
        /************************************************************/
        $.ajax({
          type: "POST",
          url: "../controladores/Apartado_1.php",
          data: {idUser:idUser},
          success: function(data_){
            $('#muestra').html(data_);
            $('#script').html($('#locura').html());

            var sub_total = 0;
            $('#muestra .muestra_ .precio').each(function(){
              sub_total = sub_total + parseInt($('input', this).val());
            });

            iva = 12 * sub_total;
            iva = iva / 100;

            total = iva + sub_total;
            $('#sub-total').html(formatoNumero(sub_total,2, ',', '.'))
            $('#iva').html(formatoNumero(iva,2, ',', '.'))
            $('#total').html(formatoNumero(total,2, ',', '.'))
            // console.log(formatoNumero(total,2, ',', '.'));


          }
        });

        /************************************************************/

        $('#'+id+hora_).attr('onclick', "procesarCategoria('eliminar',"+id+", "+idUser+", "+idDepartamento+", '"+nombre+"', '"+hora+"',"+precio+",'"+fecha__+"')");

      }
    }); // End Ajax
  } else { //end If agregar star else
    $.ajax({
      type: "POST",
      url: "../controladores/Apartado.php",
      data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:fecha__, hora:hora, precio:precio, idUser:idUser, tipo:tipo},
      success: function(data){
        var separar = data.split(',');
        var idDepartamento_ = parseInt(separar[0]);
        var idCategoria_ = parseInt(separar[1]);
        var nombre_ = separar[2];
        var numero_ = separar[3];

        if (numero_ < 1) {
          $('#'+idDepartamento_+'_'+idCategoria_).fadeOut(300);
          setTimeout(function(){ $('#'+idDepartamento_+'_'+idCategoria_).remove(); },300);
        }

        $.ajax({
          type: "POST",
          url: "../controladores/Apartado_1.php",
          data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:fecha__, hora:hora, precio:precio, idUser:idUser, tipo:tipo},
          success: function(data_){
            $('#muestra').html(data_);
            var sub_total = 0;
            $('#muestra .muestra_ .precio').each(function(){
              sub_total = sub_total + parseInt($('input', this).val());
            });

            iva = 12 * sub_total;
            iva = iva / 100;

            total = iva + sub_total;
            $('#sub-total').html(formatoNumero(sub_total,2, ',', '.'))
            $('#iva').html(formatoNumero(iva,2, ',', '.'))
            $('#total').html(formatoNumero(total,2, ',', '.'))
          }
        });


        $('#'+id+hora_).attr('onclick', "procesarCategoria('agregar',"+id+", "+idUser+", "+idDepartamento+", '"+nombre+"', '"+hora+"',"+precio+",'"+fecha__+"')");
      }
    });
  }//end else If agregar
} //end function procesarCategoria


</script>
