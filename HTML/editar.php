<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = isset($_GET['ID_Autos']) ? intval($_GET['ID_Autos']) : 0;
if ($id <= 0) {
    header("Location: ../crud.php?msg=" . urlencode("ID inválido"));
    exit;
}

$stmt = mysqli_prepare($conexion, "SELECT * FROM autos WHERE ID_Autos = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$auto = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$auto) {
    mysqli_close($conexion);
    header("Location: ../crud.php?msg=" . urlencode("Auto no encontrado"));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar auto | AutoNova</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Editar auto</h1>
                <p class="text-muted mb-0">Modifica la información del vehículo seleccionado.</p>
            </div>
            <a href="../crud.php" class="btn btn-outline-secondary">← Volver a la lista</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="actualizar.php" method="POST" class="mx-3 my-2" style="max-width: 750px;">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($auto['ID_Autos']); ?>">

                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" id="marca" name="marca" class="form-control"
                            value="<?php echo htmlspecialchars($auto['Marca']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" id="modelo" name="modelo" class="form-control"
                            value="<?php echo htmlspecialchars($auto['Modelo']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label">Descripción / Contenido</label>
                        <textarea id="contenido" name="contenido" class="form-control" rows="4" required><?php echo htmlspecialchars($auto['Contenido']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio (USD)</label>
                        <input type="number" step="0.01" min="0" id="precio" name="precio" class="form-control"
                            value="<?php echo htmlspecialchars($auto['Precios']); ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                        <a href="../crud.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

<?php mysqli_close($conexion); ?>

