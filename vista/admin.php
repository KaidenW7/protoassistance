<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario']) and !isset($_SESSION['rol'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }else{
        if(isset($_SESSION['rol'])){
            if($_SESSION['rol'] != 2){
                header("Location: inicio.php");
            }
        }
    }


    //Obtén el ID del usuario desde la variable de sesión
    $user_id = $_SESSION['id_usuario'];
    $name = $_SESSION['nombre'];
    $n_mayus = strtoupper($name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Assistance/Administrador</title>

    <!--...Favicon Image...-->
    <link rel="shortcut icon" href="../Archivos_Media/img_web1.png" type="imagen/png">
</head>
<body>
    <!-- primero se carga el navbar -->
<?php require('navbar.php'); ?>
<!-- luego se carga el sidebar -->


<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="title center">Bienvenido <?php echo $n_mayus; ?></div>
            <div class="row">
                
                    <div class="col-lg-4">
                        <div class="card my-3" style="width: 18rem;">
                            <img src="../Archivos_Media/usuario.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Gestión de Usuario</h5>
                                <p class="card-text">Administre cuentas de usuarios, configure permisos y roles, y asegúrese de que los datos de los usuarios estén actualizados.</p>
                                <a href="gest_usuarios.php" class="btn btn-primary">Ir</a>
                            </div>
                            <!-- Gestión de Usuario - Modal -->
                            <div class="modal fade" id="gestionar" tabindex="-1" role="dialog" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Gestión de Usuario</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    
                                    <div class="modal-body" >
                                        <button type="submit" name="agregar" class="btn btn-primary mt-2">Agregar</button>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card my-3" style="width: 18rem;">
                            <img src="../Archivos_Media/cursos.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Gestión de Cursos</h5>
                                <p class="card-text">Organice y gestione los cursos de la institución educativa, asigne profesores y estudiantes.</p>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cursos">Ir</button>
                            </div>
                            <!-- Gestión de Cursos - Modal -->
                            <div class="modal fade" id="cursos" tabindex="-1" role="dialog" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                    <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Gestión de Cursos</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    
                                    <div class="modal-body text-center" >
                                        <a href="asignar_cursos.php" class="btn btn-info">Asigne cursos a docentes.</a>
                                        <a href="cards_cursos.php" class="btn btn-info">Registre estudiantes.</a>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                        
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card my-3" style="width: 18rem;">
                            <img src="../Archivos_Media/informes.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Generación de Informes</h5>
                                <p class="card-text">Acceda a datos clave y genere informes detallados para evaluar la asistencia, el rendimiento académico y otros indicadores importantes.</p>
                                <a href="#" class="btn btn-primary">Ir</a>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
        
    </div>
</div>

</body>
</html>