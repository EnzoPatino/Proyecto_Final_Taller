<?php
require_once '../config/database.php';

// Obtener todos los autos
$stmt = $pdo->query("SELECT * FROM autos ORDER BY id DESC");
$autos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Autos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body { padding: 20px; }
        .table { margin-top: 20px; }
        .btn-add { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Administración de Autos</h1>
        
        <a href="agregar.php" class="btn btn-primary btn-add">
            <i class="bi bi-plus-circle"></i> Agregar Auto
        </a>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($autos as $auto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($auto['id']); ?></td>
                        <td><?php echo htmlspecialchars($auto['marca']); ?></td>
                        <td><?php echo htmlspecialchars($auto['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($auto['anio']); ?></td>
                        <td>$<?php echo number_format($auto['precio'], 2); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $auto['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <a href="eliminar.php?id=<?php echo $auto['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Estás seguro de eliminar este auto?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
