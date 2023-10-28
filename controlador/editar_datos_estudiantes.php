<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('../modelo/conexion.php');

    // Consulta SQL de UPDATE
$sql_update = "UPDATE personas SET
foto=?,
nombres=?,
apellidos=?,

WHERE id_est_11=?";

// Obtener los datos del formulario
$tipoD = $_POST['id'];
$nombres = $_POST['nombre'];
$apellidos = $_POST['apellido'];

// Bindear los valores a la consulta SQL
$stmt_update = $conexion->prepare($sql_update);
$stmt_update->bind_param('iss', $id, $nombres, $apellidos);

// Ejecutar la consulta SQL
if ($stmt_update->execute()) {
echo "Datos actualizados exitosamente.";
} else {
echo "Error al actualizar los datos: " . $stmt_update->error;
}

// Cerrar la conexión
$stmt_update->close();
$conexion->close();
}


?>
