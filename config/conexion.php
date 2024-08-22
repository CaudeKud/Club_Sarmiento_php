<?php
$servidor = "localhost";
$usuario = "adminsarmiento";
$contrasena = "adminsarmiento123";
$basededatos = "sarmiento";

$conexion = mysqli_connect($servidor, $usuario, $contrasena) or die("No se conecto al servidor");

$db = mysqli_select_db($conexion, $basededatos) or die("No se conecto a la base");
