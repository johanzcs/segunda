<?php
require '../vendor/autoload.php'; // Asegúrate que esta ruta sea correcta

use Dompdf\Dompdf;
use Dompdf\Options;

include "conexion.php";

if (!isset($_GET['id'])) {
    die("ID de factura no proporcionado.");
}

$id = intval($_GET['id']);

// Consulta la factura
$sql = "SELECT f.*, u.nombre, u.apellido 
        FROM facturas f
        LEFT JOIN usuarios u ON f.fk_id_usuarios = u.id_usuarios
        WHERE f.id_facturas = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Factura no encontrada.");
}

$factura = $result->fetch_assoc();

// Configuración de dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// HTML con tabla
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 12px;
      color: #000;
      margin: 30px;
    }
    h2 {
      text-align: center;
      color: #e30613;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }
    th, td {
      border: 1px solid #999;
      padding: 8px 10px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .info {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <h2>Factura Electrónica - Aceicar SAS</h2>

  <div class="info">
    <strong>Factura ID:</strong> ' . $factura['id_facturas'] . '<br>
    <strong>Cliente:</strong> ' . $factura['nombre'] . ' ' . $factura['apellido'] . '<br>
    <strong>Correo:</strong> ' . $factura['correo'] . '<br>
    <strong>Fecha:</strong> ' . $factura['fecha'] . '<br>
  </div>

  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Tipo de carro</th>
        <th>Placa</th>
        <th>Cantidad</th>
        <th>Método de pago</th>
        <th>Total</th>
        <th>Pago cliente</th>
        <th>Cambio</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>' . $factura['aceite'] . '</td>
        <td>' . $factura['tipo_carro'] . '</td>
        <td>' . $factura['placa'] . '</td>
        <td>' . $factura['cantidad'] . '</td>
        <td>Efectivo</td>
        <td>$' . number_format($factura['total'], 0, ',', '.') . '</td>
        <td>$' . number_format($factura['pago_cliente'], 0, ',', '.') . '</td>
        <td>$' . number_format($factura['cambio'], 0, ',', '.') . '</td>
      </tr>
    </tbody>
  </table>
</body>
</html>
';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Mostrar el PDF en navegador
$dompdf->stream("factura_{$factura['id_facturas']}.pdf", ["Attachment" => false]);
?>
