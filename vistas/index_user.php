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

<body id="nosotros" class="img-responsive" style="background-image: url('../img/fondo-nosotros.jpg')">
	<div class="rotate valign-wrapper">
		<center>
			<img src="../img/icons/rotate_movil.gif" alt=""  class="valign"/>
		</center>

	</div>
  <nav class="navbar navbar-default normal" role="navigation" id="menu">
    <!-- El logotipo y el icono que despliega el menú se agrupan
         para mostrarlos mejor en los dispositivos móviles -->
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

    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
         otro elemento que se pueda ocultar al minimizar la barra -->

         <img class="img-normal" src="../img/logo.fw.png" alt="" />
    <div class="collapse navbar-collapse navbar-ex1-collapse col-md-7">
      <ul class="nav navbar-nav navbar-right" id="items">
        <li><a href="inicio.php" id="ir-index">Inicio</a></li>
				<li><a href="#" onclick="contenido('reservasUser.php', <?php echo $userRow->id ?>)">Reservas</a></li>
        <li><a href="../controladores/Logout_trabajador.php?logout=true">Salir</a></li>
      </ul>
    </div>
  </nav>

	<div class="nosotros" id="contenido">

			<div class="" id="error">

			</div>


				<?php
					$categorias = $conexion->prepare("SELECT * FROM departamento where habilitado = 1");
					$categorias->execute();
					$categorias=$categorias->fetchAll(PDO::FETCH_OBJ);

				?>
				<div class="col-md-6">
					<center id="reservar_user">
						<div class="reservas">
							<div class="reservas-head">
								<ul>
									<div class="items">
										<?php foreach ($categorias as $c) { ?>
											<li id="cate_<?php echo $c->id ?>">
												<a href="#" onclick="buscarCategorias(<?php echo $c->id ?>,<?php echo $userRow->id ?>, '<?php echo $c->tipo ?>')"><span><?php echo $c->nombre ?></span></a>
											</li>
											<?php } ?>

										</div>

										<li class="_mas">
											<a href="#"><span>+</span></a>
										</li>
									</ul>
								</div>
								<div class="reservas-cont">

									<div class="contenidoSeleccion" id="contenidoSeleccion">

									</div>
								</div>


						</div>
						<div class="nada">

						</div>

					</center>
				</div>
				<div class="col-md-6">
					<center>
						<div class="detalle-reservas" id="detalle-reservas">
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
																		<div class="icon-mas"><i class="fa fa-eye"></i></div>
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

	</div>
</div>
	<footer class="col-sm-12 col-xs-12" style="position: absolute; bottom: 0;">
		<div class="footer-detalles col-md-7 col-sm-7 col-xs-7">
			<div class="">Todos Los derechos reservados. Diseñado por <a href="http://dementecreativo.com/" target="_blank"> <img src="../img/demente.png" alt="" /> </a></div></div>
		</div>
		<div class="footer-redes col-md-5 col-sm-5 col-xs-5">
			<div class="border-redes"><i class="fa fa-facebook"></i></div>
			<div class="border-redes"><i class="fa fa-twitter"></i></div>
			<div class="border-redes"><i class="fa fa-instagram"></i></div>
		</div>
	</footer>

  <div class="visible-lg">
    <br>
  </div>


  <div class="preloader1" id="preloader1"><img src="../img/logo-parte1.png" alt="" /></div>
  <div class="preloader2" id="preloader2"><img src="../img/logo-parte2.png" alt="" /></div>
  <div class="cortina1" id="cortina1"><img src="../img/logo-parte1.png" alt="" /></div>
  <div class="cortina2" id="cortina2"><img src="../img/logo-parte2.png" alt="" /></div>


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

		</script>


</body>

</html>
