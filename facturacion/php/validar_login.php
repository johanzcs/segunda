<?php
session_start();
require_once "conexion.php";   // ← aquí se define $conn

$correo = $_POST['correo'] ?? '';
$clave  = $_POST['clave']  ?? '';

// 1. Busca al usuario
$sql  = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);  // ← usa $conn
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    // 2. Verifica la contraseña
    if (password_verify($clave, $usuario['clave'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['correo']  = $usuario['correo'];
        $_SESSION['rol']     = $usuario['rol'];

        // 3. Redirige según rol
        switch ($usuario['rol']) {
            case 'cliente':  header("Location: ../cliente.php");  break;
            case 'empleado': header("Location: ../empleado.php"); break;
            case 'admin':    header("Location: ../admin.php");    break;
        }
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.location='../login.php';</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado'); window.location='../login.php';</script>";
}
?>

