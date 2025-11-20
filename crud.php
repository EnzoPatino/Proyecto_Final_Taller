<?php
// Primero conectar sin especificar base de datos para poder crearla si no existe
$conexion_temp = mysqli_connect("localhost", "root", "");

if (!$conexion_temp) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Crear la base de datos si no existe
mysqli_query($conexion_temp, "CREATE DATABASE IF NOT EXISTS AutoNova CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
mysqli_close($conexion_temp);

// Ahora conectar a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Crear la tabla si no existe
$crear_tabla = "CREATE TABLE IF NOT EXISTS autos (
    ID_Autos INT AUTO_INCREMENT PRIMARY KEY,
    Marca VARCHAR(100) NOT NULL,
    Modelo VARCHAR(100) NOT NULL,
    Contenido TEXT NOT NULL,
    Precios DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

mysqli_query($conexion, $crear_tabla);

$resultado = mysqli_query($conexion, "SELECT * FROM autos ORDER BY ID_Autos DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoNova | CRUD de Autos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-4">
  <header>
    <div class="header-content">
        <a href="index.html">
            <img src="HTML/img/photo-1630574857663-bdc4ae3c8ec0.png" alt="logo" height="50" width="50" id="logo" />
        </a>
        <nav class="header-nav">
            <a href="index.html#inicio" class="hero">Inicio</a>
            <a href="index.html#catalogo" class="enlaces">Catálogo</a>
            <a href="index.html#contacto" class="enlaces">Contacto</a>
            <a href="crud.php" target="_blank">Administrar Autos</a>
        </nav>
    </div>
  </header>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Precio (USD)</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado && mysqli_num_rows($resultado) > 0) : ?>
                                <?php while ($fila = mysqli_fetch_assoc($resultado)) : ?>
                                    <tr>
                                        <td><?php echo $fila['ID_Autos']; ?></td>
                                        <td><?php echo htmlspecialchars($fila['Marca']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['Modelo']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($fila['Contenido'])); ?></td>
                                        <td><?php echo number_format($fila['Precios'], 2); ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-warning"
                                                href="HTML/editar.php?ID_Autos=<?php echo $fila['ID_Autos']; ?>">Editar</a>
                                            <a class="btn btn-sm btn-danger"
                                                href="HTML/eliminar.php?ID_Autos=<?php echo $fila['ID_Autos']; ?>"
                                                onclick="return confirm('¿Está seguro de eliminar este auto?')">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No hay autos cargados todavía.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="text-center text-muted mt-4">
            <small>CRUD de ejemplo - Programación Web Estática</small>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

<?php mysqli_close($conexion); ?>