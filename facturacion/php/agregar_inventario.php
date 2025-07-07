<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto - Inventario</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main style="max-width: 500px; margin: 60px auto; background: #1a1a1a; padding: 30px; border-radius: 10px; color: white;">
    <h2 style="color: #e30613; text-align: center;">Agregar Producto al Inventario</h2>
    <form action="php/guardar_inventario.php" method="POST">
      <input type="text" name="producto" placeholder="Nombre del producto" required>
      <input type="text" name="tipo" placeholder="Tipo (aceite, filtro...)" required>
      <input type="number" name="cantidad" placeholder="Cantidad" min="1" required>
      <input type="number" name="precio" placeholder="Precio unitario" step="0.001" min="1" value="10" required>
      <button type="submit">Guardar</button>
    </form>
    <p style="text-align: center; margin-top: 15px;"><a href="inventario.php" style="color:#e30613;">← Volver al Inventario</a></p>
  </main>
</body>
</html>
