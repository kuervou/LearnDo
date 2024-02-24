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
                        <h1 class="card-title">ERROR</h1>
                        <p class="card-text">Ha ocurrido un error al verificar tu correo.</p>
                        <!--Recorrer el array $errores y mostrarlos en un <p> -->
                        <?php if (isset($errores)) : ?>
                            <?php foreach ($errores as $error) : ?>
                                <p class="card-text"><?= $error ?></p>
                            <?php endforeach ?>
                        <?php endif ?>
                        <a href="<?php echo base_url('/'); ?>" class="btn btn-primary">Ir al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?> 
