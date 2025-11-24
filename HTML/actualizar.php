<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$contenido = trim($_POST['contenido'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);

if ($id <= 0 || $marca === '' || $modelo === '' || $contenido === '' || $precio < 0) {
    header("Location: ../crud.php?msg=" . urlencode("Datos inválidos"));
    exit;
}

$stmt = mysqli_prepare($conexion, "UPDATE autos SET Marca = ?, Modelo = ?, Contenido = ?, Precios = ? WHERE ID_Autos = ?");
mysqli_stmt_bind_param($stmt, "sssdi", $marca, $modelo, $contenido, $precio, $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

$msg = $ok ? "Auto actualizado" : "Error al actualizar";
header("Location: ../crud.php?msg=" . urlencode($msg));
exit;
?>

