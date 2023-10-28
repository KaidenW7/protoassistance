<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }
?>
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
                <div class="contenedor">
                    <h4 class="text-center">Modificar datos de <?php echo $curso; ?></h4> 
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                </div>
                <?php 
                    include "../modelo/conexion.php";
                    $stmt = $conexion->prepare("SELECT id_est_11, foto, nombre, apellido FROM estudiantes_11 WHERE curso=? ORDER BY apellido ASC");
                    $stmt->bind_param("s", $curso);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                ?>

                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">N°</th>
                        <th scope="col" class="text-center align-middle">Foto</th>
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Apellido</th>
                        <th scope="col" class="text-center align-middle">Modificar</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i = 1;
                    while ($datos = $result->fetch_object()){
                        ?>
                    <tr>
                        <th class="text-center align-middle"><?php echo $i;?></th>
                        <td class="text-center align-middle"><img src="<?php echo $datos->foto; ?>" alt="Imagen" width="50" height="70"></td>
                        <td class="text-center align-middle"><?= $datos->nombre?></td>
                        <td class="text-center align-middle"><?= $datos->apellido?></td>
                        <td class="text-center align-middle">
                            <!--<button type="button" id="BotonModificar" class="btn btn-success" data-target="#editar">Modificar</button>-->
                            <!--<form method="post" action="">-->
                                <button name="boton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editar<?php echo $datos->id_est_11; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                            <!--</form>-->
                        </td>
                    </tr>

                        <!-- modificar -->
                            <div class="modal fade" id="editar<?php echo $datos->id_est_11; ?>" tabindex="-1" role="dialog" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Editar datos del estudiante:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <div class="modal-body" >
                                    <form action="../controlador/editar_datos_estudiantes.php" method="post" enctype ="multipart/form-data">
                                    <input type="hidden" id="Id" name="id" value="<?= $datos->id_est_11?>">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="foto">Foto</label>
                                            <input type="file" name="foto" value="<?= $datos->foto?>" accept="image/*">
                                            <img src="<?php echo $datos->foto; ?>" alt="Imagen" width="50" height="70">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                        <label>Nombres: </label>
                                        <input type="text" id="Titulo" name="nombre" class="form-control" value="<?= $datos->nombre?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                        <label>Apellido</label>
                                        <input type="text" id="Titulo" name="apellido" class="form-control" value="<?= $datos->apellido?>">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-2">Guardar</button>
                                    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                    
                                </div>
                    </div>
                </div>
            </div>

                    <?php 
                        $i++;
                    }
                    ?>
                </tbody>
                </table>
                
                

            <?php
            }
                ?>
                <script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href)
                    }
                </script>
        </div>
        
    </div>
</div>

    </body>
</html>