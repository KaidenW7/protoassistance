<?php
//   session_start();
//   if (empty($_SESSION['user']) and empty($_SESSION['clave'])) {
//       header('location:login/login.php');
//   }

?>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">
    <h4 class="text-center text-secondary">Asistencia 11°</h4>

    <?php 
        include "../modelo/conexion.php";
        $sql=$conexion->query("SELECT foto, nombre, apellido FROM estudiantes_11");
    ?>

    <table class="table">
    <thead>
        <tr>
            <th scope="col">N°</th>
            <th></th>
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
            <td><img src="<?php echo $datos->foto; ?>" alt="Imagen"></td>
            <td><?= $datos->nombre?></td>
            <td><?= $datos->apellido?></td>
        </tr>
        <?php 
            $i++;
        }?>
    </tbody>
    </table>

</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>