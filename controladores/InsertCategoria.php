<?php
require_once('../modelos/Conexion.php');
 $con = new Conexion();

if ($_POST) {

  $categoriaDepartamento = $con->prepare("INSERT INTO categorias_departamento(idDepartamento, nombre, precio, horaInicio, horaFin, habilitado)
                                  VALUES('".$_POST['id']."', '".$_POST['nombre']."', '".$_POST['precio']."',
                                          '".$_POST['horaInicio']."', '".$_POST['horaFin']."', 1)");
  $categoriaDepartamento->execute();

	//Hacemos la inserción, y si es correcta, se procede
	if($categoriaDepartamento) {

    //CONSULTAMOS Y LE ENVIAMOS LOS SALARIOS ACTUALIZADOS
    $categoria = $con->prepare("SELECT * FROM categorias_departamento where idDepartamento =  '".$_POST['id']."'");
    $categoria->execute();
    $categoria=$categoria->fetchAll(PDO::FETCH_OBJ);
    ?>

    <?php foreach ($categoria as $c) { ?>
			<tr id="categoria_<?php echo $c->id?>">
        <td class="hidden-xs_" style="border-top: none;"></td>
    		<td>
    			<input type="text" name="name" size="6" value="<?php echo $c->nombre ?>" readonly="">
    		</td>
    		<td>
    			<input type="number" name="" class="prec" value="<?php echo $c->precio ?>" readonly="">
    		</td>
    		<td>
    			<input type="time" name="name" class="hr" value="<?php echo date('H:i:s', strtotime($c->horaInicio)) ?>" readonly="">
    		</td>
    		<td>
    			<input type="time" name="name" class="hr" value="<?php echo date('H:i:s', strtotime($c->horaFin)) ?>" readonly="">
    		</td>
    		 	<?php	if ($c->habilitado != 1 ) { ?>
    		 			<td><input type="checkbox" id="<?php echo $c->id?>" onclick="habilitarDescripcion('agregar',<?php echo $c->id?>)"></td>
    		 	<?php	} else { ?>
    		 			<td><input type="checkbox" id="<?php echo $c->id?>" checked onclick="habilitarDescripcion('eliminiar',<?php echo $c->id?>)"></td>
    		 	<?php } ?>
    			<td>
    				<i class="fa fa-close" aria-hidden="true" onclick="deleteCategoria(<?php echo $c->id  ?>);" style="cursor:pointer;"></i>
    			</td>
			</tr>
		<?php } ?>
    <script type="text/javascript">
    	$('.categoria table #categoriaDepartamento input').click(function(){
    		$(this).prop('readonly', false);
    		/*Aqui mandas el script para hacer el update*/
    		$(this).focusout(function(){
    			$(this).prop('readonly', true);
    		});
    	});

    </script>

	<?php } else {
    echo 0;
	};

} else {
  echo 0;
}
 ?>
