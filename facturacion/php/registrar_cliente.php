<?php
include "conexion.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);



// Recibir datos del formulario
$nombre   = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo   = $_POST['correo'] ?? '';
$clave    = $_POST['clave'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Verificar si el correo ya está registrado
$verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$verificar->bind_param("s", $correo);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>alert(' El correo ya está registrado.'); window.location='../register.html';</script>";
    exit;
}

// Encriptar la contraseña
$claveSegura = password_hash($clave, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, apellido, correo, clave, telefono) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $correo, $claveSegura, $telefono);
$registrado = $stmt->execute();

if ($registrado) {
    echo "<script>alert(' Registro exitoso. Ahora puedes iniciar sesión.'); window.location='../login.php';</script>";
} else {
    echo "<script>alert(' Error al registrar. Intenta de nuevo.'); window.location='../register.html';</script>";
}
?>

