<?php
require_once('../modelos/Conexion.php');

$conexion = new Conexion();

$departamento = $conexion->prepare("SELECT * FROM departamento ");
$departamento->execute();
$departamento=$departamento->fetchAll(PDO::FETCH_OBJ);

$n = 1;
?>
<div class="col-md-5 departamento">
	<center>
		<table class="table">
			<tr>
				<th colspan="6" class="title">CATEGORIA</th>
			</tr>
			<tr class="encabezadoAgregar">
				<th>
					<a href="#" class="valign-wrapper" id="agregarCategoria">
						<div class="icono valign-wrapper">
							<div class="icon valign">
								<i class="fa fa-plus" aria-hidden="true" onclick="agregarDepartamento(<?php echo $_POST['idUser'] ?>);"></i>
								<i class="fa fa-minus" aria-hidden="true" onclick="salirDepartamento(<?php echo $_POST['idUser'] ?>);"></i>
							</div>
						</div>
						<h5 class="valign">Agragar categoria</h5>
					</a>

				</th>
				<th>
					<a href="#" class="valign-wrapper">
						<div class="icono valign-wrapper">
							<div class="icon valign">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</div>
						</div>
						<h5 class="valign">Editar</h5>
					</a>

				</th>

				<th>

				</th>
				<th>

				</th>
				<th>

				</th>
				<th></th>
			</tr>
			<tr class="encabezado">
				<th width="15%"><h5>N°</h5></th>
				<th width="25%"><h5>Actividad</h5></th>
				<th width="5%"><h5>Ver</h5></th>
				<th width="25%"><h5>Tipo</h5></th>
				<th width="15%"><h5>Habilitado</h5></th>
				<th width="15%"><h5>Eliminar</h5></th>

			</tr>
			<tbody id="inputDepartamento">
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
						<td>
							<?php if ($d->tipo == 'cancha'): ?>
								<select required="required" id="tipo" name="tipo">
									<option value"cancha">Cancha</option>
									<option value="clase">Clase</option>
								</select>
								<?php else: ?>
									<select required="required" id="tipo" name="tipo">
										<option value="clase">Clase</option>
										<option value"cancha">Cancha</option>
									</select>
							<?php endif; ?>
							<!-- <?php echo $d->tipo; ?> -->
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
			</tbody>
		</table>
	</center>

</div>

<div class="col-md-7 categoria">
	<center>
		<table class="table">
			<tr class="titulo">
				<th></th>
				<th colspan="6" class="title">DESCRIPCION</th>
			</tr>
			<tr class="">
				<th></th>

				<th class="mas valign-wrapper">
					<center class="valign">
						<div class="icon" idCategoria>
							<a>
								<i class="fa fa-plus" aria-hidden="true"></i>
								<i class="fa fa-minus" aria-hidden="true"></i>
							</a>
						</div>
					</center>
				</th>
				<th>
				</th>
				<th colspan="4"></th>
			</tr>
			<tr>
				<th></th>

				<th>Nombre</th>
				<th>Precio</th>
				<th>Hora Inicio</th>
				<th>Hora Fin</th>
				<th>Habilitado</th>
				<th>Eliminar</th>
			</tr>
			<tbody id="categoriaDepartamento">

			</tbody>
		</table>
		<div id="agregar__">

		</div>
		<div class="center-align" id="btnCategoria">

		</div>
	</center>
</div>

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

function deleteDepartamento(id) {

	 $.ajax({
			 type: "POST",
			 url: "../controladores/DeleteDepartamento.php",
			 data: {id:id},
			 success: function(respuesta) {
				 $('#departamento_'+id).fadeOut();
			 }
	 });
 };

 function deleteCategoria(id) {

 	 $.ajax({
 			 type: "POST",
 			 url: "../controladores/DeleteCategoria.php",
 			 data: {id:id},
 			 success: function(respuesta) {
 				 $('#categoria_'+id).fadeOut();
 			 }
 	 });
  };

//ADD DEPARTAMENTO
function agregarDepartamento(idUser) {
	campo = '<tr id="inputAddDepartamento">';
	campo += '  <td><button onclick="departamento('+idUser+');" class="btn btn-success">A&ntilde;adir</button></td>';
	campo += '  <td><input type="text" required="required" class="form-control" id="departamento" name="departamento"></td>';
	campo += '  <td><select required="required" class="form-control anadir" id="tipo" name="tipo"><option value"cancha">Cancha</option><option value="clase">Clase</option></select></td>';
	campo += '</tr>';
	$("#inputDepartamento").append(campo);

	$('#agregarCategoria').addClass('active');
}

	function salirDepartamento(idUser) {
		$("#inputAddDepartamento").remove();
		$('#agregarCategoria').removeClass('active');

		return false;
	}
	$('#agregarCategoria').click(function(){
		if (!$(this).hasClass('active')) {
			agregarDepartamento('<?php echo $_POST['idUser'] ?>')
		}else {
			salirDepartamento('<?php echo $_POST['idUser'] ?>')
		}
	});

	function departamento(idUser) {

		 var nombre = $('#departamento').val();
		 var tipo = $('#tipo').val();

		 $.ajax({
				 type: "POST",
				 url: "../controladores/InsertDepartamento.php",
				 data: {departamento:nombre, tipo:tipo},
				 success: function(respuesta) {
					 $('#inputDepartamento').html(respuesta);
					 salirDepartamento(idUser);
				 }
		 });
	 };

