<?php
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btniniciar"])) {
    // Verificar si se han enviado ambos campos
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        require_once('../modelo/conexion.php');
        // Realizar la consulta SQL de forma segura para evitar inyecciones SQL
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró un usuario
        if ($result->num_rows === 1) {
            // Obtener los datos del usuario
            $usuario_data = $result->fetch_assoc();
            if($usuario_data['id_rol']==1){
                // Realizar la consulta SQL de forma segura para evitar inyecciones SQL
                $stmt = $conexion->prepare("SELECT usuarios.*, usuario_asignatura.id_asignatura AS id FROM usuarios 
                INNER JOIN usuario_asignatura ON usuarios.id_usuario = usuario_asignatura.id_usuario
                WHERE usuarios.email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

            }
            $hash_clave_bd = $usuario_data['clave'];

            // Verificar que el hash de la contraseña coincida con la contraseña ingresada por el usuario
            $verificado = password_verify($password, $hash_clave_bd);

            if ($verificado) {
                // Usuario autenticado correctamente, redirigir a la página de inicio
                $_SESSION['id_usuario'] = $usuario_data['id_usuario'];
                $_SESSION['nombre'] = $usuario_data['n_completo'];
                $_SESSION['estado'] = $usuario_data['estado_cuenta'];

                if(isset($_SESSION['estado'])){
                    if($_SESSION['estado'] == "aprobado"){
                        if($usuario_data['id_rol']==1){
                            header("Location: ../vista/inicio.php");
                            $_SESSION['rol'] = $usuario_data['id_rol'];
                        }else{
                            header("Location: ../vista/admin.php");
                            $_SESSION['rol'] = $usuario_data['id_rol'];
                        }
                    }else{
                        if($_SESSION['estado'] == "pendiente"){
                            header("Location: ../index.php");
                        }else{
                            header("Location: ../index.php");
                        }
                    }
                }
                
                
                exit(); // Asegúrate de terminar el script después de redirigir
            } else {
                echo "La contraseña no coincide.";
            }
        } else {
            echo "El usuario no existe.";
        }
    } else {
        echo "Los campos están vacíos.";
    }
}
?>

