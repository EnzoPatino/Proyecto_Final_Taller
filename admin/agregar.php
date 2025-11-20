<?php
require_once '../config/database.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $anio = $_POST['anio'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    
    // Manejo de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $carpeta_destino = '../uploads/';
        if (!file_exists($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }
        
        $nombre_archivo = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $ruta_archivo = $carpeta_destino . $nombre_archivo;
        
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_archivo)) {
            $imagen = 'uploads/' . $nombre_archivo;
        }
    }
    
    try {
        $stmt = $pdo->prepare("INSERT INTO autos (marca, modelo, anio, precio, descripcion, imagen) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$marca, $modelo, $anio, $precio, $descripcion, $imagen]);
        
        header('Location: index.php?mensaje=auto_agregado');
        exit();
    } catch (PDOException $e) {
        $mensaje = "Error al agregar el auto: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">Agregar Nuevo Auto</h2>
                
                <?php if ($mensaje): ?>
                    <div class="alert alert-danger"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                
                <form action="agregar.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="anio" class="form-label">Año</label>
                        <input type="number" class="form-control" id="anio" name="anio" required min="1900" max="2099">
                    </div>
                    
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen del auto</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Auto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
