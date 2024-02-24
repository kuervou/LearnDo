 
    <!-- Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="new-password" class="form-label">Nueva contraseña</label>
          <input type="password" class="form-control" maxlength="32" id="new-password">
        </div>
        <div class="mb-3">
          <label for="confirm-new-password" class="form-label">Confirmar nueva contraseña</label>
          <input type="password" class="form-control" maxlength="32" id="confirm-new-password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="savePasswordChanges">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>

<script>
  const newPasswordField = document.getElementById('new-password');
  const confirmNewPasswordField = document.getElementById('confirm-new-password');
  const savePasswordChangesButton = document.getElementById('savePasswordChanges');

  function verifyNewPasswordsMatch() {
    if (newPasswordField.value !== confirmNewPasswordField.value) {
      confirmNewPasswordField.setCustomValidity('Las contraseñas no coinciden.');
    } else {
      confirmNewPasswordField.setCustomValidity('');
    }
  }
  
  newPasswordField.addEventListener('input', verifyNewPasswordsMatch);
  confirmNewPasswordField.addEventListener('input', verifyNewPasswordsMatch);

  

  function sendDataToServerContrasena(data) {

    $.ajax({
        url: "actualizarContrasena",  // Asegúrate de que la URL sea correcta
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            alert('Datos actualizados correctamente');
            // Aquí puedes mostrar un mensaje de éxito, actualizar la vista, etc.
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar los datos:', error);
            // Aquí puedes mostrar un mensaje de error
        }
    });
} 

  savePasswordChanges.addEventListener('click', function(event) {
    verifyNewPasswordsMatch();

    if (confirmNewPasswordField.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      alert('Las contraseñas no coinciden');
    } else {
      // Aquí es donde colocarías tu lógica para cambiar la contraseña

      const data = {
        contrasena: newPasswordField.value
      };  
      sendDataToServerContrasena(data);

      // Cerrar el modal después de guardar los cambios
      const changePasswordModal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
      changePasswordModal.hide();
    }
  });
</script>
