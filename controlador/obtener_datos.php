<?php
include "../modelo/conexion.php";

if (isset($_GET['id_estudiante'])) {
    $estudiante_id = $_GET['id_estudiante'];
    $stmt = $conexion->prepare("SELECT
        a.n_asignatura AS nombre_asignatura,
        SUM(CASE WHEN estado = 1 THEN 1 ELSE 0 END) AS asistencias,
        SUM(CASE WHEN estado = 0 THEN 1 ELSE 0 END) AS inasistencias,
        SUM(CASE WHEN estado = 2 THEN 1 ELSE 0 END) AS incapacidades
        FROM asistencia AS ast
        INNER JOIN asignaturas AS a ON ast.id_asignatura = a.id_asignatura
        WHERE id_estudiante = ?
        GROUP BY ast.id_asignatura");
    $stmt->bind_param("i", $estudiante_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
