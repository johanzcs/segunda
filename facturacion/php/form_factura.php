<?php
include "conexion.php";
?>

<h2>Crear Factura</h2>

<form action="php/guardar_factura.php" method="POST">
  <!-- Selección de cliente -->
  <label for="correo">Cliente:</label>
  <select name="correo" required>
    <option value="">Selecciona un cliente</option>
    <?php
    $clientes = $conexion->query("SELECT correo, nombre FROM usuarios WHERE rol = 'cliente'");
    while ($cliente = $clientes->fetch_assoc()) {
      echo "<option value=\"{$cliente['correo']}\">{$cliente['nombre']} ({$cliente['correo']})</option>";
    }
    ?>
  </select>

  <!-- Datos del vehículo -->
  <input type="text" name="tipo_carro" placeholder="Tipo de carro" required>
  <input type="text" name="placa" placeholder="Placa del vehículo" required>

  <!-- Tipo de aceite -->
  <label for="aceite">Tipo de aceite:</label>
  <select name="aceite" required>
    <option value="">Selecciona aceite</option>
    <option value="10W-40">10W-40</option>
    <option value="5W-30">5W-30</option>
    <option value="15W-50">15W-50</option>
  </select>

  <input type="number" name="cantidad" placeholder="Cantidad" required>
  <input type="number" step="0.01" name="precio" placeholder="Precio total" required>

  <!-- Filtro -->
  <label for="filtro">Filtro cambiado:</label>
  <select name="filtro">
    <option value="No aplica">Sin cambio</option>
    <option value="Filtro de aceite">Filtro de aceite</option>
    <option value="Filtro de aire">Filtro de aire</option>
    <option value="Filtro de combustible">Filtro de combustible</option>
  </select>

  <!-- Repuesto -->
  <label for="repuesto">Repuesto adicional:</label>
  <select name="repuesto">
    <option value="No aplica">Sin repuesto</option>
    <option value="Bujías">Bujías</option>
    <option value="Pastillas de freno">Pastillas de freno</option>
    <option value="Correa de repartición">Correa de repartición</option>
    <option value="Sensor de oxígeno">Sensor de oxígeno</option>
  </select>

  <!-- Fecha automática -->
  <input type="hidden" name="fecha" value="<?php echo date('Y-m-d'); ?>">

  <!-- Botón -->
  <button type="submit">Registrar Factura</button>
</form>
