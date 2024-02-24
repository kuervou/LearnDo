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
                        <h1 class="card-title">¡Invitación a colaborar!</h1>
                        <p class="card-text">Has sido invitado a colaborar en este curso.</p>
                        <p class="card-text">¡Has click para aceptar o rechazar la invitación!</p>
                        <a href="<?php echo base_url('/login'); ?>" class="btn btn-primary">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>