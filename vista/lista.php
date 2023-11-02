<?php
    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    if (isset($_GET['alerta']) && $_GET['alerta'] === 'exito') {
        // Muestra un mensaje de alerta
        echo '<script>alert("La operación se realizó con éxito.");</script>';
    }

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }

    $asignatura = $_SESSION['asignatura'];

    include "../modelo/conexion.php";

    $stmt = $conexion->prepare("SELECT * FROM asignaturas 
    WHERE id_asignatura = ?");
    $stmt->bind_param("i", $asignatura);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    $fila = $result->fetch_assoc();
    $valor = $fila['n_asignatura'];

?>
<!DOCTYPE html>
<?php include "../modelo/head1.php"; ?>
<body>

<!-- primero se carga el navbar -->



<!-- inicio del contenido principal -->
<div class="page-content">
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar bg-dark vh-120">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
        <div class="row">
            <?php require('navbar.php'); ?>
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
                    <h4 class="text-center">Asistencia <?php echo $curso; ?></h4> 
                    <h4 class="text-center"><?php echo $valor; ?></h4>
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                </div>
                <?php 
                    
                    $stmt = $conexion->prepare("SELECT id_est_11, foto, nombre, apellido FROM estudiantes_11 WHERE curso=? ORDER BY apellido ASC");
                    $stmt->bind_param("s", $curso);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                ?>

                <form method="post" action="">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="text-center align-middle">N°</th>
                        <th scope="col" class="text-center align-middle">Foto</th>
                        <th scope="col" class="text-center align-middle">Nombre</th>
                        <th scope="col" class="text-center align-middle">Apellido</th>
                        <th scope="col" class="text-center align-middle">Asistencia</th>
                        <th scope="col" class="text-center align-middle">
                        <?php
                            $enlace_lista = "modificar.php?grado=" . $grado . "&letra=" . $letra;
                            $_SESSION['ruta_lista'] = $enlace_lista;
                            echo '<a class="btn btn-success" href="' . $enlace_lista . '">Modificar</a>';
                        ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i = 1;
                    while ($datos = $result->fetch_object()){
                        ?>
                        <input type="hidden" value="<?= $datos->id_est_11?>">
                    <tr>
                        <th class="text-center align-middle"><?php echo $i;?></th>
                        <td class="text-center align-middle"><img src="<?php echo $datos->foto; ?>" alt="Imagen" width="50" height="70"></td>
                        <td class="text-center align-middle"><?= $datos->nombre?></td>
                        <td class="text-center align-middle"><?= $datos->apellido?></td>
                        <td class="text-center align-middle">
                            <label for="presente<?= $i ?>"><i class="fa-regular fa-circle-check"></i></label>
                            <input type="radio" name="asistencia[<?= $datos->id_est_11 ?>]" value="1" id="presente<?= $i ?>" checked>
                            <label for="ausente<?= $i ?>"><i class="fa-regular fa-circle-xmark"></i></label>
                            <input type="radio" name="asistencia[<?= $datos->id_est_11 ?>]" value="0" id="ausente<?= $i ?>">
                            <label for="incapacitado<?= $i ?>"><i class="fa-solid fa-user-slash"></i></label>
                            <input type="radio" name="asistencia[<?= $datos->id_est_11 ?>]" value="2" id="incapacitado<?= $i ?>">
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                    ?>
                </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
                </form> <br>
                
                <div class="container text-center">
                  Presente: <i class="fa-regular fa-circle-check"></i> |
                  Ausente: <i class="fa-regular fa-circle-xmark"></i> |
                  Incapacitado: <i class="fa-solid fa-user-slash"></i>
                </div>


            <?php
            }
            if (isset($_POST['asistencia'])) {
                $datos = $_POST['asistencia'];
                
                // Crear una consulta preparada
                $sql = "INSERT INTO asistencia (id_estudiante, estado, hora, fecha, id_asignatura) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                
                if ($stmt) {
                    $fecha = date("Y-m-d");
                    $hora = date("H:i:s");
            
                    // Vincular los parámetros
                    $stmt->bind_param("iissi", $id, $valor, $hora, $fecha, $asignatura);
            
                    // Recorrer el arreglo de datos y ejecutar la consulta para cada estudiante
                    foreach ($datos as $id => $valor) {
                        $stmt->execute();
                    }
            
                    // Cerrar la consulta preparada
                    $stmt->close();
                }
                ?>
                <script>
                    Swal.fire(
                    '¡Excelente!',
                    'La asistencia se guardó correctamente.',
                    'success'
                    )
                </script>
                
                <?php

                /*if (isset($_GET['alerta']) && $_GET['alerta'] === 'exito') {
                    // Muestra un mensaje de alerta
                    echo '<script>alert("La operación se realizó con éxito.");</script>';
                }*/
                ?>

                <script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href)
                    }
                </script>
            <?php
            }
            ?>
                
        </div>
      </div>
    </div>
</div>

    </body>
</html>