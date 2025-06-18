<?php
include "conexion.php";

// Recibir datos del formulario
$nombre   = $_POST['nombre'] ?? '';
$apellido = $_POST['apellido'] ?? '';
$correo   = $_POST['correo'] ?? '';
$clave    = $_POST['clave'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Validar que no exista el correo
$verificar = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$verificar->bind_param("s", $correo);
$verificar->execute();
$resultado = $verificar->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>alert('⚠️ El correo ya está registrado.'); window.location='../register.html';</script>";
    exit;
}

// Insertar el nuevo cliente (rol por defecto = cliente)
$sql = "INSERT INTO usuarios (nombre, apellido, correo, clave, telefono) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido, $correo, $clave, $telefono);
$registrado = $stmt->execute();

if ($registrado) {
    echo "<script>alert('✅ Registro exitoso. Ahora puedes iniciar sesión.'); window.location='../login.php';</script>";
} else {
    echo "<script>alert('❌ Error al registrar. Intenta de nuevo.'); window.location='../register.html';</script>";
}
?>
