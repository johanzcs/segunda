<?php
session_start();
include "conexion.php";


$id = $_GET['id'] ?? 0;

if (!$id) {
    exit("ID de factura inválido.");
}

$sql = "SELECT * FROM facturas WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$factura = $result->fetch_assoc();

if (!$factura) {
    exit("Factura no encontrada.");
}

// Crear XML
$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;

$root = $xml->createElement("Factura");
$xml->appendChild($root);

foreach ($factura as $clave => $valor) {
    $elemento = $xml->createElement($clave, htmlspecialchars($valor));
    $root->appendChild($elemento);
}

// Guardar XML en disco
$archivo = "../facturas_xml/factura_" . $factura['id'] . ".xml";
$xml->save($archivo);

// Mostrar en navegador
header('Content-type: text/xml');
echo $xml->saveXML();
?>
