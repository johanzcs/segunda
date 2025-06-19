<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Aceicar - Inicio</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #111;
      color: white;
      text-align: center;
      padding: 80px 20px;
    }

    h1 {
      color: #e30613;
      font-size: 42px;
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      margin-bottom: 40px;
    }

    .botones {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .botones a {
      background-color: #e30613;
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 10px;
      transition: background 0.3s;
    }

    .botones a:hover {
      background-color: #b0000b;
    }
  </style>
</head>
<body>

  <h1>Bienvenido a Aceicar</h1>
  <p>Gestión de facturación electrónica para clientes, empleados y administradores.</p>

  <div class="botones">
    <a href="login.php">Iniciar Sesión</a>
    <a href="register.html">Registrarse</a>
  </div>

</body>
</html>
