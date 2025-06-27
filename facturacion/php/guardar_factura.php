<?php
session_start();
include "conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verifica si el usuario es empleado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: ../login.php");
    exit;
}

// Recibe datos del formulario
$correo     = $_POST['correo'] ?? '';
$tipo_carro = $_POST['tipo_carro'] ?? '';
$placa      = $_POST['placa'] ?? '';
$aceite     = $_POST['aceite'] ?? '';
$cantidad   = $_POST['cantidad'] ?? 0;
$precio     = $_POST['precio'] ?? 0;
$fecha      = $_POST['fecha'] ?? date("Y-m-d"); // ← viene desde input hidden
$filtro     = $_POST['filtro'] ?? 'No aplica';
$repuesto   = $_POST['repuesto'] ?? 'No aplica';

// Validación básica
if (empty($correo) || empty($tipo_carro) || empty($placa) || empty($aceite) || $cantidad <= 0 || $precio <= 0) {
    echo "<script>alert('Por favor completa todos los campos correctamente.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}

// Inserta en la base de datos
$sql = "INSERT INTO facturas (correo, tipo_carro, placa, aceite, cantidad, total, fecha, filtro, repuesto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssidsss", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio, $fecha, $filtro, $repuesto);
$registrado = $stmt->execute();

// Redirección
if ($registrado) {
    echo "<script>alert('Factura registrada con éxito.'); window.location='../empleado.php?seccion=facturacion';</script>";
} else {
    echo "<script>alert('Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>

