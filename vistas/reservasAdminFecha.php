<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

$reserva = $conexion->prepare("SELECT * FROM reserva where fecha = '".date("Y-m-d", strtotime($_POST['date']))."' ");
$reserva->execute();
$reserva=$reserva->fetchAll(PDO::FETCH_OBJ);
?>

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
        <td class="procesar" id="<?php echo $rd->id ?>">
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
