
<?php
session_start();
include "conexion.php";

// Obtener datos del formulario
$correo = $_POST['correo'] ?? '';
$clave = $_POST['clave'] ?? '';

// Buscar el usuario por correo
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // Verificar clave
    if ($clave === $usuario['clave']) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según el rol
        switch ($usuario['rol']) {
            case 'cliente':
                header("Location: ../cliente.html");
                break;
            case 'empleado':
                header("Location: ../empleado.html");
                break;
            case 'admin':
                header("Location: ../panel_admin.html");
                break;
        }
        exit;
    } else {
        echo "⚠️ Contraseña incorrecta";
    }
} else {
    echo "⚠️ Usuario no encontrado";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Aceicar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    .formulario {
      max-width: 400px;
      margin: 80px auto;
      background: #1a1a1a;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(227, 6, 19, 0.3);
    }
    .formulario h2 {
      text-align: center;
      color: #e30613;
      margin-bottom: 20px;
    }
    .tabs {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .tabs button {
      flex: 1;
      padding: 10px;
      background: #333;
      color: white;
      border: none;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }
    .tabs button.active {
      background: #e30613;
    }
    form input, form button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
    }
    form input {
      background-color: #333;
      color: white;
    }
    form button {
      background: #e30613;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    form button:hover {
      background: #b0000b;
    }
  </style>
</head>
<body>
  <main class="formulario">
    <h2>Iniciar Sesión</h2>

    <div class="tabs">
      <button type="button" class="active" onclick="seleccionarRol('cliente', this)">Cliente</button>
      <button type="button" onclick="seleccionarRol('empleado', this)">Empleado</button>
      <button type="button" onclick="seleccionarRol('admin', this)">Administrador</button>
    </div>

    <form action="php/validar_login.php" method="POST">
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="clave" placeholder="Contraseña" required>
      <input type="hidden" name="rol" id="rol" value="cliente">
      <button type="submit">Entrar</button>
    </form>
  </main>

  <script>
    function seleccionarRol(rol, boton) {
      document.getElementById('rol').value = rol;
      document.querySelectorAll('.tabs button').forEach(btn => btn.classList.remove('active'));
      boton.classList.add('active');
    }
  </script>
</body>
</html>



