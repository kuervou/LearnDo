<div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white">
        <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Formulario de Pago</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <form action="<?= base_url('payment/processPayment') ?>" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <!-- Agrega aquí los demás campos del formulario -->

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Pagar</button>
            </div>
            </form>
        </div>
    </div>
  </div>
</div>