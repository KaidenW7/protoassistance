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

                <form method="post" action="">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th></th>
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
                        <td>
                            <label for="presente<?= $i ?>"><i class="fa-regular fa-circle-check"></i></label>
                            <input type="radio" name="asistencia[<?= $i ?>]" value="1" id="presente<?= $i ?>" checked>
                            <label for="ausente<?= $i ?>"><i class="fa-regular fa-circle-xmark"></i></label>
                            <input type="radio" name="asistencia[<?= $i ?>]" value="0" id="ausente<?= $i ?>">
                            <label for="incapacitado<?= $i ?>"><i class="fa-solid fa-user-slash"></i></label>
                            <input type="radio" name="asistencia[<?= $i ?>]" value="2" id="incapacitado<?= $i ?>">
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
                </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
                </form>         
            <?php
            }
            if (isset($_POST['asistencia'])) {
                $datos = $_POST['asistencia'];
                // Convertir la cadena de caracteres en un array
                //$datos = explode(",", $datos);

                foreach ($datos as $id => $valor) {
                    $fecha = date("Y-m-d");
                    $hora = date("H:i:s");
            
                    $sql = "INSERT INTO asistencia (id_estudiante, estado, hora, fecha) VALUES ($id, '$valor', '$fecha', '$hora');";
                    $conexion->query($sql);
                }
            }
            ?>
            
        </div>
        
    </div>
</div>

    </body>
</html>