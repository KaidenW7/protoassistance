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

<!-- inicio del contenido principal -->
<div class="page-content">
    <!-- primero se carga el navbar -->
    <?php require('navbar.php'); ?>
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <?php
                ?>
                <div class="contenedor">
                    <h4 class="text-center">Asignar cursos a los docentes</h4> 
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                </div>
                <?php 
                    include "../modelo/conexion.php";
                    $stmt = $conexion->prepare("SELECT usuarios.id_usuario, UPPER(usuarios.n_completo) AS n_completo_mayusculas, CONCAT(cursos.grado, 'º', UPPER(cursos.l_curso)) AS curso_completo
                    FROM usuarios
                    INNER JOIN usuario_curso ON usuarios.id_usuario = usuario_curso.id_usuario
                    INNER JOIN cursos ON usuario_curso.id_curso = cursos.id_curso
                    ORDER BY cursos.grado ASC, cursos.l_curso ASC;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                ?>

                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">N°</th>
                        <th scope="col" class="text-center align-middle">Nombre Completo</th>
                        <th scope="col" class="text-center align-middle">Cursos Asignados</th>
                        <th scope="col" class="text-center align-middle">Añadir/Elimira</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $j = 1;
                $usuarios = []; // Un array para almacenar los datos de los usuarios y sus cursos asignados.

                while ($datos = $result->fetch_object()) {
                    $id_usuario = $datos->id_usuario;
                    $nombre_usuario = $datos->n_completo_mayusculas;
                    $nombre_curso = $datos->curso_completo; // El campo concatenado que obtuviste en tu consulta SQL.

                    // Verifica si el usuario ya está en el array, y agrega el curso al usuario existente.
                    if (isset($usuarios[$id_usuario])) {
                        $usuarios[$id_usuario]['cursos'][] = $nombre_curso;
                    } else {
                        // Si es un nuevo usuario, crea una entrada en el array.
                        $usuarios[$id_usuario] = [
                            'id_usuario' => $id_usuario,
                            'nombre' => $nombre_usuario,
                            'cursos' => [$nombre_curso],
                        ];
                    }
                }

                // Ahora puedes recorrer el array $usuarios para mostrar los datos en una tabla.
                ?>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <th class="text-center align-middle"><?= $j;?></th>
                                <td class="text-center align-middle"><?= $usuario['nombre']; ?></td>
                                <td class="text-center align-middle"><?= implode(' - ', $usuario['cursos']); ?></td>
                                <td class="text-center align-middle">
                                        <button type="button" name="agregar" value="agregar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregar<?php echo $usuario['id_usuario']; ?>"><i class="fa-solid fa-square-plus"></i></button>
                                        <button type="button" name="eliminar" value="eliminar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminar<?php echo $usuario['id_usuario']; ?>"><i class="fa-solid fa-rectangle-xmark"></i></button>
                                </td>
                            </tr>
                            <?php $j++; ?>
                        <?php 
                        ?>
                        <!-- Agregar curso -->
                        <div class="modal fade" id="agregar<?php echo $usuario['id_usuario']; ?>" tabindex="-1" role="dialog" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Añadir cursos:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <div class="modal-body" >
                                    <form action="../controlador/asignar_eliminar_curso.php" method="post">
                                    <input type="hidden" id="Id" name="id" value="<?= $usuario['id_usuario']; ?>">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="cursos">Seleccione los cursos.<br> Sontenga la tecla control para seleccionar*</label>
                                            <select class="form-select mt-2" size="6" name="opciones[]" multiple>
                                                <?php
                                                    for ($i = 6; $i <= 11; $i++) {
                                                        echo "<option value='$i-a'>$i A</option>";
                                                        echo "<option value='$i-b'>$i B</option>";
                                                        echo "<option value='$i-c'>$i C</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" name="agregar" class="btn btn-primary mt-2">Agregar</button>
                                    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                    
                                </div>
                                </div>
                            </div>
                        </div>

                        <!-- Eliminar cursos -->
                            <div class="modal fade" id="eliminar<?php echo $usuario['id_usuario']; ?>" tabindex="-1" role="dialog" data-bs-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                                <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar cursos:</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                
                                <div class="modal-body" >
                                    <form action="../controlador/asignar_eliminar_curso.php" method="post">
                                    <input type="hidden" id="Id" name="id" value="<?= $usuario['id_usuario']; ?>">

                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="foto">Seleccione los cursos.<br> Sontenga la tecla control para seleccionar*</label>
                                            <select class="form-select mt-2" size="6" name="opciones2[]" multiple>
                                                <?php
                                                    for ($i = 6; $i <= 11; $i++) {
                                                        echo "<option value='$i-a'>$i A</option>";
                                                        echo "<option value='$i-b'>$i B</option>";
                                                        echo "<option value='$i-c'>$i C</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" name="agregar" class="btn btn-danger mt-2">Eliminar</button>
                                    </form>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        endforeach; ?>
                    </tbody>
                </table>
                

                <!--En la siguiente tabla se muestran los usuarios sin cursos y la función añadirle-->

                <div class="contenedor  mt-5">
                    <h4 class="text-center">Usuarios pendientes por asignar cursos.</h4> 
                </div>

                <?php 
                    include "../modelo/conexion.php";
                    $stmt = $conexion->prepare("SELECT usuarios.id_usuario, UPPER(usuarios.n_completo) AS n_completo_mayusculas
                    FROM usuarios
                    LEFT JOIN usuario_curso ON usuarios.id_usuario = usuario_curso.id_usuario
                    WHERE usuario_curso.id_usuario IS NULL
                    AND usuarios.id_rol != 2
                    AND usuarios.estado_cuenta != 'denegado';
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                ?>

                <form method="post" action="">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">N°</th>
                        <th scope="col" class="text-center align-middle">Nombre completo</th>
                        <th scope="col" class="text-center align-middle">Asignar cursos</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $j = 1;
                    while ($datos = $result->fetch_object()){
                        $id_usuario = $datos->id_usuario;
                        ?>
                    <tr>
                        <th class="text-center align-middle"><?php echo $j;?></th>
                        <td class="text-center align-middle"><?= $datos->n_completo_mayusculas?></td>
                        <td class="text-center align-middle">
                            <form action="" method="post">
                                <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                <button type="button" name="asignar" value="asignar" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#asignar<?= $id_usuario; ?>"><i class="fa-solid fa-square-plus"></i></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php 
                        $j++;
                    ?>

                    <!-- Asiganar cursos - Primera vez -->
                    <div class="modal fade" id="asignar<?= $id_usuario; ?>" tabindex="-1" role="dialog" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                            <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Asignar cursos:</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            
                            <div class="modal-body" >
                                <form action="../controlador/asignar_eliminar_curso.php" method="post">
                                <input type="hidden" id="Id" name="id" value="<?= $id_usuario; ?>">

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="foto">Seleccione los cursos.<br> Sontenga la tecla control para seleccionar*</label>
                                        <select class="form-select mt-2" size="6" name="opciones3[]" multiple>
                                            <?php
                                                for ($i = 6; $i <= 11; $i++) {
                                                    echo "<option value='$i-a'>$i A</option>";
                                                    echo "<option value='$i-b'>$i B</option>";
                                                    echo "<option value='$i-c'>$i C</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="agregar" class="btn btn-primary mt-2">Agregar</button>
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
                </tbody>
                </table>
                </form>

                <script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href)
                    }
                </script>
                
        </div>
        
    </div>
</div>
<?php
                //include "../controlador/asignar_eliminar_curso.php";
                ?>
                
    </body>
</html>