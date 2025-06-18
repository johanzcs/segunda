<?php
session_start();

// Validar si hay sesión activa y si el rol es cliente
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Cliente - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    .panel {
      max-width: 800px;
      margin: 60px auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 15px;
      color: white;
      box-shadow: 0 0 20px rgba(227, 6, 19, 0.3);
    }

    .panel h2 {
      color: #e30613;
      margin-bottom: 20px;
      text-align: center;
    }

    .btn-salir {
      display: block;
      width: 100%;
      text-align: center;
      padding: 10px;
      background: #e30613;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      text-decoration: none;
      margin-top: 20px;
    }

    .btn-salir:hover {
      background: #b0000b;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h2>
    <p>Este es tu panel como <strong>cliente</strong>. Aquí podrás consultar tus facturas y tu historial de compras próximamente.</p>

    <a class="btn-salir" href="php/cerrar_sesion.php">Cerrar sesión</a>
  </div>
</body>
</html>

