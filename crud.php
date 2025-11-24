<?php
// Conectar y crear DB/tabla si hace falta (opcional, seguro para pruebas)
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'AutoNova';

$conexion_temp = mysqli_connect($host, $user, $pass);
if (!$conexion_temp) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_query($conexion_temp, "CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
mysqli_close($conexion_temp);

$conexion = mysqli_connect($host, $user, $pass, $db);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// crear tabla si no existe (solo la primera vez)
$crear_tabla = "CREATE TABLE IF NOT EXISTS autos (
    ID_Autos INT AUTO_INCREMENT PRIMARY KEY,
    Marca VARCHAR(100) NOT NULL,
    Modelo VARCHAR(100) NOT NULL,
    Contenido TEXT NOT NULL,
    Precios DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($conexion, $crear_tabla);

// obtener registros
$resultado = mysqli_query($conexion, "SELECT * FROM autos ORDER BY ID_Autos DESC");
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>AutoNova - Lista</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="bg-light">
<header class="navbar-container">
    <div class="navbar">
      <a href="index.html#inicio" class="navbar-logo">
        <img src="HTML/img/photo-1630574857663-bdc4ae3c8ec0.png" alt="logo" height="70" width="70" id="logo" />
      </a>
      <nav aria-label="Navegación principal">
        <ul class="navbar-links">
          <li><a href="index.html#inicio">Inicio</a></li>
          <li><a href="index.html#catalogo">Catálogo</a></li>
          <li><a href="index.html#contacto">Contacto</a></li>
          <li><a href="crud.php" rel="noopener">Administrar Autos</a></li>
        </ul>
      </nav>
    </div>
</header>
<main class="bg-light">
<div class="container py-5" style="padding-top: 120px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Lista de autos</h1>
        <a href="HTML/agregar.php" class="btn btn-outline-primary">Agregar auto</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Contenido</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['ID_Autos']) ?></td>
                            <td><?= htmlspecialchars($fila['Marca']) ?></td>
                            <td><?= htmlspecialchars($fila['Modelo']) ?></td>
                            <td style="max-width:300px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?= htmlspecialchars($fila['Contenido']) ?>
                            </td>
                            <td><?= htmlspecialchars(number_format($fila['Precios'], 2)) ?></td>
                            <td>
                                <a href="HTML/editar.php?ID_Autos=<?= urlencode($fila['ID_Autos']) ?>" class="me-2">Editar</a>
                                <a href="HTML/eliminar.php?ID_Autos=<?= urlencode($fila['ID_Autos']) ?>"
                                   onclick="return confirm('¿Eliminar este registro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">No hay registros.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>
</body>
</html>
<?php mysqli_close($conexion); ?>