<?php
session_start();
include "conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar que el usuario tenga sesión y sea empleado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: ../login.php");
    exit;
}

// Recibir datos del formulario
$correo     = $_POST['correo'] ?? '';
$tipo_carro = $_POST['tipo_carro'] ?? '';
$placa      = $_POST['placa'] ?? '';
$aceite     = $_POST['aceite'] ?? '';
$cantidad   = $_POST['cantidad'] ?? 0;
$precio     = $_POST['precio'] ?? 0;
$fecha      = date("Y-m-d");

// Validación básica
if (empty($correo) || empty($tipo_carro) || empty($placa) || empty($aceite) || $cantidad <= 0 || $precio <= 0) {
    echo "<script>alert(' Por favor completa todos los campos correctamente.'); window.location='../empleado.php';</script>";
    exit;
}

// Insertar en la base de datos
$sql = "INSERT INTO facturas (correo, tipo_carro, placa, aceite, cantidad, total, fecha)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssids", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio, $fecha);
$registrado = $stmt->execute();

if ($registrado) {
    echo "<script>alert(' Factura registrada con éxito.'); window.location='../empleado.php';</script>";
} else {
    echo "<script>alert(' Error al guardar la factura.'); window.location='../empleado.php';</script>";
}
?>
