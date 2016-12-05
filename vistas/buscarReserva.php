<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

?>
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><b>Codigo</b>: <?php echo $_POST['id'] ?></h4>
        </div>
        <div class="modal-body departamento">
          <table  class="table table-hover">
            <thead>
              <tr class="encabezado">
                <th>Descripcion</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Precio</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $descReserva = $conexion->prepare("SELECT nombreCategoria, fecha, hora, precio FROM desc_reserva
                                                  where idReserva = '".$_POST['id']."'");
              $descReserva->execute();
              $descReserva=$descReserva->fetchAll(PDO::FETCH_OBJ);

              $subTotal = 0;

                foreach ($descReserva as $dr) {
              ?>
                  <tr>
                    <td><?php echo $dr->nombreCategoria ?></td>
                    <td><?php echo date("d-m-Y", strtotime($dr->fecha)) ?></td>
                    <td><?php echo date("h:i a", strtotime($dr->hora)) ?></td>
                    <td><?php echo $dr->precio ?></td>
                  </tr>
              <?php
                  $total = $dr->precio;
                  $subTotal = $total + $subTotal;
                }
               ?>
                 <tr>
                   <td colspan="4">Sub-Total: <?php echo $subTotal ?></td>
                 </tr>
                 <tr>
                   <td colspan="4">Iva: <?php echo ($subTotal * 12) / 100 ?></td>
                 </tr>
                  <tr>
                    <td colspan="4">Total: <?php echo (($subTotal * 12) / 100) + $subTotal ?></td>
                  </tr>
            </tbody>
          </table>

        </div>
      </div>

    </div>
  </div>
