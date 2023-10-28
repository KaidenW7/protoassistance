<?php
//Inicia la sesión para acceder a las variables de sesión
/*session_start();

//Verifica si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    //Si no está autenticado, redirige al usuario al inicio de sesión
    header("Location: ../index.php");
    
}*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once('../modelo/conexion.php');

  

  $nuevaFoto = $_FILES['foto']['name']; // Nombre del nuevo archivo de imagen

    if (!empty($nuevaFoto)) {
      // Consulta SQL de UPDATE
    $sql_update = "UPDATE estudiantes_11 SET foto=?, nombre=?, apellido=? WHERE id_est_11=?";
        // Obtener los datos del formulario con foto
        $id = $_POST['id']; // Debes obtener el valor del campo 'id' del formulario
        $n_imagen = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $carpeta='../Archivos_Media';
        $ruta=$carpeta."/".$n_imagen;
        move_uploaded_file($tmp,$carpeta."/".$n_imagen);
        $nombres = $_POST['nombre'];
        $apellidos = $_POST['apellido'];

        // Bindear los valores a la consulta SQL
        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bind_param('sssi', $ruta, $nombres, $apellidos, $id);
    }else{
      // Consulta SQL de UPDATE
      $sql_update = "UPDATE estudiantes_11 SET nombre=?, apellido=? WHERE id_est_11=?";
      // Obtener los datos del formulario sin foto
      $id = $_POST['id'];
      $nombres = $_POST['nombre'];
      $apellidos = $_POST['apellido'];

      // Bindear los valores a la consulta SQL
      $stmt_update = $conexion->prepare($sql_update);
      $stmt_update->bind_param('ssi', $nombres, $apellidos, $id);
    }

  

  // Ejecutar la consulta SQL
  if ($stmt_update->execute()) {
      $ruta = $_POST['ruta'];
      /*$ruta = $_COOKIE['ruta_lista'];
      
      if (strpos($ruta, '?') === false) {
        // Si no hay otros parámetros, agrega el primero con un signo de interrogación
        $ruta .= '?alerta=exito';
    } else {
        // Si ya hay otros parámetros, agrega uno nuevo con un signo de ampersand
        $ruta .= '&alerta=exito';
    }*/
    
    header("Location: ../vista/$ruta");
    exit;
      ?>

      <?php
  } else {
      echo "Error al actualizar los datos: " . $stmt_update->error;
  }

  // Cerrar la conexión
  $stmt_update->close();
  $conexion->close();
}


?>

