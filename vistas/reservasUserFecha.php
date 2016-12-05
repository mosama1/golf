<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

$reserva = $conexion->prepare("SELECT * FROM reserva where idUsuario = '".$_POST['idUser']."' and fecha = '".date("Y-m-d", strtotime($_POST['date']))."' ");
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
