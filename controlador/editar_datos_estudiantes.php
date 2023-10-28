<!-- modificar -->
    <div class="modal fade" id="editar" tabindex="-1" role="dialog" data-bs-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title">Editar datos del estudiante:</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          
          <div class="modal-body" >
          <?php                
                // Preparar la consulta SQL para seleccionar registros
                $sql = "SELECT foto, nombre, apellido FROM estudiantes_11 WHERE id_est_11=? ";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param('i', $idEstudiante);
                
                // Ejecutar la consulta
                $stmt->execute();
                
                // Obtener los resultados
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
            ?>
            <form action="">
              <input type="hidden" id="Id" value="<?php echo $row['ID'] ?>">

              <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" accept="image/*">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Nombres: </label>
                  <input type="text" id="Titulo" class="form-control" value="<?php echo $row['nombre'] ?>">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label>Apellido</label>
                  <input type="text" id="Titulo" class="form-control" value="<?php echo $row['apellido'] ?>">
                </div>
              </div>
            </form>

          </div>

          <div class="modal-footer">
              <button class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button> 
              <button class="btn btn-primary">Guardar</button>
          </div>
          <?php
        }
      }
    //}
        
        ?>
        </div>
      </div>
</div>


                   