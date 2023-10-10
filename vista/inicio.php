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
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <div class="card my-3" style="width: 18rem;">
                <img src="../Archivos_Media/11c.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Grado 11°C</h5>
                    <p class="card-text">Lista de asistencia de los estudiantes de grado 11°C.</p>
                    <a href="#" class="btn btn-primary">Abrir lista.</a>
                </div>
            </div>
        </div>
        
    </div>
</div>

    </body>
</html>