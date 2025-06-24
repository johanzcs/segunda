<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$correo = $_SESSION['correo'] ?? ''; // debe guardarse en login.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel del Cliente - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      background-color: #111;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      padding: 40px;
    }

    .panel {
      max-width: 800px;
      margin: auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(227, 6, 19, 0.3);
    }

    h2 {
      color: #e30613;
      text-align: center;
    }

    form {
      margin-top: 20px;
      text-align: center;
    }

    select, button {
      padding: 8px 12px;
      margin: 0 5px;
      border-radius: 6px;
      border: none;
    }

    .facturas {
      margin-top: 30px;
    }

    .factura-item {
      background: #222;
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 10px;
    }

    .btn-cerrar {
      display: inline-block;
      margin-top: 30px;
      background: #e30613;
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="panel">
    <h2>Bienvenido, <?php echo htmlspecialchars($usuario); ?></h2>
    <p>Consulta tus facturas por mes y año.</p>

    <form method="GET">
      <select name="mes" required>
        <option value="">Mes</option>
        <?php
          for ($m = 1; $m <= 12; $m++) {
            printf('<option value="%02d">%02d</option>', $m, $m);
          }
        ?>
      </select>

      <select name="anio" required>
        <option value="">Año</option>
        <?php
          for ($y = 2023; $y <= date("Y"); $y++) {
            echo "<option value=\"$y\">$y</option>";
          }
        ?>
      </select>

      <button type="submit">Buscar</button>
    </form>

    <div class="facturas">
      <h3>Facturas:</h3>
      <?php
      include "php/conexion.php";
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

      $sql = "SELECT * FROM facturas WHERE correo = ?";
      if (isset($_GET['mes']) && isset($_GET['anio'])) {
        $sql .= " AND MONTH(fecha) = ? AND YEAR(fecha) = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sii", $correo, $_GET['mes'], $_GET['anio']);
      } else {
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $correo);
      }

      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        while ($factura = $result->fetch_assoc()) {
          echo "<div class='factura-item'>";
          echo "<strong>Factura ID:</strong> {$factura['id']}<br>";
          echo "<strong>Fecha:</strong> {$factura['fecha']}<br>";
          echo "<strong>Total:</strong> $" . number_format($factura['total'], 0, ',', '.') . "<br>";
          echo "</div>";
        }
      } else {
        echo "<p>No se encontraron facturas para este período.</p>";
      }
      ?>
    </div>

    <a class="btn-cerrar" href="index.php">Cerrar Sesión</a>
  </div>
</body>
</html>

