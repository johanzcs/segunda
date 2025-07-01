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
$metodo_pago = $_POST['metodo_pago'];
$pago_cliente = $_POST['pago_cliente'] ?? 0;
$cambio = $_POST['cambio'] ?? 0;
$cambio     = $pago_cliente - $precio;
$fecha      = $_POST['fecha'] ?? date("Y-m-d");
$filtro     = $_POST['filtro'] ?? 'No aplica';
$repuesto   = $_POST['repuesto'] ?? 'No aplica';

// Validación básica
if (empty($correo) || empty($tipo_carro) || empty($placa) || empty($aceite) || $cantidad <= 0 || $precio <= 0 || $pago_cliente < $precio) {
    header("Location: ../empleado.php?seccion=facturacion");
    exit;

}

// Inserta en la base de datos
$sql = "INSERT INTO facturas (correo, tipo_carro, placa, aceite, cantidad, total, pago_cliente, cambio, fecha, filtro, repuesto)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssidddsss", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio, $pago_cliente, $cambio, $fecha, $filtro, $repuesto);
$registrado = $stmt->execute();

// Mensaje final
if ($registrado) {
    echo "<script>alert('✅ Factura registrada. Cambio a devolver: $" . number_format($cambio, 0, ',', '.') . "'); window.location='../empleado.php?seccion=facturacion';</script>";
} else {
    echo "<script>alert('❌ Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>


