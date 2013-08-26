<?php
	$usuario = $_GET['user'];
	$pass = $_GET['pass'];
	session_start();
	include("../Class/ClaseConexion.inc.php");
	include("../Class/class.usuarios.php");

	$con = new ClaseConexion();
	$con->Conectar();

   	$array = array(
    "usuario" => $usuario,
    "estado" => 0,
	);

   	$_SESSION['nombre_usuario'] = "Alejandro Rodriguez Peña";


	echo json_encode($array);
?>