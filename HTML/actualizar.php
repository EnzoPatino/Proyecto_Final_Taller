<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = intval($_POST['id'] ?? 0);
$marca = mysqli_real_escape_string($conexion, $_POST['marca'] ?? '');
$modelo = mysqli_real_escape_string($conexion, $_POST['modelo'] ?? '');
$contenido = mysqli_real_escape_string($conexion, $_POST['contenido'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);

$consulta = "UPDATE autos SET Marca = '$marca', Modelo = '$modelo', Contenido = '$contenido', Precios = $precio WHERE ID_Autos = $id";

if (mysqli_query($conexion, $consulta)) {
    header("Location: index.php");
    exit;
} else {
    echo "Error al actualizar: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>

