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
$correo        = $_POST['correo'] ?? '';
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
    empty($correo) || empty($tipo_carro) || empty($placa) || empty($aceite) ||
    $cantidad <= 0 || $precio <= 0 || $pago_cliente < $precio
) {
    echo "<script>alert('⚠️ Verifica los campos. El pago debe ser mayor o igual al total.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}

// 1. Guardar factura
$sql = "INSERT INTO facturas 
        (correo, tipo_carro, placa, aceite, cantidad, total, pago_cliente, cambio, fecha, filtro, repuesto) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssidddsss", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio, $pago_cliente, $cambio, $fecha, $filtro, $repuesto);
$registrado = $stmt->execute();

// Si se guardó la factura, registrar en ventas y actualizar inventario
if ($registrado) {
    // 2. Calcular precio unitario para la tabla ventas
    $precio_unitario = $precio / $cantidad;

    // 3. Insertar venta
    $sql_venta = "INSERT INTO ventas 
                  (producto, tipo, cantidad_vendida, precio_unitario, total, fecha, hora, metodo_pago) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_venta = $conexion->prepare($sql_venta);
    $stmt_venta->bind_param("ssidssss", $aceite, $tipo_carro, $cantidad, $precio_unitario, $precio, $fecha, $hora, $metodo_pago);
    $stmt_venta->execute();

    // 4. Descontar del inventario
    $conexion->query("UPDATE inventario 
                      SET cantidad = cantidad - $cantidad 
                      WHERE nombre_producto = '$aceite' AND cantidad >= $cantidad 
                      LIMIT 1");

    // 5. Confirmación
    echo "<script>alert('✅ Factura registrada con éxito.'); window.location='../empleado.php?seccion=facturacion';</script>";
} else {
    echo "<script>alert('❌ Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>



