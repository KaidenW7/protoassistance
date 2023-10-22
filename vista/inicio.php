<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }

    //Obtén el ID del usuario desde la variable de sesión
    $user_id = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>

<!-- primero se carga el navbar -->
<?php require('navbar.php'); ?>
<!-- luego se carga el sidebar -->


<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php include "sidebar.php"; ?>
        </div>
        
        <?php 
        
        include "../modelo/conexion.php";
        //echo "Este es el ID del usuario: ".$user_id;
        $sql = "SELECT * 
        FROM cursos
        INNER JOIN usuario_curso ON cursos.id_curso = usuario_curso.id_curso
        WHERE usuario_curso.id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $user_id); 
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Mostrar cada tarjeta para los cursos asociados al docente
            while ($fila = $resultado->fetch_assoc()) {
                $grado_curso = $fila['grado'];
                $letra = $fila['l_curso'];

                // Genera un enlace único para cada curso usando el ID del curso como parámetro GET
                $enlace_lista = "lista.php?grado=" . $grado_curso . "&letra=" . $letra;;
                // Ahora puedes usar $grado y $l_curso para llenar la tarjeta
                // Coloca aquí la estructura de la tarjeta usando los datos obtenidos
                echo '
                <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <div class="card my-3" style="width: 18rem;">
                        <img src="../Archivos_Media/'.$grado_curso.''.$letra.'.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Grado '.$grado_curso.'°'.$letra.'</h5>
                            <p class="card-text">Lista de asistencia de los estudiantes de grado '.$grado_curso.'°'.$letra.'.</p>
                            <a href="' . $enlace_lista . '" class="btn btn-primary">Abrir lista.</a>
                        </div>
                    </div>
                </div>';
            }
        }
        ?>
    </div>
</div>

    </body>
</html>