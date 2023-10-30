
      
<?php
if (isset($_POST['opciones'])) {
    $opcionesSeleccionadas = $_POST['opciones'];
    
    include "../modelo/conexion.php";
    
    // Para cada opción seleccionada, realiza una consulta en la tabla "cursos"
    foreach ($opcionesSeleccionadas as $opcion) {
        // Divide el valor de la opción en número y letra
        list($numero, $letra) = explode('-', $opcion);

        // Realiza la consulta SQL para obtener el "id_curso" en base al número y letra
        $sql = "SELECT id_curso FROM cursos WHERE grado = $numero AND l_curso = '$letra'";
        $resultado = $conexion->query($sql);

        // Verifica si se encontró el "id_curso" y realiza las acciones necesarias
        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $id_curso = $fila['id_curso'];
            $id_usuario = $_POST['id'];
            
            $sql = "INSERT INTO usuario_curso (id_usuario, id_curso) VALUES (?, ?)";

            // Prepara la consulta
            $stmt = $conexion->prepare($sql);

            // Bindea los valores a la consulta SQL
            $stmt->bind_param("ii", $id_usuario, $id_curso);

            // Ejecuta la consulta
            $stmt->execute();

            // Verifica si la inserción se realizó con éxito
            if ($stmt->affected_rows > 0) {
                // Genera un enlace único para cada curso usando el ID del curso como parámetro GET
                $enlace = "../vista/asignar_cursos.php?usuario=" . $id_usuario . "&new_curso=" . $id_curso;
                header("Location: " . $enlace);
            } else {
                echo "Error al insertar en usuario_curso: " . $stmt->error;
            }

            // Cierra el statement
            $stmt->close();
        }
    }
}
?>

    

<!-- Eliminar cursos -->
<?php
if (isset($_POST['opciones2'])) {
    $opcionesSeleccionadas = $_POST['opciones2'];
    
    include "../modelo/conexion.php";
    
    // Para cada opción seleccionada, realiza una consulta en la tabla "cursos"
    foreach ($opcionesSeleccionadas as $opcion) {
        // Divide el valor de la opción en número y letra
        list($numero, $letra) = explode('-', $opcion);

        // Realiza la consulta SQL para obtener el "id_curso" en base al número y letra
        $sql = "SELECT id_curso FROM cursos WHERE grado = $numero AND l_curso = '$letra'";
        $resultado = $conexion->query($sql);

        // Verifica si se encontró el "id_curso" y realiza las acciones necesarias
        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $id_curso = $fila['id_curso'];
            $id_usuario = $_POST['id'];;
            
            $sql = "DELETE FROM usuario_curso WHERE id_usuario = ? AND id_curso = ?";

            // Prepara la consulta
            $stmt = $conexion->prepare($sql);

            // Bindea los valores a la consulta SQL
            $stmt->bind_param("ii", $id_usuario, $id_curso);

            // Ejecuta la consulta
            $stmt->execute();

            // Verifica si la eliminación se realizó con éxito
            if ($stmt->affected_rows > 0) {
                // Genera un enlace único para cada curso usando el ID del curso como parámetro GET
                $enlace = "../vista/asignar_cursos.php?usuario=" . $id_usuario . "&delete_curso=" . $id_curso;
                header("Location: " . $enlace);
            } else {
                echo "Error al eliminar en usuario_curso: " . $stmt->error;
            }

            // Cierra el statement
            $stmt->close();
            }
    }
}
?>

<!-- Asignar usuarios - Primera vez -->

<?php
if (isset($_POST['opciones3'])) {
    $opcionesSeleccionadas = $_POST['opciones3'];
    
    include "../modelo/conexion.php";
    
    // Para cada opción seleccionada, realiza una consulta en la tabla "cursos"
    foreach ($opcionesSeleccionadas as $opcion) {
        // Divide el valor de la opción en número y letra
        list($numero, $letra) = explode('-', $opcion);

        // Realiza la consulta SQL para obtener el "id_curso" en base al número y letra
        $sql = "SELECT id_curso FROM cursos WHERE grado = $numero AND l_curso = '$letra'";
        $resultado = $conexion->query($sql);

        // Verifica si se encontró el "id_curso" y realiza las acciones necesarias
        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $id_curso = $fila['id_curso'];
            $id_u = $_POST['id'];
            
            $sql = "INSERT INTO usuario_curso (id_usuario, id_curso) VALUES (?, ?)";

            // Prepara la consulta
            $stmt = $conexion->prepare($sql);

            // Bindea los valores a la consulta SQL
            $stmt->bind_param("ii", $id_u, $id_curso);

            // Ejecuta la consulta
            $stmt->execute();

            // Verifica si la inserción se realizó con éxito
            if ($stmt->affected_rows > 0) {
                $enlace = "../vista/asignar_cursos.php?usuario=" . $id_usuario . "&new_curso=" . $id_curso;
                header("Location: " . $enlace);
            } else {
                echo "Error al insertar en usuario_curso: " . $stmt->error;
            }

            // Cierra el statement
            $stmt->close();
        }
    }
}
?>
