<!-- Incluimos el head -->
<?= view('template/head') ?>

<?php include('recuperarContraseñaModal.php') ?>

<body>
    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>
    <!-- Cuerpo de la página -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card bg-dark text-light">
                    <div class="card-header">
                        <h5 class="card-title">Cambiar contraseña</h5>
                    </div>
                    <form method="POST" action="<?= base_url('/restablecerContrasena')?>">
                    <input type="hidden" class="form-control" name="tipo" value="<?= $tipo ?>" required>
                    <input type="hidden" class="form-control" name="user" value="<?= $user ?>" required>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="new-password" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="new-password" name="newPassword" maxlength="32" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-new-password" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" id="confirm-new-password" maxlength="32" name="confirmNewPassword" required>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-secondary" onclick="cancelPasswordChange()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="submit()">Guardar cambios</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>