//ADD CATEGORIA departamento
	function categoriaDepartamento(id) {

		$('#categoriaDepartamento').html('');

		$.ajax({
				type: "POST",
				url: "../controladores/BuscarCategoria.php",
				data: {id:id},
				success: function(respuesta) {

					$('#categoriaDepartamento').html(respuesta);
					$('.categoria table tr th.mas .icon').attr('idCategoria', id);


				}
		});
	}
	$('.categoria table tr th.mas .icon').click(function(){
		if (!$(this).hasClass('active')) {
			agregarCategoria($('.categoria table tr th.mas .icon').attr('idCategoria'));
		}else {
			salirCategoria($('.categoria table tr th.mas .icon').attr('idCategoria'));
		}
	});

	//ADD CATEGORIA
	function agregarCategoria(idUser) {
		console.log(idUser);
		campo = '<table>';
		campo += '  <tbody> ';
		campo += '    <tr id="inputAddCategoria">';
		campo += '      <td><input type="text" required="required" class="form-control" id="nombre" name="nombre"></td>';
		campo += '      <td><input type="number" required="required" class="form-control" id="precio" name="precio"></td>';
		campo += '      <td><input type="time" required="required" class="form-control" id="horaInicio" name="horaInicio" ></td>';
		campo += '      <td><input type="time" required="required" class="form-control" id="horaFin" name="horaFin" ></td>';
		campo += '    </tr>';
		campo += '  </tbody>';
		campo += '</table>';
		$("#agregar__").html(campo);

		$('.categoria table tr th.mas .icon').addClass('active');

		//BOTON AGREGAR Y SALIR DESPUES DE LA TABLA
		btn = '<div id="categoria-add">';
		btn += 	'<button onclick="categoria('+idUser+');" class="btn">A&ntilde;adir</button>';
		btn += 	'<button onclick="salirCategoria('+idUser+');" id="salir-categoria" class="btn">Cancelar</button>';
		btn += '</div>';
		$("#btnCategoria").append(btn);
	}

		function salirCategoria(idUser) {
			$("#inputAddCategoria").remove();
			$("#categoria-add").remove();
			$('.categoria table tr th.mas .icon').removeClass('active');

			return false;
		}

		function categoria(idUser) {

			 var nombre = $('#nombre').val();
			 var precio = $('#precio').val();
			 var horaInicio = $('#horaInicio').val();
			 var horaFin = $('#horaFin').val();

			 $.ajax({
					 type: "POST",
					 url: "../controladores/InsertCategoria.php",
					 data: {id:idUser,nombre:nombre, precio:precio, horaInicio:horaInicio, horaFin:horaFin},
					 success: function(respuesta) {
						 $('#categoriaDepartamento').html(respuesta);
						 salirCategoria(idUser);
					 }
			 });
			 return false;
		 }

		 function habilitarDepartamento(tipo, id) {
			 $.ajax({
					 type: "POST",
					 url: "../controladores/ProcesarDepartamento.php",
					 data: {tipo:tipo,id:id},
					 success: function(respuesta) {
						 if (respuesta == 1) {
							 if (tipo == 'agregar') {
								 $('#'+id).attr('onclick', "habilitarDepartamento('eliminar',"+id+")");
							 }else if (tipo == 'eliminar') {
								 $('#'+id).attr('onclick', "habilitarDepartamento('agregar',"+id+")");
							 }
						 }
					 }
			 });
			 return false;
		 }

		 function habilitarDescripcion(tipo, id) {
			 $.ajax({
					 type: "POST",
					 url: "../controladores/ProcesarDescripcion.php",
					 data: {tipo:tipo,id:id},
					 success: function(respuesta) {
						 if (respuesta == 1) {
							 if (tipo == 'agregar') {
								 $('#'+id).attr('onclick', "habilitarDescripcion('eliminar',"+id+")");
							 }else if (tipo == 'eliminar') {
								 $('#'+id).attr('onclick', "habilitarDescripcion('agregar',"+id+")");
							 }
						 }
					 }
			 });
			 return false;
		 }

</script>
