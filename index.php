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
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="icon" href="../img/favicon.png" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Avila Fit Club</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/hint.css/2.4.0/hint.min.css" rel="stylesheet" type='text/css'>
    <!-- <link href="../css/normalize.css" rel="stylesheet"> -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="img-responsive" style="background-image: url('img/fondos/index.jpg')">
	<div id="index">
		<div class="nosotros ">
			<div class="ingresar active" id="ingresar">
				<center>
					<div class="form ">
						<form action="" class="form-signin" method="post" id="login-form">
							<div class="usuario input ">
								<div class="inp ">
									<!-- <label for="email">USUARIO&nbsp;&nbsp;</label> -->
									<input type="email" name="Usuario" class="form-control" id="email" placeholder="USUARIO">
								</div>
							</div>
							<div class="password input ">
								<div class="inp ">
									<!-- <label for="pwd">PASSWORD&nbsp;&nbsp;</label> -->
									<input type="password" name="Password" class="form-control" id="pwd" placeholder="PASSWORD">
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
			<div class="ingresar none" id="registrarse">
				<center>
					<div class="form ">
						<div class="error">

						</div>
						<form action="" class="form-signin" method="post" id="register-form">

							<div class="usuario input ">
								<div class="inp ">
									<!-- <label for="email">Nombre&nbsp;&nbsp;</label> -->
									<input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre">
								</div>
							</div>
							<div class="password input ">
								<div class="inp ">
									<!-- <label for="pwd">APELLIDO&nbsp;&nbsp;</label> -->
									<input type="text" name="apellido" class="form-control" id="apellido" placeholder="APELLIDO">
								</div>
							</div>
							<div class="usuario input cedula">
								<div class="inp ">
									<!-- <label for="pwd">CEDULA&nbsp;&nbsp;</label> -->
									<select  name="codCedula">
										<option value='V' selected>V</option>
										<option value='E'>E</option>
									</select>
									<input type="text" name="cedula" class="form-control" id="pwd" placeholder="CEDULA">
								</div>
							</div>

							<div class="password input ">
								<div class="inp ">
									<!-- <label for="email">TELEFONO&nbsp;&nbsp;</label> -->
									<input type="text" name="telefono" class="form-control" id="telefono" placeholder="TELEFONO">
								</div>
							</div>
							<div class="usuario input ">
								<div class="inp ">
									<!-- <label for="pwd">CORREO&nbsp;&nbsp;</label> -->
									<input type="email" name="email" class="form-control" id="email" placeholder="CORREO">
								</div>
							</div>
							<div class="password input ">
								<div class="inp ">
									<!-- <label for="email">PASSWORD&nbsp;&nbsp;</label> -->
									<input type="password" name="pw" class="form-control" id="pw" placeholder="PASSWORD">
								</div>
							</div>
							<div class="usuario input ">
								<div class="inp ">
									<!-- <label for="pwd">CONFIRMAR&nbsp;&nbsp;</label> -->
									<input type="password" name="pw2" class="form-control" id="pw2" placeholder="CONFIRMAR">
								</div>
							</div>
							<div class="boton">
								<div class="bot">
									<button name="enviar-btnUser" id="enviar-btnUser" class="waves-effect waves-brown" >Guardar</button>
								</div>
								<div class="bot">
									<button type="submit" name="" id="" class="waves-effect waves-brown ingresar_">
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
	</div>



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

			$('.boton .bot button.ingresar_, .boton .bot button.registrarse').click(function(){
				if ($(this).hasClass('ingresar_')) {
					$('#ingresar').removeClass('none');
					$('.nosotros .ingresar').removeClass('active');
					setTimeout(function(){
						$('#ingresar').addClass('active');
						$('#registrarse').removeClass('none');
					},500);
				}else if ($(this).hasClass('registrarse')) {
					$('#registrarse').removeClass('none');
					$('.nosotros .ingresar').removeClass('active');
					setTimeout(function(){
						$('#registrarse').addClass('active');
						$('#ingresar').removeClass('none');
					},500);
				}
				return false;
			});
		</script>



    <!-- Script to Activate the Carousel -->


</body>

</html>
