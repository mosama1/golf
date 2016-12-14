<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

 $n = 1;

if ($_POST) {

  $departamento = $con->prepare("INSERT INTO departamento(nombre, imgDis, imgNoDis, imgSelect, habilitado, tipo)
                                  VALUES('".$_POST['departamento']."', 'Activo.png', 'Inactivo.png', 'Select.png', 1, '".$_POST['tipo']."')");
  $departamento->execute();

	//Hacemos la inserción, y si es correcta, se procede
	if($departamento) {

    //CONSULTAMOS Y LE ENVIAMOS LOS SALARIOS ACTUALIZADOS
    $departamento = $con->prepare("SELECT * FROM departamento ");
    $departamento->execute();
    $departamento=$departamento->fetchAll(PDO::FETCH_OBJ);
    ?>

			<?php foreach ($departamento as $d) { ?>
        <tr id="departamento_<?php echo $d->id ?>">
          <td><?php echo $n ?></td>
          <td>
            <input type="text" name="name" size="6" value="<?php echo $d->nombre; ?>" readonly>
          </td>
          <td>
            <a href="#" onclick="categoriaDepartamento(<?php echo $d->id ?>)">
              <i class="fa fa-eye"></i>
            </a>
          </td>
          <?php if ($d->habilitado != 1 ) { ?>
            <td>
              <input type="checkbox" id="<?php echo $d->id?>" onclick="habilitarDepartamento('agregar',<?php echo $d->id?>)">
            </td>
          <?php } else { ?>
            <td>
              <input type="checkbox" id="<?php echo $d->id?>" checked onclick="habilitarDepartamento('eliminiar',<?php echo $d->id?>)">
            </td>
          <?php } ?>
          <td>
            <i class="fa fa-close" aria-hidden="true" onclick="deleteDepartamento(<?php echo $d->id  ?>);" style="cursor:pointer;"></i>
          </td>
        </tr>
			<?php $n++; } ?>
      <script type="text/javascript">
      $('.departamento table #inputDepartamento input').click(function(){
        $(this).prop('readonly', false);
        /*Aqui mandas el script para hacer el update*/
        $(this).focusout(function(){
          $(this).prop('readonly', true);
        });
      });
      $('.departamento table #inputDepartamento select').change(function(){

      });
      </script>

	<?php } else {
    echo 0;
	};

} else {
  echo 0;
}
 ?>
