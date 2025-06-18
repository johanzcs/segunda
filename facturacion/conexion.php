<?php
$host = "localhost";      // o 127.0.0.1
$usuario = "root";        // usuario por defecto en XAMPP o Laragon
$clave = "";              // usualmente sin contraseña en local
$bd = "aceicar";          // nombre de tu base de datos

$conexion = new mysqli($host, $usuario, $clave, $bd);

// Verificar si hay error de conexión
if ($conexion->connect_error) {
    die("❌ Error al conectar con la base de datos: " . $conexion->connect_error);
}
?>
