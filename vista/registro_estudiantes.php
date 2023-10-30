
<?php include "../modelo/head1.php"; ?>
<body>
    <div class="container">
    <form class="row g-3 mt-3" method="post" action="" enctype ="multipart/form-data">

        <div class="col-md-6">
            <label for="inputFoto" class="form-label">Insertar Foto</label>
            <input type="file" class="form-control" id="inputFoto" name="foto">
        </div>

        <div class="col-md-6">
            <label for="inputNombre" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="inputNombre" name="nombre">
        </div>

        <div class="col-12">
            <label for="inputApellidos" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="inputApellidos" name="apellido">
        </div>

        <div class="col-md-4">
            <label for="inputTDoc" class="form-label">Tipo de documento</label>
            <select id="inputTDoc" class="form-select" name="td">
                <option selected> </option>
                <option>TI</option>
                <option>CC</option>
                <option>PPT</option>
            </select>
        </div>

        <div class="col-6">
            <label for="inputNumero" class="form-label">Número de documento</label>
            <input type="number" class="form-control" id="inputNumero" name="n_documento">
        </div>

        <div class="col-md-2">
        <label for="inputSexo" class="form-label">Sexo</label>
            <select class="form-select mt-2" name="sexo" id="inputSexo">
                    <option value=''>Seleccione sexo</option>
                    <option value='f'>Femenino</option>
                    <option value='m'>Masculino</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="inputEmail" class="form-label">Correo Electrónico</label>
            <input type="text" class="form-control" id="inputEmail" name="email">
        </div>

        <div class="col-md-4">
            <label for="inputFnacimiento" class="form-label">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="inputFnacimiento" name="f_nacimiento">
        </div>

        <div class="col-md-2">
            <label for="inputTDoc" class="form-label">Curso del estudiante</label>
            <select class="form-select mt-2" name="curso" id="inputTDoc">
                <option value=''>Seleccione curso</option>
                        <option value='11°A'>11°A</option>
                        <option value='11°B'>11°B</option>
                        <option value='11°C'>11°C</option>
                ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
    </form>

    <?php 
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    $ruta = '../Archivos_Media/usuario_predeterminado.png'; // Reemplaza con la ruta correcta de la foto predeterminada
                }
            
                $nom = $_POST['nombre'];
                $ape = $_POST['apellido'];
                $td = $_POST['td'];
                $n_doc = $_POST['n_documento'];
                $f_nac = $_POST['f_nacimiento'];
                $email = $_POST['email'];
                $curso = $_POST['curso'];
                $sexo = $_POST['sexo'];
            
                require_once('../modelo/conexion.php');
                mysqli_report(MYSQLI_REPORT_ERROR);
            
                $sql = 'INSERT INTO estudiantes_11 (foto, nombre, apellido, td, n_documento, f_nacimiento, email, curso, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ssssissss", $ruta, $nom, $ape, $td, $n_doc, $f_nac, $email, $curso, $sexo);
                $stmt->execute();
            
                echo '<script>alert("Registro guardado con éxito");</script>';
            }
                   
        ?>

    </div>
</body>
</html>