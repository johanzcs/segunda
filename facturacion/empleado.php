<?php
session_start();

// Solo permite acceso si es empleado
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: login.php");
    exit;
}

$empleado = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Empleado - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      background: #111;
      font-family: 'Segoe UI', sans-serif;
      color: white;
      padding: 40px;
    }

    .contenedor {
      max-width: 800px;
      margin: auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(227, 6, 19, 0.3);
    }

    h2 {
      text-align: center;
      color: #e30613;
    }

    form {
      margin-top: 20px;
    }

    input, select, button {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 6px;
      border: none;
      background: #333;
      color: white;
    }

    button {
      background-color: #e30613;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #b0000b;
    }
  </style>
</head>
<body>
  <div class="contenedor">
    <h2>Bienvenido, <?php echo htmlspecialchars($empleado); ?> - Crear Factura</h2>
    
    <form action="php/guardar_factura.php" method="POST">
      <input type="text" name="correo" placeholder="Correo del cliente" required />
      <input type="text" name="tipo_carro" placeholder="Tipo de carro" required />
      <input type="text" name="placa" placeholder="Placa del vehículo" required />
      <select name="aceite" required>
        <option value="">Tipo de aceite</option>
        <option value="10W-40">10W-40</option>
        <option value="5W-30">5W-30</option>
        <option value="15W-50">15W-50</option>
      </select>
      <input type="number" name="cantidad" placeholder="Cantidad" required />
      <input type="number" name="precio" placeholder="Precio total" required />
      <button type="submit">Generar Factura</button>
    </form>
  </div>
</body>
</html>
