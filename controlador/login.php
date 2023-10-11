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
            // Verificar que el hash de la contraseña coincida con la contraseña ingresada por el usuario
            $hash_clave_bd = $result->fetch_assoc()['clave'];
            $verificado = password_verify($password, $hash_clave_bd);

            if ($verificado) {
                // Usuario autenticado correctamente, redirigir a la página de inicio
                //$_SESSION['id_usuario'] = $row->id_usuario;
                //$_SESSION['email'] = $row->email;
                header("Location: ../vista/inicio.php");
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