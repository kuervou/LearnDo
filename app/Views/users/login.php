<!-- Incluimos el head -->
<?= view('template/head') ?>

<?php include('recuperarContraseñaModal.php') ?>
<body>
    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>
        <!-- Mostrar el formulario de login -->
        <!-- Cuerpo de la página -->
        <div class="form-container">
            <div class="form text-center">
                <div class="login-logo">
                    <img src="<?= base_url('public/assets/images/LogoT.png') ?>" alt="Logo StyleFlow">
                </div>
                <h1 class="h3 mb-3 fw-normal">Iniciar sesión</h1>
                <form method="POST" action="<?= base_url('/login') ?>" class="needs-validation" novalidate="" autocomplete="off">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Nick" name="nick">
                        <label for="floatingInput">nick</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña" name="pass">
                        <label for="floatingPassword">Contraseña</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Ingresar</button>

                    <p class="mt-3 mb-3 text-muted" data-bs-toggle="modal" data-bs-target="#loginModal"> <a>¿Olvidaste tu contraseña?</a></p>

                    <!-- INICIAR SESIÓN CON LINKEDIN -->
                    <div class="container text-center mt-5">
                        <a href="<?php echo base_url('/auth/linkedin'); ?>" class="btn btn-primary">Ingresá con LinkedIn</a>
                    </div>

                    <!-- Opción para registrarse -->
                    <p class="mt-3 mb-3 text-muted">¿No tenés cuenta? <a href="<?= base_url('/register') ?>">Registrate</a></p>

                    <p class="mt-3 mb-3 text-muted">&copy; LearnDo </p>
                </form>
            </div>
        </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?> 
