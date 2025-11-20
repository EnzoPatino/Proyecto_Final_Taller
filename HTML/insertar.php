<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$marca = $_POST['marca'] ?? '';
$modelo = $_POST['modelo'] ?? '';
$contenido = $_POST['contenido'] ?? '';
$precio = $_POST['precio'] ?? 0;

$marca = mysqli_real_escape_string($conexion, $marca);
$modelo = mysqli_real_escape_string($conexion, $modelo);
$contenido = mysqli_real_escape_string($conexion, $contenido);
$precio = floatval($precio);

$consulta = "INSERT INTO autos (Marca, Modelo, Contenido, Precios) VALUES ('$marca', '$modelo', '$contenido', $precio)";

if (mysqli_query($conexion, $consulta)) {
    header("Location: ../crud.php");
    exit;
} else {
    echo "Error al guardar: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>

