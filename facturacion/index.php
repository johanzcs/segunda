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
      padding: 20px 20px;
    }

    img.logo {
      width: 240px;
      transition: transform 0.6s ease;
    }

    img.logo:hover {
      transform: scale(1.12) rotate(24deg);
    }

    h1 {
      color: #e30613;
      font-size: 42px;
      margin: 20px 0;
    }

    p {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .botones {
      display: flex;
      justify-content: center;
      gap: 40px;
      margin-bottom: 100px;
      
    }

    .botones a {
      background-color: #e30613;
      color: white;
      padding: 20px 35px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 20px;
      transition: transform 0.12s ease, background 0.3s;
      
      
    }

    .botones a:hover {
      background-color: #b05800ff;
      transform: scale(1.10);
    }

    .galeria {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      margin-bottom: 50px;
    }

    .item {
      width: 240px;
      transition: transform 0.6s ease, box-shadow 0.6s ease;
    }

    .item img {
      width: 100%;
      border-radius: 20px;
    }

    .item:hover {
      transform: scale(1.2);
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
    }

    .item p {
      margin-top: 15px;
      font-size: 15px;
      color: #ccc;
    }

    @media (max-width: 769px) {
      .galeria {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

  <!-- Logo -->
  <img src="logoaceicar.jpeg" alt="Logo Aceicar" class="logo">

  <h1>Bienvenido a Aceicar</h1>
  <p>Gestión de facturación electrónica para clientes, empleados y administradores.</p>

  <!-- Botones -->
  <div class="botones">
    <a href="login.php">Iniciar Sesión</a>
    <a href="register.html">Registrarse</a>
  </div>

  <!-- Galería 1 -->
  <div class="galeria">
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2020/09/MOBIL-SPECIAL-HD_SAE-50-Photoroom.jpg" alt="Aceite 1">
      <p>Aceite SAE 50 Mobil special HD cuarto</p> <p>$26,900</p>
    </div>
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2020/09/MOBIL-SPECIAL_25W-50-Photoroom.jpg" alt="Aceite 2">
      <p>Aceite mobil 25w 50 alto kilometraje – cuarto</p><p>$27,900</p>
    </div>
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2024/07/10W-40-LUBRITEK-CUARTO_1-1-600x600.jpg" alt="Aceite 3">
      <p>Aceite 10w 40 Lubritek – Cuarto</p><p> $27,900</p>
    </div>
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2022/10/MOBIL-SUPER-2000_10W-30-Photoroom-1-600x600.jpg" alt="Aceite 4">
      <p>Aceite Mobil 10w 30 – super 2000 – cuarto</p><p> $30,900</p>
    </div>
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2023/09/Super_1000-20w-50.jpg" alt="Aceite 5">
      <p>Mobil Super 1000 20w 50</p><p>$30,900 </p>
    </div>
  </div>

  <!-- Galería 2 -->
  <div class="galeria">
    <div class="item">
      <img src="https://autopla1.b-cdn.net/wp-content/uploads/2025/02/601246AM-Mobil-Super-2000-5w30-600x600.webp" alt="Repuesto 1">
      <p>Mobil Super 2000 5w 30 CUARTO</p><p>$31,900</p>
    </div>
    <div class="item">
      <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/LUBULT-07-300x300.jpg" alt="Repuesto 2">
      <p>ACEITE 15W 40 LUBRITEK ULTIMATE CUARTO</p><p>$32,900</p>
    </div>
    <div class="item">
      <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/MOBIL-SUPER-2000x1_10W-40-Photoroom-300x300.jpg" alt="Repuesto 3">
      <p>Aceite 10w 40 Mobil 2000 – cuarto</p><p>$32,900</p>
    </div>
    <div class="item">
      <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/09/600088AM_1_zqphd1-300x300.jpg" alt="Repuesto 4">
      <p>Aceite delvac 15w40 – cuarto</p><p>$34,900</p>
    </div>
    <div class="item">
      <img src="https://www.autoplanet.com.co/wp-content/uploads/2020/10/LUBEVO03-300x300.jpg" alt="Repuesto 5">
      <p>ACEITE 20W 50 LUBRITEK EVO CUARTO</p><p>$34,900</p>
    </div>
  </div>

</body>
</html>
