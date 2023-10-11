<?php
 //Inicia la sesión para acceder a las variables de sesión
session_start();

 //Verifica si el usuario está autenticado
if (empty($_SESSION['email']) and empty($_SESSION['id_usuario'])) {
     //Si no está autenticado, redirige al usuario al inicio de sesión
 //   header("Location: ../index.php");
    
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
        $sql = "SELECT * FROM cursos  
        INNER JOIN usuario_cursos ON cursos.id_curso = usuario_cursos.id_curso
        WHERE usuario_cursos.id_usuario = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $user_id);  // "i" indica que es un parámetro de tipo entero
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Mostrar cada tarjeta para los cursos asociados al docente
            while ($fila = $resultado->fetch_assoc()) {
                $nombre_curso = $fila['nombre_curso'];
                $id_curso = $fila['id_curso'];
                // Ahora puedes usar $nombre_curso y $id_curso para llenar la tarjeta
                // Coloca aquí la estructura de la tarjeta usando los datos obtenidos
                echo '
                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
                    <div class="card my-3" style="width: 18rem;">
                        <img src="../Archivos_Media/'.$id_curso.'.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Grado '.$nombre_curso.'</h5>
                            <p class="card-text">Lista de asistencia de los estudiantes de grado '.$nombre_curso.'.</p>
                            <a href="#" class="btn btn-primary">Abrir lista.</a>
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