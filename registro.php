<!DOCTYPE html>
<?php require "head.php"; ?>
<body>
    <div class="first">
        <div class="imagen">
            <img id="backphoto" src="Archivos_Media/versión 3.jpg">
        </div>
        <div class="second">
            <section class="containerMenu">
                <h1>e-Assistance</h1>
                <h4>REGISTRO - NUEVO USUARIO</h4>
                    <?php 
                        //include "../conexion/conexion.php";
                        //include "../login/login.php";
                    ?>  
                    <form id="log_in" method="POST" action=""> 
                        <input type="text" placeholder="NOMBRE COMPLETO" maxlength="200" id="username" name="nombre">  
                        <input type="text" placeholder="EMAIL" maxlength="100" id="username" name="email">
                        <input type="password" placeholder="CONTRASEÑA" maxlength="100" id="password" name="password">
                        <input type="submit" id="log-in_button" name="btnregistrar" value="REGISTRAR">
                        
                    </form>
                    <?php 
                        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btnregistrar"])){ 
                            $nombre = $_POST['nombre']; 
                            $rol = 0; 
                            $email = $_POST['email']; 
                            $clave = $_POST['password']; 
                            $hash_clave = password_hash($clave, PASSWORD_DEFAULT);
                            $f_registro = date('Y-m-d H:i:s');
                            require_once('conexion.php'); 
                            $conexion = new mysqli("localhost", "root", "", "e-assistance", "3306");
                            mysqli_report(MYSQLI_REPORT_ERROR);
                            $sql = 'INSERT INTO usuarios (n_completo, rol, email, clave, f_registro) VALUES (?,?,?,?,?)'; 
                            $stmt = $conexion->prepare($sql); 
                            $stmt->bind_param("sisss", $nombre, $rol, $email, $hash_clave, $f_registro);
                            $stmt-> execute(); 
                            echo '<script>alert("Registro guardado con éxito");</script>';
                        }       
                    ?>
                <div id="box_row">
                    <div id="box_aligned">
                        <div id="fb"><i class="fa-brands fa-facebook-f"></i></div>
                        <div id="ig"><i class="fa-brands fa-instagram"></i></div>
                        <div id="wpp"><i class="fa-brands fa-whatsapp"></i></div>
                    </div>
                    <div id="division_line"></div>
                    <div id="box_aligned2"><h5 id="SM_name"><sup id="service_mark">SM</sup>e-Assistance 2023</h5></div>
                </div>
            </section>    
        </div>
    </div>
</body>
</html>