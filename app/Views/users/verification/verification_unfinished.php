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
                        <h1 class="card-title">¡UPS!</h1>
                        <h3 class="card-text">Parece que no has verificado tu cuenta.</h3>
                        <p class="card-text">Ve a tu correo y busca el enlace de activación</p>
                        <a href="<?php echo base_url('/logout'); ?>" class="btn btn-primary">Inicio</a>
                        <a href="<?php echo base_url('/'); ?>" class="btn btn-primary">Ayuda</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?> 
