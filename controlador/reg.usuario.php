<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btnregistrar"])) {
    // Verificar si se han enviado ambos campos
    if (!empty($_POST["nombre"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Realizar la consulta SQL de forma segura para evitar inyecciones SQL
        $stmt = $connexion->prepare("SELECT * FROM usuario WHERE email = ? AND clave = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();

        // Obtener el resultado de la consulta
        $result = $stmt->get_result();

        // Verificar si se encontró un usuario
        if ($result->num_rows === 1) {
            // Usuario autenticado correctamente, redirigir a la página de inicio
            header("Location: inicio.php");
            exit(); // Asegúrate de terminar el script después de redirigir
        } else {
            echo "El usuario no existe.";
        }
    } else {
        echo "Los campos están vacíos.";
    }
}
?>