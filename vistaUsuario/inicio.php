<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario']) and !isset($_SESSION['rol'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }else{
        if(isset($_SESSION['rol'])){
            if($_SESSION['rol'] != 1){
                header("Location: admin.php");
            }
        }
    }

    

    //Obtén el ID del usuario desde la variable de sesión
    $user_id = $_SESSION['id_usuario'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Es e-Assistance, una solución eficiente y moderna para la gestión de asistencia de tu institución educativa. Nuestra plataforma web te brinda una planilla de asistencia fácil de usar que simplifica el seguimiento y registro de la asistencia de tus estudiantes.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!--...Favicon Image...-->
    <link rel="shortcut icon" href="../Archivos_Media/img_web.png" type="imagen/png">

    <!--...Bootstrap...-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>


<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar bg-dark vh-100">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="row">
            <?php require('navbar.php'); ?>
            <div class="row">
            <?php 
            
            include "../modelo/conexion.php";
            //echo "Este es el ID del usuario: ".$user_id;
            $sql = "SELECT * 
            FROM cursos
            INNER JOIN usuario_curso ON cursos.id_curso = usuario_curso.id_curso
            WHERE usuario_curso.id_usuario = ? 
            ORDER BY grado ASC, l_curso ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $user_id); 
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                // Mostrar cada tarjeta para los cursos asociados al docente
                while ($fila = $resultado->fetch_assoc()) {
                    $grado_curso = $fila['grado'];
                    $letra = $fila['l_curso'];
                    $l_mayus = strtoupper($letra);

                    // Genera un enlace único para cada curso usando el ID del curso como parámetro GET
                    $enlace_lista = "lista.php?grado=" . $grado_curso . "&letra=" . $letra;
                    // Ahora puedes usar $grado y $l_curso para llenar la tarjeta
                    // Coloca aquí la estructura de la tarjeta usando los datos obtenidos
                    echo '
                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="card my-3" style="width: 12rem;">
                            <img src="../Archivos_Media/'.$grado_curso.''.$letra.'.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Grado '.$grado_curso.'°'.$l_mayus.'</h5>
                                <p class="card-text">Lista de asistencia de los estudiantes de grado '.$grado_curso.'°'.$l_mayus.'.</p>
                                <a href="' . $enlace_lista . '" class="btn btn-primary">Abrir lista.</a>
                            </div>
                        </div>
                    </div>';
                }
            }
            ?>
            </div>
        </div>
    </div>
        
    </div>
</div>

    </body>
</html>