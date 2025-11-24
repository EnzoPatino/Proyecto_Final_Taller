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

$stmt = mysqli_prepare($conexion, "DELETE FROM autos WHERE ID_Autos = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

$msg = $ok ? "Auto eliminado" : "Error al eliminar";
header("Location: ../crud.php?msg=" . urlencode($msg));
exit;
?>

