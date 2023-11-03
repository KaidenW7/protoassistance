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
    <div class="row mx-1">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar bg-dark vh-110">
            <?php include "sidebar.php"; ?>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-9 col-xl-10">
            <div class="row">
                <!-- primero se carga el navbar -->
                <?php require('navbar.php'); ?>
                <?php
                if (isset($_GET['grado']) and isset($_GET['letra'])) {
                $grado = $_GET['grado'];
                $letra = $_GET['letra'];
                $l_mayus = strtoupper($letra);
                $curso = $grado."°".$l_mayus;
                $tabla = "estudiantes_".$grado;
                $id = "id_est_".$grado;

                // Genera un enlace único para cada curso usando el ID del curso como parámetro GET
                $enlace_lista = "lista1.php?grado=" . $grado . "&letra=" . $letra;


                ?>
                <div class="container">
                    <div class="container">
                        <div class="text-center">
                            <h4 style="display: inline-block; margin-right: 25px;">Generar informes de asistencia | Grado <?php echo $curso; ?></h4>
                        </div>
                    </div>
                    <?php 
                    include "../modelo/formato_fecha.php";
                    echo fecha();
                    ?>
                    <div class="container text-center mb-3 mt-3">
                        <button type="button" class="btn btn-info">Generar informe general. <i class="fa-solid fa-chart-simple fa-xl"></i></i></button>
                    </div>
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
                        <th scope="col" class="text-center align-middle">Informe</th>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i = 1;
                    while ($datos = $result->fetch_object()){
                        $sex = strtoupper($datos->sexo);
                        ?>
                    <tr>
                        <th class="text-center align-middle"><?php echo $i;?></th>
                        <td class="text-center align-middle"><img src="<?php echo $datos->foto; ?>" alt="Imagen" width="50" height="70"></td>
                        <td class="text-center align-middle"><?= $datos->nombre." ".$datos->apellido?></td>
                        <td class="text-center align-middle">
                                <a href="../modelo/formato_informe.php?id_estudiante=<?= $datos->id_est_11 ?>" class="btn btn-info">
                                    <i class="fa-solid fa-file-pdf fa-2xl"></i>
                                </a>                            
                        </td>
                    </tr>
                    <?php 
                        $i++;
                    }
                }
                    ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>