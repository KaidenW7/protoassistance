
<?php  

    if(isset($_SESSION['rol'])){
        if($_SESSION['rol'] != 2){
            $ruta = "../vistaUsuario/inicio.php";
        }else{
            $ruta = "../vistaAdministrador/admin.php";
        }
    }
require('../modelo/head1.php');
?>

<nav class="position-fixed" >
    
    <div class="p-4">
        <div class="text-center">
            <a class="navbar-brand" href="inicio.php"><img src="../Archivos_Media/img_web.png" alt="" srcset="" width="150" height="140"></a>
        </div>
        <ul class="space_ul">
            <li class="space">
                <a class="eti_a" href="<?php echo $ruta; ?>"><span class="fa fa-home mr-3"></span> Home</a>
            </li>
            <li class="space">
                <a class="eti_a" href="Prueba.php"><span class="fa fa-user mr-3"></span> About</a>
            </li>
            
            <li class="space">
                <a class="eti_a" href="#"><span class="fa fa-cogs mr-3"></span> Services</a>
            </li>
            
        </ul>
        <div class="footer">
            <!-- Aquí puedes agregar contenido adicional si es necesario -->
        </div>
    </div>
</nav>
