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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!--...Favicon Image...-->
    <link rel="shortcut icon" href="../Archivos_Media/img_web.png" type="imagen/png">

    <!--...Bootstrap...-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
            <div class="row">
            <?php
            for ($grado = 6; $grado <= 11; $grado++) {
                for ($letra = 'A'; $letra <= 'C'; $letra++) {
                    $grado_curso = $grado;
                    $l_mayus = strtoupper($letra);

                    // Genera un enlace único para cada curso usando el número y la letra del grado
                    $enlace_lista = "lista1.php?grado=" . $grado_curso . "&letra=" . $letra;
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card my-3" style="width: 12rem;">
                        <img src="../Archivos_Media/<?= $grado_curso . $letra ?>.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Grado <?= $grado_curso ?>°<?= $l_mayus ?></h5>
                            <p class="card-text">Lista de estudiantes de grado <?= $grado_curso ?>°<?= $l_mayus ?>.</p>
                            <a href="<?= $enlace_lista ?>" class="btn btn-primary">Abrir lista</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            }
            ?>
            </div>
        </div>
        
    </div>
</div>

    </body>
</html>