<?php
require_once('../modelos/Conexion.php');

class User
{

	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}

	public function redirect($url)
	{
		//header("Location: $url");
		echo '<script type="text/javascript">
					window.location.assign("'.$url.'");
					</script>';
	}

	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
$session = new USER();

$conexion = new Conexion();

if(!$session->is_loggedin())
{
	// session no set redirects to login page
	$session->redirect('../index.php');
}

if(!$session->is_loggedin())
{
  // session no set redirects to login page
  // $session->redirect('index.php');
  $user_id = "";
} else {
  $user_id = $_SESSION['user_session'];
}


$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE cedula=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
$userRow=$stmt->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Avila Fit Club</title>


    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/animate.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/hint.css/2.4.0/hint.min.css" rel="stylesheet" type='text/css'>
    <!-- <link href="../css/normalize.css" rel="stylesheet"> -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href="../css/style.css" rel="stylesheet">
		<style media="screen">
		/*html, body {
				font-family:arial, sans-serif;
		}*/
		#nosotros{
			padding-bottom: 100px;
			position: relative;
			min-height: 100%;
		}
		</style>

</head>

<body class="img-responsive" style="background-image: url('../img/fondos/reserva.jpg')">
	<div class="rotate valign-wrapper">
		<center>
			<img src="../img/icons/rotate_movil.gif" alt=""  class="valign"/>
		</center>
	</div>
  <!-- <nav class="navbar navbar-default normal" role="navigation" id="menu">
    <div class="navbar-header col-md-3">
      <button type="button" class="navbar-toggle" data-toggle="collapse"
              data-target=".navbar-ex1-collapse">
        <span class="sr-only">Desplegar navegación</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>


         <img class="img-normal" src="../img/logo.fw.png" alt="" />
    <div class="collapse navbar-collapse navbar-ex1-collapse col-md-7">
      <ul class="nav navbar-nav navbar-right" id="items">
        <li><a href="inicio.php" id="ir-index">Inicio</a></li>
				<li><a href="#" onclick="contenido('reservasUser.php', <?php echo $userRow->id ?>)">Reservas</a></li>
        <li><a href="../controladores/Logout_trabajador.php?logout=true">Salir</a></li>
      </ul>
    </div>
  </nav> -->
	<nav class="navbar navbar-default menu_" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Desplegar navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-left ul_left">
					<li class="active">
						<a href="inicio.php">
							<span>Inicio</span>
						</a>
					</li>
				</ul>
				<ul class="logo">
					<li>
						<img src="../img/logo.png" alt="">
					</li>
				</ul>


				<ul class="nav navbar-nav navbar-right ul_right">
					<li>
						<a href="#" onclick="contenido('reservasAdmin.php', <?php echo $userRow->id ?>); return false;">
							<span>Reservas</span>
						</a>
					</li>
					<li>
						<a href="../controladores/Logout_trabajador.php?logout=true">
							<span>Salir</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<div id="contenido">
			<div class="" id="error">

			</div>
				<?php
					$categorias = $conexion->prepare("SELECT * FROM departamento where habilitado = 1");
					$categorias->execute();
					$categorias=$categorias->fetchAll(PDO::FETCH_OBJ);
				?>
				<div class="division reservas">
					<center>
						<div class="division_cont">
							<div class="reservas-head">
								<ul>
									<div class="items">
										<?php foreach ($categorias as $c) { ?>
											<li id="cate_<?php echo $c->id ?>">
												<a href="#" onclick="return false;"><span><?php echo $c->nombre ?></span></a>
												<!-- <a href="#" onclick="buscarCategorias(<?php echo $c->id ?>,<?php echo $userRow->id ?>, '<?php echo $c->tipo ?>')"><span><?php echo $c->nombre ?></span></a> -->
											</li>
											<?php } ?>

										</div>

										<!-- <li class="_mas">
											<a href="#"><span>+</span></a>
										</li> -->
									</ul>
								</div>
								<div class="reservas-cont">
									<div class="contenidoSeleccion" id="contenidoSeleccion">
										<?php
										  $user = $conexion->prepare("SELECT * FROM usuarios WHERE id = '".$userRow->id."'");
										  $user->execute();
										  $user=$user->fetch(PDO::FETCH_OBJ);

										  $categorias = $conexion->prepare("SELECT * FROM categorias_departamento where idDepartamento = '".$c->id."' and habilitado = 1");
										  $categorias->execute();
										  $categorias=$categorias->fetchAll(PDO::FETCH_OBJ);

										  //SE BUSCA LA HORA DE INICIO Y LA HORA FIN PARA HACER EL ENCABEZADOY LOS CACULOS NECESAROS
										  $hora = $conexion->prepare("SELECT idDepartamento, min(horaInicio) as horaInicio, max(horaFin) as horaFin
										                              FROM categorias_departamento where idDepartamento = '".$c->id."' ");
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
										            <a href='#' onclick="buscarCatergoria(<?php echo $user->id ?>,<?php echo $c->id ?>,'<?php echo $c->tipo ?>','<?php echo date("h:i a", strtotime($hora->horaInicio)+(3600*$n)) ?>', 'th_<?php echo date("hi", strtotime($hora->horaInicio)+(3600*$n)) ?>')" >
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
										<!-- </div> -->

										<?php ?>
									</div>
								</div>

						</div>
					</center>

				</div>


			<div class="division detalle-reservas" id="detalle-reservas">
				<center>
					<div class="division_cont">
						<div class="detalle-reservas-head">
							<p>
								Detalles de la Reserva
							</p>
						</div>
						<div class="detalle-reservas-cont">
							<div class="cont-item" id="contDetalle">
								<div class="col-md-5 detalle">
									<div class="item">
										<center>
											<div class="titulo">
												<div class="icon">
													<img src="../img/icons/descripcion.png" alt="" />
												</div>
												<div class="texto" id="detalle">

													<?php
														$apartado = $conexion->prepare("SELECT * FROM apartado where iduser = '".$userRow->id."' and fecha >= '".date("Y-m-d")."' group by idcategoria");
														$apartado->execute();
														$apartado=$apartado->fetchAll(PDO::FETCH_OBJ);

															foreach ($apartado as $a) {
													?>
																<div class="text" id="<?php echo $a->idDepartamento ?>_<?php echo $a->idcategoria ?>">
																	<h5><?php echo $a->nombreCategoria ?></h5>
																	<!-- <div class="icon-mas"><i class="fa fa-eye"></i></div> -->
																</div>
													<?php


													}
													$precio = $conexion->prepare("SELECT sum(precio) as subTotal FROM apartado where idUser = '".$userRow->id."'  and fecha >= '".date("Y-m-d")."' " );
													$precio->execute();
													$precio=$precio->fetch(PDO::FETCH_OBJ);

													$iva = 12 * $precio->subTotal;
													$iva = $iva / 100;

													$total = $iva + $precio->subTotal;

													 ?>

												</div>
												<div id="script">

												</div>


											</div>
										</center>
									</div>
								</div>
								<div class="col-md-7 total">
									<div class="total_">
										<center>
											<div class="icono">
												<img src="../img/icons/factura.png" alt="" />
											</div>
										</center>
										<div class="texto">
											<div class="text">
												<span>Sub-total:</span> <span><b id="sub-total"><?php echo number_format($precio->subTotal,2, ',', '.'); ?></b> Bsf</span>
											</div>
											<div class="text">
												<span>Iva:</span> <span><b id="iva"><?php echo number_format($iva,2, ',', '.'); ?></b> Bsf</span>
											</div>
											<div class="text">
												<span class="tot_">total:</span> <span><b id="total"><?php echo number_format($total,2, ',', '.'); ?></b> Bsf</span>
											</div>
										</div>
									</div>
									<form action="" id="form_reservar">
										<div class="muestra" id="muestra">
											<?php
												foreach ($apartado as $a) {
											?>
												<div class="muestra_" id="muestra_<?php echo $a->idDepartamento,'_',$a->idcategoria ?>">
													<div class="titulo">
														<div class="icono">
															<img src="../img/icons/descripcion.png" alt="" />
														</div>
														<div class="text">
															<?php echo $a->nombreCategoria ?>
														</div>
													</div>
													<table>
														<thead>
															<tr>
																<th>
																	<img src="../img/icons/fecha.png" alt="" />
																</th>
																<th>
																	<img src="../img/icons/reloj.png" alt="" />
																</th>
																<th>
																	<img src="../img/icons/factura.png" alt="" />
																</th>
															</tr>
														</thead>
														<tbody id="detalleCompra">
															<?php
															$descripcion = $conexion->prepare("SELECT * FROM apartado where idcategoria = '".$a->idcategoria."'  and fecha >= '".date("Y-m-d")."' and iduser = '".$userRow->id."'  ");
															$descripcion->execute();
															$descripcion=$descripcion->fetchAll(PDO::FETCH_OBJ);

																foreach ($descripcion as $d) {
															?>
																<tr id="<?php echo $d->id; ?>">
																	<td><input type="text" name="fecha" id="fecha" value="<?php echo date("Y-m-d", strtotime($d->fecha))?>" readonly="readonly"></td>
																	<td><input type="text" name="hora[]" class="hr" value="<?php echo date("h:i a", strtotime($d->hora)) ?>" readonly="readonly"></td>
																	<td class="precio">
																		<input type="text" name="precio[]" class="tl" value="<?php echo $d->precio ?>" readonly="readonly">
																		<input type="hidden" name="nombre[]" class="nmb" id="nombre" value="<?php echo $d->nombreCategoria ?>" readonly="readonly">
																		<input type="hidden" name="idDepartamento[]" class="cd" id="idDepartamento" value="<?php echo $d->idDepartamento ?>" readonly="readonly">
																		<input type="hidden" name="idCategoria[]" class="ct" value="<?php echo $d->idcategoria ?>" readonly="readonly">
																		<input type="hidden" id="idUser" name="idUser" value="<?php echo $userRow->id ?>" readonly="readonly">
																	</td>
																</tr>
															<?php
																}
															 ?>
														</tbody>
													</table>
												</div>
											<?php
												}
											 ?>

										</div>

								</div>

							</div>
							<div class="cont-item">
								<div class="cont-item-head">
									<div class="tiempo valign-wrapper">
										<span id="tiempo" class="valign"></span>
									</div>
										<div class="iconos">
											<a href="https://www.portaldepagosmercantil.com/" target="_blank">
												<img src="../img/icons/visa.jpg" alt="" />
												<img src="../img/icons/master.png" alt="" />
												<img src="../img/icons/mercantil.png" alt="" />
											</a>
										</div>
								</div>

								<center>
										<div class="item-input">
												<label for="">Ingrese numero de recibo</label>
												<input type="text" name="recibo" id="recibo">
												<div class="errorRecibo">

												</div>
										</div>
								</center>


						</div>
				</div>
				<div class="boton_reservar">
						<div class="bot">
								<button type="button" name="button" id="sent"><span><div class="icon"><img src="../img/icons/reserva.png" alt=""></div><b>Reservar</b></span></button>
						</div>
						<div class="bot">
								<button type="button" name="button" id="procesar"><span><div class="icon"><img src="../img/icons/reserva.png" alt=""></div><b>Procesar</b></span></button>
						</div>
				</div>
		</form>
					</div>
				</center>

      </div>

</div>
<div class="footer">
	<div class="container">
		<div class="footer_cont">
			<div class="item_ left">
				<p>
					Todos Los derechos reservados. Diseñado por <a href="http://dementecreativo.com/" target="_blank"> <img src="../img/demente.png" alt="" /> </a>
				</p>
			</div>
			<div class="item_ right">
				<ul class="redes">
					<li>
						<a href="#">
							<i class="fa fa-facebook"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-twitter"></i>
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-instagram"></i>
						</a>
					</li>
				</ul>
			</div>


		</div>
	</div>

</div>



    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/collapse.min.js"></script>
    <script src="../js/script.js"></script>
    <script src='../js/wow.min.js'></script>
    <script>new WOW().init();</script>

		<div id="locura">
			<script type="text/javascript">


			var id;
			$('.detalle-reservas-cont .detalle .titulo .text').mouseover(function(){
				id = $(this).attr('id');
				$('#muestra').addClass('active');
				$('#muestra_'+id).addClass('active');
			});
			$('.detalle-reservas-cont .detalle .titulo .text').mouseleave(function(){
				$('#muestra').removeClass('active');
				$('#muestra_'+id).removeClass('active');
			});
			$('.detalle-reservas-cont .total .muestra').mouseover(function(){
				$('#muestra').addClass('active');
				$('#muestra_'+id).addClass('active');
			});
			$('.detalle-reservas-cont .total .muestra').mouseleave(function(){
				$('#muestra').removeClass('active');
				$('#muestra_'+id).removeClass('active');
			});

			$('.detalle-reservas-cont .total .muestra input').each(function(){
				$(this).attr('size', $(this).val().length);
			});
			</script>
		</div>



		<script type="text/javascript">

			function contenido(url, idUser){
				$.ajax({
						type: "POST",
						url: url,
						data: {idUser:idUser},
						// beforeSend: function(){
						// 	$("#cortina1").slideDown(400);
						// 	$("#cortina2").slideDown(400);
						// },
						success: function(respuesta) {

							// setTimeout(function(){

								$('#contenido').html(respuesta);
								$("#cortina1").delay(300).slideUp(400);
								$("#cortina2").delay(300).slideUp(400);

							// },500);
						}
				});
			}

			// BUSCAR CATEGORIAS PARA RESERVAR
				function buscarCategorias(id, idUser, tipo) {
					$.ajax({
							type: "POST",
							url: "categoriaDepartamento.php",
							data: {id:id, idUser:idUser, tipo:tipo},
							success: function(respuesta) {
								$('.reservas .reservas-head ul li').removeClass("active");
								$('#cate_'+id).addClass("active");
								$('#contenidoSeleccion').html(respuesta);
							}
					});
				}

				//
				$('#sent').click(function(){
					$('#detalle-reservas').addClass('active');
					conteo();
					$('#reservar_user .nada').fadeIn();
				});

				$('#procesar').click(function(){
					if ($('#recibo').val() != '') {
						$.ajax({
							type: "POST",
							url: "../controladores/InsertReserva.php",
							data: $('#form_reservar').serialize(),
							success: function(respuesta) {
								if (respuesta == 0) {
									$('#error').html('<h4>Disculpe acaban de reservar esas caracteristicas</h4>');
								} else {
									location.reload();
								}
							}
						});
						//
						return false;
					} else {
						$('.errorRecibo').html('Debe ingresar Numero de recibo');
						return false;
					}
				});

				function conteo() {
					var cuenta = 900;
					var seg = 60;
					var min = 14;
					var interval = setInterval(function(){	tiempo();	},1000);
					function tiempo() {
						cuenta--;
						seg--;
						if (seg <= 0) {
							seg = 60;
							min = min - 1;
						}
						if (seg < 10) {
							seg = '0'+seg;
						}
						if (min < 10) {
							$('#tiempo').html('0'+min+':'+seg);
						}else {
							$('#tiempo').html(min+':'+seg);
						}

						// console.log(min, seg, cuenta);


						// console.log(cuenta/60);
						if (cuenta <= 0) {
							clearInterval(interval);

							var idUser = parseInt('<?php echo $userRow->id ?>');
							$.ajax({
									type: "POST",
									url: "../controladores/DeleteApartado.php",
									data: {idUser:idUser},
									success: function(respuesta) {
											location.reload();
									}
							});
						}

					}

				}

				//BUSCQUEDA DE INFORMACION DE RESERVAS POR ID
				function buscarReserva(id) {
					$.ajax({
							type: "POST",
							url: "buscarReserva.php",
							data: {id:id},
							success: function(respuesta) {
								$('#modalReserva').html(respuesta);
								$("#myModal").modal();
							}
					});
				}

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
				  var cont = $('#'+id_th).parent().parent().parent();
				  function activar() {
				    $('.reservas .reservas-cont table thead th').removeClass('active');
				    $('#'+id_th).addClass('active');
				    cont.addClass('active');
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

				$("#dateReserva").change(function(){
				  var id = parseInt("<?php echo $c->id ?>");
				  var idUser = parseInt("<?php echo $userRow->id ?>");
				  var tipo = "<?php echo $c->tipo ?>";
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


</body>

</html>
