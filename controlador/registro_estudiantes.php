    <?php 

    //Inicia la sesión para acceder a las variables de sesión
    session_start();

    //Verifica si el usuario está autenticado
    if (!isset($_SESSION['id_usuario'])) {
        //Si no está autenticado, redirige al usuario al inicio de sesión
        header("Location: ../index.php");
        
    }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $sexo = $_POST['sexo'];
                // Comprueba si se cargó una foto
                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                    // Se cargó una foto
                    $n_imagen = $_FILES['foto']['name'];
                    $tmp = $_FILES['foto']['tmp_name'];
                    $carpeta = '../Archivos_Media';
                    $ruta = $carpeta . "/" . $n_imagen;
                    move_uploaded_file($tmp, $carpeta . "/" . $n_imagen);
                } else {
                    // No se cargó una foto, establece una foto predeterminada
                    if($sexo=="f"){
                        $ruta = '../Archivos_Media/usuario_predeterminado_f.png'; // Reemplaza con la ruta correcta de la foto predeterminada
                    }else {
                    $ruta = '../Archivos_Media/usuario_predeterminado_m.png'; // Reemplaza con la ruta correcta de la foto predeterminada
                    }
                }
            
                $nom = $_POST['nombre'];
                $ape = $_POST['apellido'];
                $td = $_POST['td'];
                $n_doc = $_POST['n_documento'];
                $f_nac = $_POST['f_nacimiento'];
                $email = $_POST['email'];
                $curso = $_POST['curso'];
               
            
                require_once('../modelo/conexion.php');
                mysqli_report(MYSQLI_REPORT_ERROR);
            
                $sql = 'INSERT INTO estudiantes_11 (foto, nombre, apellido, td, n_documento, f_nacimiento, email, curso, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssssissss", $ruta, $nom, $ape, $td, $n_doc, $f_nac, $email, $curso, $sexo);
            
                if ($stmt->execute()) {
                    $ruta = $_POST['ruta1'];
                  
                  header("Location: ../vista/$ruta");
                  exit;
                }
            }
                   
        ?>

    </div>
</body>
</html>