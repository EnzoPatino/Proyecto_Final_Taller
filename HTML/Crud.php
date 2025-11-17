<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$resultado = mysqli_query($conexion, "SELECT * FROM autos ORDER BY ID_Autos DESC");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoNova | CRUD de Autos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-4">
        <header class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1">AutoNova</h1>
                <p class="text-muted mb-0">Gestión básica de vehículos (CRUD)</p>
            </div>
            <a class="btn btn-outline-primary mt-3 mt-md-0" href="agregar.php">➕ Agregar auto</a>
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
                                                href="editar.php?ID_Autos=<?php echo $fila['ID_Autos']; ?>">Editar</a>
                                            <a class="btn btn-sm btn-danger"
                                                href="eliminar.php?ID_Autos=<?php echo $fila['ID_Autos']; ?>"
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