<!-- Modal -->
<div class="modal fade" id="recommendationLink" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content bg-dark text-light">
             <div class="modal-body">
                 <div class="mb-3">
                     <label for="new-password" class="form-label">Link de Recomendación</label>
                     <input type="text" class="form-control" id="recommLink" value="" readonly>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script>
     // Obtén una referencia al elemento de entrada
     var input = document.querySelector('#recommLink');

     // Escucha el evento 'click' del input
     input.addEventListener('click', function() {
         // Selecciona automáticamente el contenido del input
         this.select();
     });
 </script>