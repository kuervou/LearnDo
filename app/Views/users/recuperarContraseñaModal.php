<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="loginModalLabel">Recuperar Contraseña</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="login-logo text-center">
          <img src="<?= base_url('public/assets/images/LogoT.png') ?>" alt="Logo StyleFlow">
        </div>
            <form method="POST" action="<?= base_url('/forgotPassword')?>">
                <input type="text" class="form-control" id="floatingInput" placeholder="Email" name="email" required>
                
                <div class="container text-center">
                    <button class="btn btn-primary mt-2" type="submit">Recuperar</button>
                </div>
            </form>
      </div>
      <div class="modal-footer justify-content-center">
        <div class="container text-center"> 
          <div class="d-grid gap-2">
          
        
          <p class="mt-3 mb-3 text-white">¿No tenés cuenta?</p> <a class="btn btn-primary w-70" href="<?= base_url('/register') ?>">Registrate</a>
        </div>
        </div>
        <p class="mt-3 mb-3 text-white">&copy; LearnDo </p>
      </div>
    </div>
  </div>
</div>