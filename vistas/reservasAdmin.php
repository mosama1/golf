<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

$reserva = $conexion->prepare("SELECT * FROM reserva where fecha = '".date("Y-m-d")."'");
$reserva->execute();
$reserva=$reserva->fetchAll(PDO::FETCH_OBJ);
?>

<div class="table-responsive col-sm-12 col-md-10 departamento _1">
  <center>
    <table  class="table table-responsive">
      <tr>
        <th colspan="8" class="title">
          <img src="../img/icons/fecha.png">
          <input type="date" name="date" id="dateReservas" value="<?php echo date("Y-m-d") ?>">
        </th>
      </tr>
        <tr class="encabezado">
          <th>
            Codigo
          </th>
          <th>
            Fecha
          </th>
          <th>
            Cliente/Responsable
          </th>
          <th>
            Correo
          </th>
          <th>
            Telefono
          </th>
          <th>
            Recibo
          </th>
          <th>
            Procesar
          </th>
          <th>
            Detalle
          </th>
        </tr>
      <tbody id="contReservas">
        <?php
          foreach ($reserva as $rd) {

        ?>
              <tr>
                <td><?php echo $rd->id ?></td>
                <td><?php echo date("d-m-Y", strtotime($rd->fecha)) ?></td>
                <td><?php echo $rd->nombreApellido ?></td>
                <td><?php echo $rd->correo ?></td>
                <td><?php echo $rd->telefono ?></td>
                <td><b><?php echo $rd->recibo ?></b></td>
                <td class="procesar_<?php echo $rd->id ?>" id="<?php echo $rd->id ?>">
                  <?php if ($rd->procesado == 0) { ?>
                    <div class="btnSiProcesar">
                    <a href="#" onclick="procesarRecibo('procesar',<?php echo $rd->id ?>)">Si</a>
                    </div>
                    <div class="btnNoProcesar">
                    <a href="#" onclick="procesarRecibo('cancelar',<?php echo $rd->id ?>)">No</a>
                  <?php } elseif ($rd->procesado == 1) { ?>
                      Procesado
                  <?php } else { ?>
                    <span class="hint--top hint--error" data-hint="<?php echo $rd->detalle ?>" style="cursor:pointer;">
                        Cancelado
                    </span>
                  <?php } ?>

                  </div>
                </td>

                <td>
                  <a href="#" onclick="buscarReserva(<?php echo $rd->id ?>)">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                  </a>
                </td>
              </tr>
        <?php
          }
         ?>
      </tbody>
    </table>
  </center>
</div>

<div class="" id="modalReserva">

</div>

<script type="text/javascript">
  $("#dateReservas").change(function(){
    var date = $("#dateReservas").val();
    $.ajax({
        type: "POST",
        url: "reservasAdminFecha.php",
        data: {date:date},
        success: function(respuesta) {
          $('#contReservas').html(respuesta);
        }
    });
    return false;
  });

  function procesarRecibo(tipo, id) {
    if (tipo == "procesar") {
      $.ajax({
        type: "POST",
        url: "../controladores/ProcesarRecibo.php",
        data: {tipo:tipo, id:id},
        success: function(respuesta) {
          if (respuesta == 1) {
            $('.procesar').html("Procesado");
          }
        }
      });
      return false;
    } else {
      var detalle = prompt("¿Porque cancelo la reserva?", "");
      //Detectamos si el usuario ingreso un valor
      if (detalle != null){
      // alert("el detalle es " + detalle);
      $.ajax({
        type: "POST",
        url: "../controladores/ProcesarRecibo.php",
        data: {tipo:tipo, id:id, detalle:detalle},
        success: function(respuesta) {
          if (respuesta == 1) {
            $('.procesar_'+id).html("<span class='hint--top hint--error' data-hint='"+detalle+"' style='cursor:pointer;'>Cancelado</span>");
          }
        }
      });
      return false;
      }
      //Detectamos si el usuario NO ingreso un valor
      else {
        alert("no se ingreso detalle");
      }
    }
  }
</script>
