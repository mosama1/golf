<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

$reserva = $conexion->prepare("SELECT * FROM reserva where idUsuario = '".$_POST['idUser']."' and fecha = '".date("Y-m-d")."' ");
$reserva->execute();
$reserva=$reserva->fetchAll(PDO::FETCH_OBJ);
?>

<div class="table-responsive col-sm-12 col-md-8 departamento _2">
  <center>
    <table  class="table table-responsive">
      <tr>
        <th colspan="5" class="title">
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
            Estado
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
                <td class="procesar" id="<?php echo $rd->id ?>">
                  <?php if ($rd->procesado == 0) { ?>
                      En Proceso
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
    var idUser = parseInt('<?php echo $_POST['idUser'] ?>');
    $.ajax({
        type: "POST",
        url: "reservasUserFecha.php",
        data: {date:date, idUser:idUser},
        success: function(respuesta) {
          $('#contReservas').html(respuesta);
        }
    });
    return false;
  });

</script>
