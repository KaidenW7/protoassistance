<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas con chart.js y AJAX | By Parzibyte</title>
    <!-- Importar chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-doughnutlabel"></script>

</head>

<body>
    <h1>Gráfica creada con PHP</h1>
    <canvas id="grafica" style="position: relative; height: 300px; width: 900px; display: block; box-sizing: border-box;"></canvas>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>

include "../modelo/conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $estudiante_id = $_POST["id_estudiante"];

    

    $asignatura_id = ;

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
    header('Content-Type: application/json');
    echo json_encode($data);

    header("Location:../modelo/formato_informe.pdf");
    

}


(async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch("../controlador/obtener_datos.php");
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();
                // Convertir los valores de asistencias, inasistencias e incapacidades a números
                const asistencias = parseInt(respuesta.asistencias);
                const inasistencias = parseInt(respuesta.inasistencias);
                const incapacidades = parseInt(respuesta.incapacidades);
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica");
                const etiquetas = ["Asistencias", "Inasistencias", "Incapacidades"];
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const total = asistencias + inasistencias + incapacidades;
                const porcentajeAsistencias = ((asistencias / total) * 100).toFixed(2);
                const porcentajeInasistencias = ((inasistencias / total) * 100).toFixed(2);
                const porcentajeIncapacidades = ((incapacidades / total) * 100).toFixed(2);

                const datosAsistencias = {
                    data: [porcentajeAsistencias, porcentajeInasistencias, porcentajeIncapacidades],
                    backgroundColor: ['rgba(4, 161, 23, 0.7)', 'rgba(209, 5, 5, 0.7)', 'rgba(196, 234, 3, 0.7'],
                    borderColor: ['rgba(0, 102, 12, 1)', 'rgba(155, 0, 0, 1)', 'rgba(173, 207, 0, 1)'],
                    borderWidth: 1,
                    hoverBackgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)', 'rgba(75, 192, 192, 0.5)'],
                    hoverBorderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)'],
                    hoverOffset: 4
                };

                // ...

                new Chart($grafica, {
                    type: 'doughnut', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [datosAsistencias]
                    },
                    options: {
                        cutoutPercentage: 60, // Controla el tamaño del agujero central (0 = sin agujero)
                        plugins: {
                            doughnutlabel: {
                                labels: [
                                    {
                                        text: 'Asistencias: ' + porcentajeAsistencias + '%',
                                        font: { size: 16 },
                                        color: ('rgba(4, 161, 23, 1')
                                    },
                                    {
                                        text: 'Inasistencias: ' + porcentajeInasistencias + '%',
                                        font: { size: 16 },
                                        color: ('rgba(209, 5, 5, 1')
                                    },
                                    {
                                        text: 'Incapacidades: ' + porcentajeIncapacidades + '%',
                                        font: { size: 16 },
                                        color: ('rgba(207, 148, 0, 1')
                                    }
                                ]
                            }
                        }
                    }
                });
            })();
            //------

            <div class="mt-5">
            Nombre del docente: $n_docente<br>
            Intensidad de horas por semana: $n_horas
        </div>

        <div>
            <h3 class="text-center">Porcentajes del los estados de asistencia.</h3>
            <canvas id="grafica" width="150" height="40"></canvas>
            <script type="text/javascript">
                (async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch(`../controlador/obtener_datos.php?id_estudiante=${<?php echo $estudiante_id; ?>}`);
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();

                respuesta.forEach((datosEstudiante, indice) => {
                    // Obtener una referencia al elemento canvas del DOM
                    const $grafica = document.createElement("canvas");
                    $grafica.id = "grafica" + indice;
                    $grafica.style.position = "relative";
                    $grafica.style.height = "300px";
                    $grafica.style.width = "900px";
                    $grafica.style.display = "block";
                    $grafica.style.boxSizing = "border-box";
                    $grafica.style.marginBottom = "20px";

                    document.body.appendChild($grafica);

                    // Convertir los valores de asistencias, inasistencias e incapacidades a números
                    const asistencias = parseInt(datosEstudiante.asistencias);
                    const inasistencias = parseInt(datosEstudiante.inasistencias);
                    const incapacidades = parseInt(datosEstudiante.incapacidades);

                    const etiquetas = ["Asistencias", "Inasistencias", "Incapacidades"];
                    const total = asistencias + inasistencias + incapacidades;
                    const porcentajeAsistencias = ((asistencias / total) * 100).toFixed(2);
                    const porcentajeInasistencias = ((inasistencias / total) * 100).toFixed(2);
                    const porcentajeIncapacidades = ((incapacidades / total) * 100).toFixed(2);

                    const datosAsistencias = {
                    data: [porcentajeAsistencias, porcentajeInasistencias, porcentajeIncapacidades],
                    backgroundColor: ["rgba(4, 161, 23, 0.7)", "rgba(209, 5, 5, 0.7)", "rgba(196, 234, 3, 0.7"],
                    borderColor: ["rgba(0, 102, 12, 1)", "rgba(155, 0, 0, 1)", "rgba(173, 207, 0, 1)"],
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        "rgba(54, 162, 235, 0.5)",
                        "rgba(255, 99, 132, 0.5)",
                        "rgba(75, 192, 192, 0.5)"
                    ],
                    hoverBorderColor: [
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 99, 132, 1)",
                        "rgba(75, 192, 192, 1)"
                    ],
                    hoverOffset: 4
                    };

                    // Crear una gráfica para cada estudiante
                    new Chart($grafica, {
                    type: "doughnut", // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [datosAsistencias]
                    },
                    options: {
                        cutoutPercentage: 60, // Controla el tamaño del agujero central (0 = sin agujero)
                        plugins: {
                        doughnutlabel: {
                            labels: [
                            {
                                text: "Asistencias: " + porcentajeAsistencias + "%",
                                font: { size: 16 },
                                color: "rgba(4, 161, 23, 1)"
                            },
                            {
                                text: "Inasistencias: " + porcentajeInasistencias + "%",
                                font: { size: 16 },
                                color: "rgba(209, 5, 5, 1)"
                            },
                            {
                                text: "Incapacidades: " + porcentajeIncapacidades + "%",
                                font: { size: 16 },
                                color: "rgba(207, 148, 0, 1)"
                            }
                            ]
                        }
                        }
                    }
                    });
                });
                })();

            </script>

            <!--O->

            <?php
