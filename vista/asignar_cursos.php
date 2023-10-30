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
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Cursos Asignados</th>
                        <th scope="col" class="text-center align-middle">Añadir curso</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
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
                                <th class="text-center align-middle"><?= $i; ?></th>
                                <td class="text-center align-middle"><?= $usuario['nombre']; ?></td>
                                <td class="text-center align-middle"><?= implode(' - ', $usuario['cursos']); ?></td>
                                <td class="text-center align-middle">
                                    <form action="" method="post">
                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                        <button type="submit" name="habilitar" value="habilitar" class="btn btn-success"><i class="fa-solid fa-square-check"></i></button>
                                        <button type="submit" name="denegar" value="denegar" class="btn btn-danger"><i class="fa-solid fa-rectangle-xmark"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <?php

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        require_once('../modelo/conexion.php');

                        if (isset($_POST['habilitar'])) {
                            // Consulta SQL de UPDATE
                            $sql_update = "UPDATE usuarios SET estado_cuenta=? WHERE id_usuario=?";
                            // Obtener los datos del formulario sin foto
                            $id = $_POST['id_usuario'];
                            $estado = "aprobado";

                            // Bindear los valores a la consulta SQL
                            $stmt_update = $conexion->prepare($sql_update);
                            $stmt_update->bind_param('si', $estado, $id);
                            $stmt_update->execute();
                            ?>
                            <script>
                                Swal.fire(
                                '¡Excelente!',
                                'El usuario ha sido habilitado.',
                                'success'
                                )
                            </script>
                            
                            <?php
                            
                        } elseif (isset($_POST['denegar'])) {
                            // Consulta SQL de UPDATE
                            $sql_update = "UPDATE usuarios SET estado_cuenta=? WHERE id_usuario=?";
                            // Obtener los datos del formulario sin foto
                            $id = $_POST['id_usuario'];
                            $estado = "denegado";

                            // Bindear los valores a la consulta SQL
                            $stmt_update = $conexion->prepare($sql_update);
                            $stmt_update->bind_param('si', $estado, $id);
                            $stmt_update->execute();
                            ?>
                            <script>
                                Swal.fire(
                                'Completado',
                                'El usuario ha sido denegado.',
                                'success'
                                )
                            </script>
                            
                            <?php
                        }
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