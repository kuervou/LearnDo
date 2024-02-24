<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>
    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="form-container">
                <div class="form text-center">
                    <div class="login-logo">
                        <img src="<?= base_url('public/assets/images/LogoT.png') ?>" alt="Logo StyleFlow">
                    </div>
                    <h1 class="h3 mb-3 fw-normal">Registro de usuario</h1>
                    <form method="POST" action="<?= base_url('/registro') ?>" class="needs-validation" novalidate="" autocomplete="off">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstName" placeholder="Nombre" maxlength="32" required name="nombre">
                                    <label for="firstName">Nombre</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="lastName" placeholder="Apellido" maxlength="32" required name="apellido">
                                    <label for="lastName">Apellido</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="nick" placeholder="Nick" maxlength="32" required name="nick">
                                    <label for="firstName">Nick</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="tel" placeholder="Teléfono" maxlength="16" required name="tel">
                                    <label for="tel">Telefono</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" placeholder="password" maxlength="32" name="pass">
                                    <label for="password">Contraseña</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password2" placeholder="password" maxlength="32" required name="pass2">
                                    <label for="password2">Confirmar Contraseña</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="mail@example.com" maxlength="64" required name="email">
                                    <label for="email">Correo Electrónico</label>
                                </div>
                            </div>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Registrarse</button>
                        <!-- REGISTRATE CON LINKEDIN -->
                        <div class="container text-center mt-5">
                            <a href="<?php echo base_url('/auth/linkedin'); ?>" class="btn btn-primary">Ingresá con LinkedIn</a>
                        </div>
                        <p class="mt-3 mb-3 text-muted">&copy; LearnDo </p>
                    </form>
                </div>
            </div>


<!-- Incluimos el footer -->
<?= view('template/footer') ?> 

