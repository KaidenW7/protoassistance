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
    
    <div class="row  mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar bg-dark vh-100">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="row">
            <?php require('navbar.php'); ?>
            <?php
                $rol = 1;
                $est_cuenta = "pendiente";
                ?>
                <div class="contenedor">
                    <h4 class="text-center">Usuarios por habilitar</h4> 
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                </div>
                <?php 
                    include "../modelo/conexion.php";
                    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id_rol=? AND estado_cuenta=?");
                    $stmt->bind_param("is", $rol, $est_cuenta);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                ?>

                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">N°</th>
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Email</th>
                        <th scope="col" class="text-center align-middle">Feche de registro</th>
                        <th scope="col" class="text-center align-middle">Estado de cuenta</th>
                        <th scope="col" class="text-center align-middle">Hablitar/Denegar</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i = 1;
                    while ($datos = $result->fetch_object()){
                        $id_usuario = $datos->id_usuario
                        ?>
                    <tr>
                        <th class="text-center align-middle"><?php echo $i;?></th>
                        <td class="text-center align-middle"><?= $datos->n_completo?></td>
                        <td class="text-center align-middle"><?= $datos->email?></td>
                        <td class="text-center align-middle"><?= $datos->f_registro?></td>
                        <td class="text-center align-middle"><?= $datos->estado_cuenta?></td>
                        <td class="text-center align-middle">
                            <form action="" method="post">
                                <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                <button type="submit" name="habilitar" value="habilitar" class="btn btn-success"><i class="fa-solid fa-square-check"></i></button>
                                <button type="submit" name="denegar" value="denegar" class="btn btn-danger"><i class="fa-solid fa-rectangle-xmark"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
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
</div>

    </body>
</html>