<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> 
    <title>Registro Estudiantes</title>
</head>
<body>
    
    <div class="container"> 
        <div class="container-sm" style="margin-top:1%">
            <form method="POST" action="">
                <h3>Registro de estudiante</h3><br>
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" accept="image/*"> 
                </div>
            
                <div class="form-group">
                    <label for="txtDoc">Selecionar tipo de documento</label>
                    <select name="txtTD" class="form-control" required>
                        <option value="CC">Cédula de ciudadanía</option> 
                        <option value="TI">Tarjeta de identidad</option> 
                        <option value="CE">Cédula de extranjería</option> 
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtDoc">Identificación</label>
                    <input type="text" class="form-control" name="txtDoc" placeholder="Ingrese el documento de identidad" required> 
                </div>
                
                <div class="form-group">
                    <label for="txtNombres">Nombres</label>
                    <input type="text" class="form-control" name="txtNombres" placeholder="Ingrese Nombres" required> 
                </div>

                <div class="form-group">
                    <label for="txtApellidos">Apellidos</label>
                    <input type="text" class="form-control" name="txtApellidos" placeholder="Ingrese Apellidos" required> 
                </div>

                <div class="form-group">
                    <label for="txtTelefono">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="f_nacimiento" placeholder="Ingrese fecha de nacimiento" required> 
                </div>

                <div class="form-group">
                    <label for="txtDir">Correo Electrónico</label>
                    <input type="text" class="form-control" name="txtDir" placeholder="Ingrese correo electrónico<" required> 
                </div>

                <div class="form-group">
                    <label for="curso">Selecionar curso</label>
                    <select name="curso" class="form-control" required>
                        <option value="11_a">11°A</option> 
                        <option value="11_b">11°B</option> 
                        <option value="11_c">11°C</option> 
                    </select>
                </div>

               
                <input type="submit" class="btn btn-primary" value="Registrar"> 
            </form>
        
        <?php 
            if($_POST){
                $foto = $_FILES['foto']['tmp_name'];
                $td = $_POST['txtTD']; 
                $id = $_POST['txtDoc']; 
                $nom = $_POST['txtNombres']; 
                $ape = $_POST['txtApellidos']; 
                $f_nacimiento = $_POST['f_nacimiento']; 
                $email = $_POST['txtDir'];  
                $curso = $_POST['curso']; 
                require_once('conexion.php');
                mysqli_report(MYSQLI_REPORT_ERROR);
                $sql = 'INSERT INTO estudiantes_11 (foto, td, n_documento, nombre, apellido, f_nacimiento, email, curso) VALUES
                    (?,?,?,?,?,?,?,?)'; 
                $stmt = $conexion->prepare($sql); 
                $stmt->bind_param("bsssssss", $foto, $td, $id, $nom, $ape, $f_nacimiento, $email, $curso);
                $stmt-> execute(); 
                echo '<script>alert("Registro guardado con éxito");</script>';
            }       
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>