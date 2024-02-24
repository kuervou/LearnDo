<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Lista de foros -->
        <h2 class="my-4">Discusiones</h2>
        <div class="row">
            <?php foreach($discusiones as $discusion): 
                $urlImage = base_url('public/assets/images/template/discusion.svg');?>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $discusion['nombre'];?></h5>
                        <p class="card-text"><?php echo $discusion['descripcion'];?></p>
                        <a href=" <?= base_url('consultarDiscusion/?id_discusion='.$discusion['id_discusion'])  ?>" class="btn btn-primary">Ver detalles</a>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <a href="<?= base_url('altaDiscusion/?id_foro='.$id_foro) ?>" class="btn btn-primary">Crear Discusion</a>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?> 