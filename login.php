<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btniniciar"])) {
    // Verificar si se han enviado ambos campos
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Escapar los caracteres especiales en la contraseña
        $password_escapado = mysqli_real_escape_string($conexion, $password);

        require_once('conexion.php');
        $conexion = new mysqli("localhost", "root", "", "e-assistance", "3306");
        // Realizar la consulta SQL de forma segura para evitar inyecciones SQL
        $stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ? AND clave = ?");
        $stmt->bind_param("ss", $email, $password_escapado);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró un usuario
        if ($result->num_rows === 1) {
            // ...
        } else {
            echo "El usuario no existe.";
        }
    } else {
        echo "Los campos están vacíos.";
    }
}

// Función para generar un hash de la contraseña
function hash_clave($clave) {
    return password_hash($clave, PASSWORD_DEFAULT);
}
?>