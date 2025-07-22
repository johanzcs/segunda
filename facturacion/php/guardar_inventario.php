<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conexión
    require_once "conexion.php"; // Asegúrate que este archivo define correctamente $conn

    // Obtener y sanitizar datos
    $producto = trim($_POST['producto']);
    $tipo = trim($_POST['tipo']);
    $cantidad = intval($_POST['cantidad']);
    $precio = floatval($_POST['precio']); // Asegura que sea número sin coma

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO inventario (producto, tipo, cantidad, precio, fecha) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssii", $producto, $tipo, $cantidad, $precio);

    if ($stmt->execute()) {
        header("Location: ../inventario.php");
        exit;
    } else {
        echo "Error al guardar: " . $conn->error;
    }
}
?>
