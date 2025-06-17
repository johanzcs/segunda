<?php
session_start();

// Simulación de base de datos
$usuarios = [
    'cliente1' => ['clave' => '1234', 'rol' => 'cliente'],
    'empleado1' => ['clave' => 'admin123', 'rol' => 'empleado'],
    'admin1' => ['clave' => 'admin456', 'rol' => 'admin']
];

$usuario = $_POST['usuario'] ?? '';
$clave = $_POST['clave'] ?? '';
$rol = $_POST['rol'] ?? '';

if (isset($usuarios[$usuario]) && $usuarios[$usuario]['clave'] === $clave && $usuarios[$usuario]['rol'] === $rol) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $rol;

    // Redirigir según el rol
    switch ($rol) {
        case 'cliente':
            header("Location: ../panel_cliente.php");
            break;
        case 'empleado':
            header("Location: ../panel_empleado.php");
            break;
        case 'admin':
            header("Location: ../panel_admin.php");
            break;
    }
    exit;
} else {
    echo "<p style='color: red; text-align: center;'>Credenciales incorrectas o rol inválido.</p>";
    echo "<p style='text-align: center;'><a href='../login.php'>Volver</a></p>";