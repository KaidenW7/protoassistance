<?php

use Dompdf\Dompdf;
include "conexion.php";
if (isset($_GET['id_estudiante'])) {
    $estudiante_id = $_GET['id_estudiante'];

    // Consulta para obtener datos del estudiante específico
    $stmt = $conexion->prepare("SELECT nombre, apellido, curso FROM estudiantes_11 WHERE id_est_11 = ?");
    $stmt->bind_param("i", $estudiante_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El estudiante fue encontrado
        $row = $result->fetch_assoc();
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $curso = $row['curso'];
    }

    /*// Consulta para obtener datos del docente específico
    $stmt = $conexion->prepare("SELECT
        u.n_completo AS nombre_completo_docente,
        a.n_asignatura AS nombre_asignatura,
        a.horas_semana AS horas_semana
    FROM usuarios AS u
    JOIN usuario_asignatura AS ua ON u.id_usuario = ua.id_usuario
    JOIN asignaturas AS a ON ua.id_asignatura = a.id_asignatura
    WHERE u.id_rol != 2
    AND u.estado_cuenta = 'aprobado';");
    $stmt->bind_param("i", $estudiante_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El estudiante fue encontrado
        $row = $result->fetch_assoc();
        $n_docente = $row['nombre_completo_docente'];
        $a_asignatura = $row['nombre_asignatura'];
        $h_semana = $row['horas_semana'];
    }*/
    ob_start();
?>
<!DOCTYPE html>
<?php include "head1.php";?>
<body>
    <div class="container">
        <table class="table  mb-5">
            <thead>
                <tr>
                    <th scope="col" class="text-center align-middle"><img src="../Archivos_Media/escudo.png" alt="" width="200" height="146"></th>
                    <th scope="col" class="text-center align-middle">INSTITUCIÓN EDUCATIVA DISTRITAL JORGE ISAACS <br>
                        Aprobado según Resolución No 04343 del 13 de Agosto de 2015<br>
                        Actualización Jornada Única 09014 del 13 de Diciembre de 2016<br>
                        NIT: 802.014.036 – 5 DANE: 108001002916<br>
                        GUÍA DIDÁCTICA
                    </th>
                    <th scope="col" class="text-center align-middle"><img src="https://<?php echo $_SERVER['HTTP_HOST']?>protoassistance/Archivos_Media/iedlogo.png" alt="" width="200" height="146"></th>
                    </th>
                </tr>
            </thead>
        </table>
        <p class="text-center">
        Asistencia del estudiante <?php echo $nombre."".$apellido;?> del curso <?php echo $curso;?> en la asignatura de $n_clase desde el $fecha_inicial hasta el $_fecha_final.
        </p>
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
                    $grafica.style.marginBottom = "80px";

                    document.body.appendChild($grafica);

                    // Convertir los valores de asistencias, inasistencias e incapacidades a números
                    const asistencias = parseInt(datosEstudiante.asistencias);
                    const inasistencias = parseInt(datosEstudiante.inasistencias);
                    const incapacidades = parseInt(datosEstudiante.incapacidades);
                    const nombreAsignatura = datosEstudiante.nombre_asignatura; // Nombre de la asignatura

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
                                text: nombreAsignatura, // Agregar el nombre de la asignatura
                                font: { size: 24 },
                                color: "rgba(0, 0, 0, 1)"
                            },
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
        </div>
    </div>
</body>
</html>
<?php
}
$informe = ob_get_clean();
//echo $informe;

// include autoloader
require_once 'C:\xampp\htdocs\protoassistance\dompdf\autoload.inc.php';

// instantiate and use the dompdf class
//use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($informe);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter');

// Render the HTML as PDF
$dompdf->render();


// Output the generated PDF to Browser
$dompdf->stream("informe_.pdf", array("Attachment" => false));