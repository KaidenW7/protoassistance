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
                $tabla = "estudiantes_".$grado;
                $id = "id_est_".$grado;
                // Ahora, $id_curso contiene el ID del curso que pasaste desde la página anterior
                // Puedes usar este ID para realizar consultas SQL y mostrar la lista de asistencia correspondiente
                ?>
                <div class="contenedor">
                    <h4 class="text-center">Registrar estudiantes en <?php echo $curso; ?></h4> 
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                </div>
                <?php 
                    include "../modelo/conexion.php";
                    $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE curso=? ORDER BY apellido ASC");
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
                        <th scope="col" class="text-center align-middle">
                        <?php
                            $enlace_lista = "modificar.php?grado=" . $grado . "&letra=" . $letra;
                            $_SESSION['ruta_lista'] = $enlace_lista;
                            //echo '<a class="btn btn-success" href="' . $enlace_lista . '">Modificar</a>';
                        ?>
                        </th>
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
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
                </tbody>
                </table>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregar">Añadir estudiante.</button>

                    <!-- Agregar curso -->
                    <div class="modal modal-xl fade" id="agregar" tabindex="-1" role="dialog" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Añadir cursos:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <div class="modal-body" >
                                <div class="container">
    <form class="row g-3 mt-3" method="post" action="" enctype ="multipart/form-data">

        <div class="col-md-6">
            <label for="inputFoto" class="form-label">Insertar Foto</label>
            <input type="file" class="form-control" id="inputFoto" name="foto">
        </div>

        <div class="col-md-6">
            <label for="inputNombre" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="inputNombre" name="nombre">
        </div>

        <div class="col-12">
            <label for="inputApellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="inputApellidos" name="apellido">
        </div>

        <div class="col-md-4">
            <label for="inputTDoc" class="form-label">Tipo de documento</label>
            <select id="inputTDoc" class="form-select" name="td">
                <option selected> </option>
                <option>TI</option>
                <option>CC</option>
                <option>PPT</option>
            </select>
        </div>

        <div class="col-6">
            <label for="inputNumero" class="form-label">Número de documento</label>
            <input type="number" class="form-control" id="inputNumero" name="n_documento">
        </div>

        <div class="col-md-2">
        <label for="inputSexo" class="form-label">Sexo</label>
            <select class="form-select mt-2" name="sexo" id="inputSexo">
                    <option value=''>Seleccione sexo</option>
                    <option value='f'>Femenino</option>
                    <option value='m'>Masculino</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="inputEmail" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control" id="inputEmail" name="email">
        </div>

        <div class="col-md-4">
            <label for="inputFnacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="inputFnacimiento" name="f_nacimiento">
        </div>

        <div class="col-md-2">
            <label for="inputTDoc" class="form-label">Curso del estudiante</label>
            <select class="form-select mt-2" name="curso" id="inputTDoc">
                <option value=''>Seleccione curso</option>
                        <option value='11°A'>11°A</option>
                        <option value='11°B'>11°B</option>
                        <option value='11°C'>11°C</option>
                ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                    
                                </div>
                                </div>
                            </div>
                        </div>
            <?php
            }
            ?>
                
        </div>
        
    </div>
</div>

    </body>
</html>