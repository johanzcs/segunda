<?php
include "conexion.php";
?>

<h2>Crear Factura</h2>

<form action="php/guardar_factura.php" method="POST" id="factura-form">
  <!-- Cliente -->
  <label>Cliente:</label>
  <select name="correo" required>
    <option value="">Selecciona un cliente</option>
    <?php
    $clientes = $conexion->query("SELECT correo, nombre FROM usuarios WHERE rol = 'cliente'");
    while ($cliente = $clientes->fetch_assoc()) {
      echo "<option value=\"{$cliente['correo']}\">{$cliente['nombre']} ({$cliente['correo']})</option>";
    }
    ?>
  </select>

  <!-- Vehículo -->
  <input type="text" name="tipo_carro" placeholder="Tipo de carro" required>
  <input type="text" name="placa" placeholder="Placa del vehículo" required>

  <!-- Producto (desde inventario) -->
  <label>Producto:</label>
  <select name="producto" required>
    <option value="">Seleccione producto</option>
    <?php
    $productos = $conexion->query("SELECT producto, cantidad FROM inventario WHERE cantidad > 0");
    while ($row = $productos->fetch_assoc()) {
      echo "<option value=\"{$row['producto']}\">{$row['producto']} (Disponibles: {$row['cantidad']})</option>";
    }
    ?>
  </select>

  <!-- Tipo de aceite (desde inventario) -->
  <label>Tipo de aceite:</label>
  <select name="aceite" required>
    <option value="">Seleccione tipo</option>
    <?php
    $tipos = $conexion->query("SELECT DISTINCT tipo FROM inventario WHERE cantidad > 0");
    while ($t = $tipos->fetch_assoc()) {
      echo "<option value=\"{$t['tipo']}\">{$t['tipo']}</option>";
    }
    ?>
  </select>

  <!-- Precio y Cantidad -->
  <input type="number" step="0.01" name="cantidad" placeholder="Cantidad" required>
  <input type="number" step="0.01" name="precio" placeholder="Precio total" id="precio" required>

  <!-- Método de pago -->
  <label>Método de pago:</label>
  <select name="metodo_pago" id="metodo_pago" required onchange="togglePagoCliente()">
    <option value="">Seleccione método</option>
    <option value="Efectivo">Efectivo</option>
    <option value="Nequi">Nequi</option>
    <option value="Daviplata">Daviplata</option>
    <option value="Bancolombia">Bancolombia</option>
  </select>

  <!-- Solo si es efectivo -->
  <div id="pago-efectivo" style="display:none;">
    <input type="number" step="0.01" name="pago_cliente" id="pago_cliente" placeholder="Pago del cliente">
    <button type="button" onclick="calcularCambio()">Calcular Cambio</button>
    <p id="cambio_texto"></p>
  </div>

  <!-- Filtro y Repuesto -->
  <label>Filtro cambiado:</label>
  <select name="filtro">
    <option value="No aplica">Sin cambio</option>
    <option value="Filtro de aceite">Filtro de aceite</option>
    <option value="Filtro de aire">Filtro de aire</option>
    <option value="Filtro de combustible">Filtro de combustible</option>
  </select>

  <label>Repuesto adicional:</label>
  <select name="repuesto">
    <option value="No aplica">Sin repuesto</option>
    <option value="Bujías">Bujías</option>
    <option value="Pastillas de freno">Pastillas de freno</option>
    <option value="Correa de repartición">Correa de repartición</option>
    <option value="Sensor de oxígeno">Sensor de oxígeno</option>
  </select>

  <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>">
  <input type="hidden" name="cambio" id="cambio_final" value="0">

  <button type="submit">Registrar Factura</button>
</form>

<script>
function togglePagoCliente() {
  const metodo = document.getElementById("metodo_pago").value;
  const pagoDiv = document.getElementById("pago-efectivo");
  if (metodo === "Efectivo") {
    pagoDiv.style.display = "block";
  } else {
    pagoDiv.style.display = "none";
    document.getElementById("pago_cliente").value = "";
    document.getElementById("cambio_texto").innerText = "";
  }
}

function calcularCambio() {
  const precio = parseFloat(document.getElementById("precio").value) || 0;
  const pago = parseFloat(document.getElementById("pago_cliente").value) || 0;
  const cambio = pago - precio;
  document.getElementById("cambio_texto").innerText = "Cambio: $" + cambio.toFixed(3);
  document.getElementById("cambio_final").value = cambio.toFixed(3);
}
</script>
