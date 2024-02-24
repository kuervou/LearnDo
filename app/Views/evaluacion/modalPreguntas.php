   <!-- Modal para crear preguntas -->
    <div class="modal fade" id="modalCrearPregunta" tabindex="-1" aria-labelledby="modalCrearPreguntaLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content bg-dark text-light" >
          <div class="modal-header">
            <h5 class="modal-title" id="modalCrearPreguntaLabel">Crear Pregunta</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- Puntuación -->
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="puntuacion" class="form-label">Puntuación</label>
                  <input type="number" class="form-control" id="puntuacion" min="0" step="1" required>
                </div>
              </div>

              <!-- Contenido de la pregunta -->
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="contenido" class="form-label">Contenido de la Pregunta</label>
                  <textarea class="form-control" id="contenido" rows="3" required></textarea>
                </div>
              </div>
            </div>

            <!-- Opciones de la pregunta -->
            <div class="mb-3">
              <label for="opciones" class="form-label">Opciones de la Pregunta</label>
              <table class="table table-striped table-hover text-white">
                <thead>
                  <tr>
                    <th>Texto de la Opción</th>
                    <th>Correcta</th>
                  </tr>
                </thead>
                <tbody id="opcionesBody">
                  <tr>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="checkbox" class="form-check-input"></td>
                  </tr>
                </tbody>
              </table>
              <button type="button" class="btn btn-secondary" id="crearOpciones">Agregar Opción</button>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="confirmarPregunta">Confirmar Pregunta</button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalListaPreguntas" id="agregarPregunta">Continuar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para ver la lista de preguntas -->
    <div class="modal fade" id="modalListaPreguntas" tabindex="-1" aria-labelledby="modalListaPreguntasLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header">
            <h5 class="modal-title" id="modalListaPreguntasLabel">Lista de Preguntas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <ul id="listaPreguntas"></ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="finalizar">Finalizar</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
      document.getElementById('crearOpciones').addEventListener('click', function() {
          const opcionesBody = document.getElementById('opcionesBody');
          const newRow = document.createElement('tr');

          newRow.innerHTML = `
              <td><input type="text" class="form-control"></td>
              <td><input type="checkbox" class="form-check-input"></td>
          `;

          opcionesBody.appendChild(newRow);
      });

      let preguntas = [];

      document.getElementById('confirmarPregunta').addEventListener('click', function() {
          const puntuacion = document.getElementById('puntuacion').value;
          const contenido = document.getElementById('contenido').value;
          const opciones = [...document.getElementById('opcionesBody').children].map(row => {
              const inputs = row.getElementsByTagName('input');
              return {
                  texto: inputs[0].value,
                  correcta: inputs[1].checked
              };
          });

          if (puntuacion === '' || contenido === '' || opciones.some(opcion => opcion.texto === '')) {
              alert('Por favor, complete todos los campos requeridos');
              return;
          }

          preguntas.push({
              puntuacion,
              contenido,
              opciones
          });

          alert('Pregunta confirmada!');
      });

      document.getElementById('confirmarPregunta').addEventListener('click', function() {
    const listaPreguntas = document.getElementById('listaPreguntas');
    listaPreguntas.innerHTML = preguntas.map((pregunta, i) => {
        const opcionesHTML = pregunta.opciones.map(opcion => {
            return `<li style="background-color: #0000001a; color: white;">${opcion.texto} ${opcion.correcta ? '(Correcta)' : ''}</li>`;
        }).join('');

        return `<li style="background-color: #0000001a; color: white;">Pregunta ${i + 1}: ${pregunta.contenido}<ul>${opcionesHTML}</ul></li>`;
    }).join('');

    // Limpiar formulario
    document.getElementById('puntuacion').value = '';
    document.getElementById('contenido').value = '';
    document.getElementById('opcionesBody').innerHTML = `
        <tr>
            <td><input type="text" class="form-control"></td>
            <td><input type="checkbox" class="form-check-input"></td>
        </tr>`;
    });

    document.getElementById('finalizar').addEventListener('click', function() {
      var urlParams = new URLSearchParams(window.location.search);
      var id_evaluacion = urlParams.get('id_evaluacion');

      // Asegúrate de que id_evaluacion está definido y no es null
      if (id_evaluacion) {
          $.ajax({
              url: 'crearPreguntas',
              method: 'POST',
              contentType: 'application/json',
              data: JSON.stringify({
                  id_evaluacion: id_evaluacion,
                  preguntas: preguntas
              }),
              success: function(response) {
                  alert('Preguntas creadas con éxito');
                  preguntas = [];
              },
              error: function(xhr, status, error) {
                  alert('Ocurrió un error al crear las preguntas: ' + error);
              }
          });
      }
  });
    </script>