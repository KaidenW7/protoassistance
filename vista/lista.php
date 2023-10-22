<!DOCTYPE html>
<?php include "../modelo/head1.php"; ?>
<body>

<!-- primero se carga el navbar -->
<?php require('navbar.php'); ?>


<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <?php
            if (isset($_GET['grado']) and isset($_GET['letra'])) {
                $grado = $_GET['grado'];
                $letra = $_GET['letra'];
                $l_mayus = strtoupper($letra);
                $curso = $grado."°".$l_mayus;
                // Ahora, $id_curso contiene el ID del curso que pasaste desde la página anterior
                // Puedes usar este ID para realizar consultas SQL y mostrar la lista de asistencia correspondiente
                ?>
                <h4 class="text-center">Asistencia <?php echo $curso; ?></h4>

                <?php 
                    include "../modelo/conexion.php";
                    $sql=$conexion->query("SELECT foto, nombre, apellido FROM estudiantes_11 WHERE curso='$curso'");
                ?>

                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i = 1;
                    while ($datos = $sql->fetch_object()){
                        ?>
                    <tr>
                        <th><?php echo $i;?></th>
                        <td><img src="<?php echo $datos->foto; ?>" alt="Imagen" width="50" height="70"></td>
                        <td><?= $datos->nombre?></td>
                        <td><?= $datos->apellido?></td>
                    </tr>
                    <?php 
                        $i++;
                    }?>
                </tbody>
                </table>
            <?php
            }
            ?>
            
        </div>
        
    </div>
</div>

    </body>
</html>