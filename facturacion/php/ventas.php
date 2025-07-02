<?php
session_start();
include "php/conexion.php";

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: login.php");
    exit;
}

$ventas = $conexion->query("SELECT * FROM ventas ORDER BY fecha DESC, hora DESC");
?>

<h2>Registro de Ventas</h2>

<table border="1" cellpadding="10" cellspacing="0" style="width:100%; background:#1a1a1a; color:white; border-collapse:collapse;">
  <tr style="background:#e30613;">
    <th>ID</th>
    <th>Producto</th>
    <th>Tipo Vehículo</th>
    <th>Cantidad</th>
    <th>Precio Unitario</th>
    <th>Total</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Método de pago</th>
  </tr>
  <?php while ($v = $ventas->fetch_assoc()): ?>
  <tr>
    <td><?= $v['id'] ?></td>
    <td><?= $v['producto'] ?></td>
    <td><?= $v['tipo'] ?></td>
    <td><?= $v['cantidad_vendida'] ?></td>
    <td>$<?= number_format($v['precio_unitario'], 3, ',', '.') ?></td>
    <td>$<?= number_format($v['total'], 3, ',', '.') ?></td>
    <td><?= $v['fecha'] ?></td>
    <td><?= $v['hora'] ?></td>
    <td><?= $v['metodo_pago'] ?></td>
  </tr>
  <?php endwhile; ?>
</table>
