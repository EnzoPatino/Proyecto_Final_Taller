<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$marca     = $_POST['marca'] ?? '';
$modelo    = $_POST['modelo'] ?? '';
$contenido = $_POST['contenido'] ?? '';
$precio    = $_POST['precio'] ?? '0';

$marca = trim($marca);
$modelo = trim($modelo);
$contenido = trim($contenido);
$precio = floatval($precio);

if ($marca === '' || $modelo === '' || $contenido === '' || $precio < 0) {
    header("Location: ../crud.php?msg=" . urlencode("Datos inválidos"));
    exit;
}

$stmt = mysqli_prepare($conexion, "INSERT INTO autos (Marca, Modelo, Contenido, Precios) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssd", $marca, $modelo, $contenido, $precio);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

if ($ok) {
    header("Location: ../crud.php?msg=" . urlencode("Auto agregado correctamente"));
    exit;
} else {
    header("Location: ../crud.php?msg=" . urlencode("Error al agregar: " . mysqli_error($conexion)));
    exit;
}
?>

