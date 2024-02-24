<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>
    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>
       <!-- Contenido principal -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">¡Éxito!</h1>
                        <p class="card-text">Tu cuenta ha sido verificada exitosamente.</p>
                        <p class="card-text">¡Ya puedes iniciar sesión y comenzar a aprender!</p>
                        <a href="<?php echo base_url('/login'); ?>" class="btn btn-primary">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>