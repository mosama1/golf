<?php

class maquetar{

public function header($marca){

  if ($marca == "index") {

    echo "
    <!DOCTYPE html>
    <html lang='es'>

    <head>
        <link rel='shortcut icon' href='img/favicon.png' type='image/x-icon'>
        <link rel='icon' href='img/favicon.png' type='image/x-icon'>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content=''>
        <meta name='author' content=''>


        <title>Avila Fit Club</title>


        <link href='css/bootstrap.min.css' rel='stylesheet'>
        <link href='css/style.css' rel='stylesheet'>
        <link href='css/animate.css' rel='stylesheet'>
        <link href='css/font-awesome.min.css' rel='stylesheet'>
        <link href='css/normalize.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>


    </head>

    <body id='$marca'>
    ";
  } #end IF

  if ($marca == "nosotros") {
    echo "<!DOCTYPE html>
    <html lang='es'>

    <head>
        <link rel='shortcut icon' href='img/favicon.png' type='image/x-icon'>
        <link rel='icon' href='img/favicon.png' type='image/x-icon'>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content=''>
        <meta name='author' content=''>


        <title>Avila Fit Club</title>


        <link href='css/bootstrap.min.css' rel='stylesheet'>
        <link href='css/style.css' rel='stylesheet'>
        <link href='css/animate.css' rel='stylesheet'>
        <link href='css/font-awesome.min.css' rel='stylesheet'>
        <link href='css/normalize.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,700,600italic,700italic,800,800italic' rel='stylesheet' type='text/css'>


    </head>

    <body id='$marca' class='img-responsive' style='background-image: url('img/fondo-$marca.jpg')'>";
  }


} #end function header


}

?>
