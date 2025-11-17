<?php
$conexion = mysqli_connect("localhost", "root", "", "AutoNova");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id = intval($_GET['ID_Autos'] ?? 0);

if ($id > 0) {
    mysqli_query($conexion, "DELETE FROM autos WHERE ID_Autos = $id");
}

mysqli_close($conexion);
header("Location: index.php");
exit;
?>

