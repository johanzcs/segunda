<?php
include "conexion.php";
if (!isset($_GET['id'])) {
    die("ID de factura no proporcionado.");
}
$id = intval($_GET['id']);
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
$xml = new DOMDocument("1.0", "UTF-8");
$xml->formatOutput = true;
$raiz = $xml->createElement("FacturaElectronica");
$raiz = $xml->appendChild($raiz);
$emisor = $xml->createElement("Emisor");
$emisor->appendChild($xml->createElement("Nombre", "Aceicar SAS"));
$emisor->appendChild($xml->createElement("NIT", "901234567-8"));
$emisor->appendChild($xml->createElement("Direccion", "Cúcuta, Colombia"));
$raiz->appendChild($emisor);
$receptor = $xml->createElement("Receptor");
$receptor->appendChild($xml->createElement("Nombre", $factura['nombre'] . " " . $factura['apellido']));
$receptor->appendChild($xml->createElement("Correo", $factura['correo']));
$raiz->appendChild($receptor);
$detalle = $xml->createElement("DetalleFactura");
$detalle->appendChild($xml->createElement("TipoCarro", $factura['tipo_carro']));
$detalle->appendChild($xml->createElement("Placa", $factura['placa']));
$detalle->appendChild($xml->createElement("Producto", $factura['aceite']));
$detalle->appendChild($xml->createElement("Cantidad", $factura['cantidad']));
$detalle->appendChild($xml->createElement("MetodoPago", $factura['metodo_pago']));
$detalle->appendChild($xml->createElement("Fecha", $factura['fecha']));
$raiz->appendChild($detalle);
$totales = $xml->createElement("Totales");
$totales->appendChild($xml->createElement("ValorTotal", number_format($factura['total'], 2, '.', '')));
$totales->appendChild($xml->createElement("PagoCliente", number_format($factura['pago_cliente'], 2, '.', '')));
$totales->appendChild($xml->createElement("Cambio", number_format($factura['cambio'], 2, '.', '')));
$raiz->appendChild($totales);
$nombre_archivo = "factura_" . $factura['id_facturas'] . ".xml";
header("Content-type: text/xml");
header("Content-Disposition: inline; filename=\"$nombre_archivo\"");
echo $xml->saveXML();
?>
