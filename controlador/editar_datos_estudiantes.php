<!-- formulario de eventos -->
<div class="modal fade" id="editar" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">x</span>
            </button>

          
          </div>
          
          <div class="modal-body" >
            <input type="hidden" id="Id">

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Titulo del evento: </label>
                <input type="text" id="Titulo" class="form-control" placeholder="">
              </div>
            </div>

            <div class="form-row">
              <div class="foor-group col-md-6">
                <label>Fecha de inicio: </label>
                <div class="input-group" data-autoclose="true">
                  <input type="date" id="FechaInicio" class="form-control" value="">

                </div>
              </div>
              <div class="foor-group col-md-6" id="TituloHoraInicio">
                <label>Hora de inicio: </label>
                <div class="input-group" data-autoclose="true">
                  <input type="time" id="HoraInicio" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="foor-group col-md-6">
                <label>Fecha de fin: </label>
                <div class="input-group" data-autoclose="true">
                  <input type="date" id="FechaFin" class="form-control" value="">

                </div>
              </div>
              <div class="foor-group col-md-6" id="TituloHoraFin">
                <label>Hora de fin: </label>
                <div class="input-group" data-autoclose="true">
                  <input type="time" id="HoraFin" class="form-control" autocomplete="off">
                </div>
              </div>
            </div>


            <div class="form-row">
              <label>Descripcion: </label>
              <textarea id="Descripcion" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-row">
              <label>Color de fondo:</label>
              <input type="color" value="#0fff00" id="ColorFondo" class="form-control" style="height: 36px;">
            </div>
            <div class="form-row">
              <label>Color de texto:</label>
              <input type="color" value="#000000" id="ColorTexto" class="form-control" style="height: 36px;">
            </div>
          </div>
        
        </div>
      </div>
    </div>
    
<?php
