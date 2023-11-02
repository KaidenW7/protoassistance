<?php
include "../modelo/conexion.php";
    $estudiante_id = 12;
    $asignatura_id = 3;

    $stmt = $conexion->prepare("SELECT
        SUM(CASE WHEN estado = 1 THEN 1 ELSE 0 END) AS asistencias,
        SUM(CASE WHEN estado = 0 THEN 1 ELSE 0 END) AS inasistencias,
        SUM(CASE WHEN estado = 2 THEN 1 ELSE 0 END) AS incapacidades
        FROM asistencia
        WHERE id_estudiante = ? AND id_asignatura = ?");
    $stmt->bind_param("ii", $estudiante_id, $asignatura_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
        echo json_encode($data);

        