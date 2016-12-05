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
<div class="reservas-fecha">

  <div class="icon">
    <center>
      <img src="../img/icons/fecha.png">
      <input type="date" min="<?php echo date("Y-m-d") ?>" name="date" id="dateReserva" value="<?php echo date("Y-m-d") ?>">
    </center>
  </div>

  <div class="fecha">
    <p>
      <?php
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        //Salida: Viernes 24 de Febrero del 2012
       ?>
    </p>
  </div>

  <div class="flecha valign-wrapper">
    <i class="fa fa-caret-right right valign" aria-hidden="true"></i>
  </div>
</div>

<div class="seleccionTabla">

  <table class="table table-hover">
    <thead>
      <tr>
        <th>Tipo
          <div class="icon">
            <img src="../img/icons/reloj.png">
          </div>
          <div class="flecha valign-wrapper">
            <i class="fa fa-caret-left valign left" aria-hidden="true"></i>
          </div>
        </th>
        <?php
        ?>
        <?php
          for ($n=0; $n <= ( $horaFin - $horaInicio ); $n++) {
            //hacer acumulador para ir sumando una hora
        ?>
          <th id='th_<?php echo date("hi", strtotime($hora->horaInicio)+(3600*$n)) ?>'>
            <a href='#' onclick="buscarCatergoria(<?php echo $user->id ?>,<?php echo $_POST['id'] ?>,'<?php echo $_POST['tipo'] ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$n)) ?>', 'th_<?php echo date("hi", strtotime($hora->horaInicio)+(3600*$n)) ?>')" >
              <?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$n)) ?>
            </a>
          </th>
        <?php
          }
        ?>
      </tr>
    </thead>
  </table>
</div>
<div class="contBuscar" id="contBuscar">
  </div>
</div>

<?php ?>
<script type="text/javascript">
var maxScrollLeft = $('.contenidoSeleccion .seleccionTabla table').width() - $('.contenidoSeleccion .seleccionTabla').width();
var left = 0;

$('.reservas .flecha i').click(function(){
  if ($(this).hasClass('left')) {
    var interval = setInterval(function(){ position() },5);
    var numero = 0;
    function position() {
      numero++;
      left = left - 1;
      $('.contenidoSeleccion .seleccionTabla').scrollLeft(left);
      if (numero >= 100) {
        clearInterval(interval);
      }
      if (left <= 0) {
        left = 0;
      }
    }
  }else {
    var interval = setInterval(function(){ position() },5);
    var numero = 0;
    function position() {
      numero++;
      left = left + 1;
      $('.contenidoSeleccion .seleccionTabla').scrollLeft(left);
      if (numero >= 100) {
        clearInterval(interval);
      }
      if (left >= maxScrollLeft) {
        left = maxScrollLeft;
      }
    }
  }
});

$('.reservas .reservas-cont .reservas-fecha .fecha').click(function(){
  if (!$('#dateReserva').hasClass('active')) {
    $('#dateReserva').addClass('active');
  }else {
    $('#dateReserva').removeClass('active');
  }
});

function buscarCatergoria(idUser, id, tipo, hora, id_th){
  function activar() {
    $('.reservas .reservas-cont table thead th').removeClass('active');
    $('#'+id_th).addClass('active');
  }
  if (tipo == 'cancha') {
      $.ajax({
          type: "POST",
          url: "buscarCatergoria.php",
          data: {idUser:idUser, id:id, hora:hora},
          success: function(respuesta) {

              $('#contBuscar').html(respuesta);
              activar();
          }
      })
  } else {
    $.ajax({
      type: "POST",
      url: "buscarCatergoriaClase.php",
      data: {idUser:idUser, id:id, hora:hora},
      success: function(respuesta) {
        $('#contBuscar').html(respuesta);
        activar();
      }
    });
  }
}

  function procesarCategoria(tipo, id, idUser, idDepartamento, nombre, hora, precio){
    var hora_ = hora.split(':');
    hora_ = hora_[0];

    // console.log();
    if (tipo == 'agregar') {
      $.ajax({
        type: "POST",
        url: "../controladores/Apartado.php",
        data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:"<?php echo date("Y-m-d")?>", hora:hora, precio:precio, idUser:idUser, tipo:tipo},
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
              muestra += '<div class="icon-mas"><i class="fa fa-eye"></i></div>';
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

          $('#'+id+hora_).attr('onclick', "procesarCategoria('eliminar',"+id+", "+idUser+", "+idDepartamento+", '"+nombre+"', '"+hora+"',"+precio+")");

        }
      }); // End Ajax
    } else { //end If agregar star else
      $.ajax({
        type: "POST",
        url: "../controladores/Apartado.php",
        data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:"<?php echo date("Y-m-d")?>", hora:hora, precio:precio, idUser:idUser, tipo:tipo},
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
            data: {idDepartamento:idDepartamento, idCategoria:id, nomCategoria:nombre, fecha:"<?php echo date("Y-m-d")?>", hora:hora, precio:precio, idUser:idUser, tipo:tipo},
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


          $('#'+id+hora_).attr('onclick', "procesarCategoria('agregar',"+id+", "+idUser+", "+idDepartamento+", '"+nombre+"', '"+hora+"',"+precio+")");
        }
      });
    }//end else If agregar
  } //end function procesarCategoria

$("#dateReserva").change(function(){
  var id = parseInt("<?php echo $_POST['id'] ?>");
  var idUser = parseInt("<?php echo $_POST['idUser'] ?>");
  var tipo = "<?php echo $_POST['tipo'] ?>";
  var date = $("#dateReserva").val();
  $.ajax({
      type: "POST",
      url: "categoriaDepartamentoFecha.php",
      data: {id:id, date:date, idUser:idUser, tipo:tipo},
      success: function(respuesta) {
        $('.reservas .reservas-head ul li').removeClass("active");
        $('#cate_'+id).addClass("active");
        $('#contenidoSeleccion').html(respuesta);
        $('#dateReserva').removeClass('active');

      }
  });
  return false;
});
</script>