include "../modelo/conexion.php";

// Obtener el ID del estudiante 
if (isset($_GET['id_estudiante'])) {
    $estudiante_id = $_GET['id_estudiante'];

    // Consulta para obtener los ID de asignaturas del estudiante
    $stmt_asignaturas = $conexion->prepare("SELECT id_asignatura FROM asignaturas");
    $stmt_asignaturas->execute();
    $result_asignaturas = $stmt_asignaturas->get_result();

    // Arreglo para almacenar los resultados
    $resultados = array();

    while ($row = $result_asignaturas->fetch_assoc()) {
        $asignatura_id = $row['id_asignatura'];

        // Consulta para contar los estados de asistencia
        $stmt_asistencia = $conexion->prepare("SELECT
            SUM(CASE WHEN estado = 1 THEN 1 ELSE 0 END) AS asistencias,
            SUM(CASE WHEN estado = 0 THEN 1 ELSE 0 END) AS inasistencias,
            SUM(CASE WHEN estado = 2 THEN 1 ELSE 0 END) AS incapacidades
            FROM asistencia
            WHERE id_estudiante = ? AND id_asignatura = ?");
        $stmt_asistencia->bind_param("ii", $estudiante_id, $asignatura_id);
        $stmt_asistencia->execute();
        $result_asistencia = $stmt_asistencia->get_result();
        $data = $result_asistencia->fetch_assoc();

        // Agregar resultados al arreglo
        $resultados[] = array(
            'asistencias' => $data['asistencias'],
            'inasistencias' => $data['inasistencias'],
            'incapacidades' => $data['incapacidades']
        );
    }

    // Enviar los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($resultados);

        
    }
