<?php
session_start();
date_default_timezone_set('America/Bogota');
require '../vendor/autoload.php';
include "conexion.php";

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verificar sesión
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['empleado', 'admin'])) {
    header("Location: login.php");
    exit;
}

// Recibir datos del formulario
$correo        = $_POST['correo'] ?? '';
$producto_raw  = $_POST['producto_aceite'] ?? '';
$tipo_carro    = $_POST['tipo_carro'] ?? '';
$placa         = $_POST['placa'] ?? '';
$cantidad      = intval($_POST['cantidad'] ?? 0);
$precio_total  = floatval($_POST['precio'] ?? 0);
$metodo_pago   = "Efectivo"; // Forzado como efectivo
$pago_cliente  = floatval($_POST['pago_cliente'] ?? 0);
$fecha         = $_POST['fecha'] ?? date("Y-m-d");
$hora          = date("H:i:s");

// Descomponer producto
list($producto, $aceite, $precio_unitario) = explode('|', $producto_raw);

// Calcular cambio
$cambio = $pago_cliente - $precio_total;

if (empty($correo) || empty($producto) || empty($tipo_carro) || empty($placa) || empty($aceite) || $cantidad <= 0 || $precio_total <= 0) {
    echo "<script>alert('Campos obligatorios incompletos.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}

// Obtener ID del usuario
$stmt_user = $conn->prepare("SELECT id_usuarios FROM usuarios WHERE correo = ?");
$stmt_user->bind_param("s", $correo);
$stmt_user->execute();
$res_user = $stmt_user->get_result();

if ($res_user->num_rows === 0) {
    echo "<script>alert('Usuario no encontrado.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}
$id_usuario = $res_user->fetch_assoc()['id_usuarios'];

// Obtener ID del inventario
$stmt_inv = $conn->prepare("SELECT id_inventario, cantidad FROM inventario WHERE producto = ? AND tipo = ? AND cantidad >= ?");
$stmt_inv->bind_param("ssi", $producto, $aceite, $cantidad);
$stmt_inv->execute();
$res_inv = $stmt_inv->get_result();

if ($res_inv->num_rows === 0) {
    echo "<script>alert('No hay suficiente inventario.'); window.location='../empleado.php?seccion=facturacion';</script>";
    exit;
}
$inv_data = $res_inv->fetch_assoc();
$id_inventario = $inv_data['id_inventario'];

// Insertar factura
$sql = "INSERT INTO facturas 
(correo, tipo_carro, placa, aceite, cantidad, total, pago_cliente, cambio, fecha, metodo_pago, fk_id_usuarios, fk_id_inventario) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssidddsiii", $correo, $tipo_carro, $placa, $aceite, $cantidad, $precio_total, $pago_cliente, $cambio, $fecha, $metodo_pago, $id_usuario, $id_inventario);
$registrado = $stmt->execute();

if ($registrado) {
    $id_factura = $conn->insert_id;

    // Registrar venta
    $empleado = $_SESSION['usuario'];
    $stmt_venta = $conn->prepare("INSERT INTO ventas (producto, tipo, cantidad_vendida, precio, total, fecha, hora, metodo_pago, empleado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt_venta->bind_param("ssidsssss", $producto, $aceite, $cantidad, $precio_unitario, $precio_total, $fecha, $hora, $metodo_pago, $empleado);
    $stmt_venta->execute();

    // Actualizar inventario
    $stmt_update = $conn->prepare("UPDATE inventario SET cantidad = cantidad - ? WHERE id_inventario = ?");
    $stmt_update->bind_param("ii", $cantidad, $id_inventario);
    $stmt_update->execute();

    // 🧾 Generar PDF
    $html = "
    <h2 style='text-align:center;'>Factura Electrónica - Aceicar</h2>
    <table style='width:100%; border-collapse: collapse;' border='1'>
        <tr><th>Cliente</th><td>{$correo}</td></tr>
        <tr><th>Tipo de Carro</th><td>{$tipo_carro}</td></tr>
        <tr><th>Placa</th><td>{$placa}</td></tr>
        <tr><th>Producto</th><td>{$producto} - {$aceite}</td></tr>
        <tr><th>Cantidad</th><td>{$cantidad}</td></tr>
        <tr><th>Total</th><td>$" . number_format($precio_total, 0, ',', '.') . "</td></tr>
        <tr><th>Pago del Cliente</th><td>$" . number_format($pago_cliente, 0, ',', '.') . "</td></tr>
        <tr><th>Cambio</th><td>$" . number_format($cambio, 0, ',', '.') . "</td></tr>
        <tr><th>Método de Pago</th><td>{$metodo_pago}</td></tr>
        <tr><th>Fecha</th><td>{$fecha}</td></tr>
    </table>";

    $pdf = new Dompdf();
    $pdf->loadHtml($html);
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    // Crear carpeta si no existe
    $carpeta = __DIR__ . "/facturas";
    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $ruta_pdf = $carpeta . "/factura_{$id_factura}.pdf";
    file_put_contents($ruta_pdf, $pdf->output());

    // 📩 Enviar correo
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sebaszambranoc3@gmail.com'; // Tu correo Gmail
        $mail->Password   = 'rdso rexw vuen hqsh';       // Tu contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('sebaszambranoc3@gmail.com', 'Aceicar');
        $mail->addAddress($correo);

        $mail->isHTML(true);
        $mail->Subject = 'Factura electrónica - Aceicar';
        $mail->Body    = 'Gracias por tu compra. Adjuntamos tu factura.';
        $mail->addAttachment($ruta_pdf);

        $mail->send();

        // ✅ Éxito
        $destino = ($_SESSION['rol'] === 'admin') ? '../admin.php?seccion=facturacion' : '../empleado.php?seccion=facturacion';
        echo "<script>alert('✅ Factura registrada y enviada al correo.'); window.location='$destino';</script>";

    } catch (Exception $e) {
        echo "<script>alert('❌ Error al enviar el correo: {$mail->ErrorInfo}'); window.location='../empleado.php?seccion=facturacion';</script>";
        exit;
    }

} else {
    echo "<script>alert('Error al guardar la factura.'); window.location='../empleado.php?seccion=facturacion';</script>";
}
?>







