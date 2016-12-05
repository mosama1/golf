<?php
session_start();
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

	$user_logout = new User();

	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('../index.html');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('../index.html');
	}
?>
