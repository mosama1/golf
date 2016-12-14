<?php
session_start();
require_once('modelos/Conexion.php');

class User
{

	public function doLogin($umail,$upass)
	{
		try
		{
			$con = new Conexion();
			$stmt = $con->prepare("SELECT cedula, correo, pw FROM usuarios WHERE correo=:umail ");
			$stmt->execute(array(':umail'=>$umail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				//REDIRECCIONAR A CONTROL SE ASISTENCIA CUANDO EL PERFIL ES 2
				if(password_verify($upass, $userRow['pw']))
				{
				$_SESSION['user_session'] = $userRow['cedula'];
				//	return header("Location: inicio.php");
				echo '<script type="text/javascript">
							window.location.assign("vistas/inicio.php");
							</script>';
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}

	public function redirect($url)
	{
		// header("Location: $url");
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

$login = new User();
// if ($_GET) {
	$url = "vistas/inicio.php";
// }
if($login->is_loggedin()!="")
{
	$login->redirect($url);
}

if(isset($_POST['btn-login']))
{
	$umail = strip_tags($_POST['Usuario']);
	$upass = strip_tags($_POST['Password']);

	if(!$login->doLogin($umail,$upass))
	{
		$error = "Usuario o Contraseña Invalido";
		// $login->redirect($url);
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <link rel="icon" href="img/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Avila Fit Club</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/normalize.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
		<style media="screen">
			#nosotros,
			.nosotros{

				height: 100% !important;
				padding: 0;
			}
			.nosotros center{
				width: 100%;
			}
		</style>

</head>

<body id="nosotros" class="img-responsive" style="background-image: url('img/fondo-nosotros.jpg')">

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

         <img class="img-normal" src="img/logo.fw.png" alt="" />
    <div class="collapse navbar-collapse navbar-ex1-collapse col-md-7">
      <ul class="nav navbar-nav navbar-right" id="items">
        <!-- <li><a href="index.html" id="ir-index">Inicio</a></li>
        <li><a href="nosotros.html" id="ir-nosotros">Nosotros</a></li>
        <li><a href="servicios.html" id="ir-servicios">Servicios</a></li>
        <li><a href="ingresar.php" id="ir-reservar" class="active">Reservar</a></li>
        <li><a href="contacto.html" id="ir-contacto">Contacto</a></li> -->
      </ul>
    </div>
  </nav>

  <div class="nosotros col-md-12 col-sm-12 col-xs-12 valign-wrapper" id="ingresar">
		<div class="ingresar valign-wrapper">
			<center>
				<div class="form valign">
					<form action="" class="form-signin" method="post" id="login-form">
						<div class="usuario input valign-wrapper">
							<div class="inp valign">
								<label for="email">USUARIO&nbsp;&nbsp;</label>
								<input type="email" name="Usuario" class="form-control" id="email">
							</div>
						</div>
						<div class="password input valign-wrapper">
							<div class="inp valign">
								<label for="pwd">PASSWORD&nbsp;&nbsp;</label>
								<input type="password" name="Password" class="form-control" id="pwd">
							</div>
						</div>
						<div class="boton">
							<div class="bot">
								<button type="submit" name="btn-login" id="enviar-btn" class="waves-effect waves-brown" >Ingresar</button>
							</div>
							<div class="bot">
								<button type="submit" name="btn-login" id="enviar-btn" class="waves-effect waves-brown registrarse">
									<span>nuevo</span>
									<span>usuario</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</center>
		</div>
		<div class="ingresar valign-wrapper">
			<center>
				<div class="form valign">
					<div class="error">

					</div>
					<form action="" class="form-signin" method="post" id="register-form">

						<div class="usuario input valign-wrapper">
							<div class="inp valign">
								<label for="email">Nombre&nbsp;&nbsp;</label>
								<input type="text" name="nombre" class="form-control" id="nombre">
							</div>
						</div>
						<div class="password input valign-wrapper">
							<div class="inp valign">
								<label for="pwd">APELLIDO&nbsp;&nbsp;</label>
								<input type="text" name="apellido" class="form-control" id="apellido">
							</div>
						</div>
						<div class="usuario input valign-wrapper">
							<div class="inp valign">
								<label for="pwd">CEDULA&nbsp;&nbsp;</label>
								<select  name="codCedula">
									<option value='V'>V</option>
									<option value='E'>E</option>
								</select>
								<input type="text" name="cedula" class="form-control" id="pwd">
							</div>
						</div>

						<div class="password input valign-wrapper">
							<div class="inp valign">
								<label for="email">TELEFONO&nbsp;&nbsp;</label>
								<input type="text" name="telefono" class="form-control" id="telefono">
							</div>
						</div>
						<div class="usuario input valign-wrapper">
							<div class="inp valign">
								<label for="pwd">CORREO&nbsp;&nbsp;</label>
								<input type="email" name="email" class="form-control" id="email">
							</div>
						</div>
						<div class="password input valign-wrapper">
							<div class="inp valign">
								<label for="email">PASSWORD&nbsp;&nbsp;</label>
								<input type="password" name="pw" class="form-control" id="pw">
							</div>
						</div>
						<div class="usuario input valign-wrapper">
							<div class="inp valign">
								<label for="pwd">CONFIRMAR&nbsp;&nbsp;</label>
								<input type="password" name="pw2" class="form-control" id="pw2">
							</div>
						</div>
						<div class="boton">
							<div class="bot">
								<button name="enviar-btnUser" id="enviar-btnUser" class="waves-effect waves-brown" >Guardar</button>
							</div>
							<div class="bot">
								<button type="submit" name="" id="" class="waves-effect waves-brown iniciar_seccion">
									<span>Iniciar</span>
									<span>session</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</center>
		</div>

  </div>


  <div class="visible-lg">
    <br>
  </div>

  <footer class="col-sm-12 col-xs-12" style="bottom: 0px; position: absolute;">
    <div class="footer-detalles col-md-7 col-sm-7 col-xs-7">
      <div class="">Todos Los derechos reservados. Diseñado por <a href="http://dementecreativo.com/" target="_blank"> <img src="img/demente.png" alt="" /> </a></div></div>
    </div>
    <div class="footer-redes col-md-5 col-sm-5 col-xs-5">
      <div class="border-redes"><i class="fa fa-facebook"></i></div>
      <div class="border-redes"><i class="fa fa-twitter"></i></div>
      <div class="border-redes"><i class="fa fa-instagram"></i></div>
    </div>
  </footer>


  <div class="preloader1" id="preloader1"><img src="img/logo-parte1.png" alt="" /></div>
  <div class="preloader2" id="preloader2"><img src="img/logo-parte2.png" alt="" /></div>
  <div class="cortina1" id="cortina1"><img src="img/logo-parte1.png" alt="" /></div>
  <div class="cortina2" id="cortina2"><img src="img/logo-parte2.png" alt="" /></div>


    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/collapse.min.js"></script>
    <script src="js/script.js"></script>
    <script src='js/wow.min.js'></script>
    <script>new WOW().init();</script>

		<script type="text/javascript">
			$('#enviar-btnUser').click(function() {
				if ($('#pw').val() !=  $('#pw2').val()) {
					$('.error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>ERROR!</strong> La Contraseña no coinside.</div>');
					return false;
				} else {
					$.ajax({
						type: "POST",
						url: "controladores/RegistrarUser.php",
						data: $('#register-form').serialize(),
						success: function(respuesta) {
							console.log(respuesta);
							if (respuesta == 1) {
								window.location.assign("ingresar.php");
							} else {
								$('.error').html('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>ERROR!</strong> Usuario ya existente.</div>');
							}
						}
					});
					return false;
				}
			});

			$('.boton .bot button.iniciar_seccion, .boton .bot button.registrarse').click(function(){
				if ($(this).hasClass('iniciar_seccion')) {
					$('#ingresar').removeClass('active');
				}else if ($(this).hasClass('registrarse')) {
					$('#ingresar').addClass('active');
				}
				return false;
			});
		</script>



    <!-- Script to Activate the Carousel -->


</body>

</html>
