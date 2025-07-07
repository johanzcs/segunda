<?php
session_start();
date_default_timezone_set('America/Bogota'); 
include "conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verificar sesión
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: ../login.php");
    exit;
}

// Recibir datos
$correo        = $_POST['correo'] ?? '';
$producto      = $_POST['producto'] ?? '';
$tipo_carro    = $_POST['tipo_carro'] ?? '';
$placa         = $_POST['placa'] ?? '';
$aceite        = $_POST['aceite'] ?? '';
$cantidad      = $_POST['cantidad'] ?? 0;
$precio        = $_POST['precio'] ?? 0.0;
$metodo_pago   = $_POST['metodo_pago'] ?? 'Efectivo';
$pago_cliente  = $_POST['pago_cliente'] ?? 0.0;
$fecha         = $_POST['fecha'] ?? date("Y-m-d");
$filtro        = $_POST['filtro'] ?? 'No aplica';
$repuesto      = $_POST['repuesto'] ?? 'No aplica';
$hora          = date("H:i:s");
$cambio        = $pago_cliente - $precio;

// Validación básica
if (
    empty($correo) || empty($producto) || empty($tipo_carro) || empty($placa) || empty($aceite) ||
    $cantidad <= 0 || $precio <= 0 || $pago_cliente < $precio
) {
    echo "<script>alert(' Verifica los campos. El pago debe ser mayor o igual al total.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}

// Verificar existencia en inventario
$verificar = $conexion->prepare("SELECT cantidad FROM inventario WHERE producto = ? AND tipo = ? AND cantidad >= ?");
$verificar->bind_param("ssi", $producto, $aceite, $cantidad);
$verificar->execute();
$res = $verificar->get_result();
if ($res->num_rows === 0) {
    echo "<script>alert(' No hay suficiente inventario para este producto y tipo.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}

// 1. Insertar factura
$sql = "INSERT INTO facturas 
        (correo, tipo_carro, placa, aceite, cantidad, total, pago_cliente, cambio, fecha, filtro, repuesto) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssidddsss", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio, $pago_cliente, $cambio, $fecha, $filtro, $repuesto);
$registrado = $stmt->execute();

if ($registrado) {
    
    $precio_unitario = $precio / $cantidad;

    
    $sql_venta = "INSERT INTO ventas 
                  (producto, tipo, cantidad_vendida, precio, total, fecha, hora, metodo_pago) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_venta = $conexion->prepare($sql_venta);
    $stmt_venta->bind_param("ssidssss", $producto, $aceite, $cantidad, $precio_unitario, $precio, $fecha, $hora, $metodo_pago);
    $stmt_venta->execute();

    // 4. Actualizar inventario
    $sql_update = "UPDATE inventario 
                   SET cantidad = cantidad - ? 
                   WHERE producto = ? AND tipo = ? AND cantidad >= ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("issi", $cantidad, $producto, $aceite, $cantidad);
    $stmt_update->execute();

    
    echo "<script>window.location='../empleado.php?seccion=facturacion';</script>";
} else {
    echo "<script>alert(' Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>




