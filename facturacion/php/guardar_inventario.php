<?php
session_start();
include "conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Validar campos
$producto = $_POST['producto'] ?? '';
$tipo     = $_POST['tipo'] ?? '';
$cantidad = $_POST['cantidad'] ?? 0;
$precio   = $_POST['precio'] ?? 0.0;
$fecha    = date("Y-m-d");

if ($producto && $tipo && $cantidad > 0 && $precio > 0) {
    $sql = "INSERT INTO inventario (producto, tipo, cantidad, precio, fecha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssids", $producto, $tipo, $cantidad, $precio, $fecha);
    $stmt->execute();
    echo "<script>alert('✅ Producto agregado al inventario.'); window.location='../inventario.php';</script>";
} else {
    echo "<script>alert('❌ Datos inválidos.'); window.location='../agregar_inventario.php';</script>";
}
