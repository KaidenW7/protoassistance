<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }
    $ruta= $_SESSION['ruta_lista'];
?>
<!DOCTYPE html>
<?php include "../modelo/head1.php"; ?>
<body>

<!-- primero se carga el navbar -->


<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar bg-dark vh-120">
            <?php include "../sidebar_Navbar/sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="row">
            <?php require('../sidebar_Navbar/navbar.php'); ?>
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
                    $stmt = $conexion->prepare("SELECT * FROM estudiantes_11 WHERE curso=? ORDER BY apellido ASC");
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
                        <th scope="col" class="text-center align-middle">Tipo de documento</th>
                        <th scope="col" class="text-center align-middle">N° de documento</th>
                        <th scope="col" class="text-center align-middle">Fecha de nacimiento</th>
                        <th scope="col" class="text-center align-middle">Correo</th>
                        <th scope="col" class="text-center align-middle">Sexo</th>
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
                        <td class="text-center align-middle"><?= $datos->td?></td>
                        <td class="text-center align-middle"><?= $datos->n_documento?></td>
                        <td class="text-center align-middle"><?= $datos->f_nacimiento?></td>
                        <td class="text-center align-middle"><?= $datos->email?></td>
                        <td class="text-center align-middle"><?= $datos->sexo?></td>

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
                                    <input type="hidden" id="ruta" name="ruta" value="<?= $ruta?>">

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

                                    <div class="col-md-4">
                                            <label for="inputTDoc" class="form-label">Tipo de documento</label>
                                            <select id="inputTDoc" class="form-select" name="td">
                                                <option selected><?= $datos->td?></option>
                                                <option>TI</option>
                                                <option>CC</option>
                                                <option>PPT</option>
                                            </select>
                                        </div>

                                        <div class="col-6">
                                            <label for="inputNumero" class="form-label">Número de documento</label>
                                            <input type="number" class="form-control" id="inputNumero" name="n_documento" value="<?= $datos->n_documento?>">
                                        </div>

                                        <div class="col-md-2">
                                        <label for="inputSexo" class="form-label">Sexo</label>
                                            <select class="form-select mt-2 " name="sexo" id="inputSexo">
                                                    <option value=''>Seleccione sexo</option>
                                                    <option value='f'>Femenino</option>
                                                    <option value='m'>Masculino</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputEmail" class="form-label">Correo Electrónico</label>
                                            <input type="text" class="form-control" id="inputEmail" name="email" value="<?= $datos->email?>>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="inputFnacimiento" class="form-label">Fecha de nacimiento</label>
                                            <input type="date" class="form-control" id="inputFnacimiento" name="f_nacimiento" value="<?= $datos->f_nacimiento?>>
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
</div>

    </body>
</html>