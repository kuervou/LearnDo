<!-- Incluimos el head -->
<?= view('template/head') ?>


<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>



    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Banner promocional -->
        <div class="jumbotron text-center bg-transparent custom-jumbotron text-white py-5">
            <h1 class="display-4">Dashboard SuperAdmin</h1>
            <p class="lead">LearnDo Connecting Minds</p>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="my-4 text-white">Tareas</h2>
            </div>
           

            <?php $urlWorldMap = base_url('public/assets/images/template/worldMap.svg'); ?>
            <div class="col-md-6">
                <div class="card card-material mb-3">
                    <img src="<?php echo $urlWorldMap; ?>" class="card-img-top course-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Enviar recordatorios</h5>
                        <p class="card-text">Enviar recordatorios para los seminarios que ocurrirán mañana</p>
                        <a href="<?= base_url('enviarRecordatorios')  ?>" class="btn btn-primary">Disparar recordatorios</a>
                    </div>
                </div>
            </div>

            <?php $urlCategorias = base_url('public/assets/images/template/categorias.svg'); ?>
            <div class="col-md-6">
                <div class="card card-material mb-3">
                    <img src="<?php echo $urlCategorias; ?>" class="card-img-top course-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Administrar Categorías</h5>
                        <p class="card-text">Alta, baja y modificación</p>
                        <a href="<?= base_url('/gestionCategorias')  ?>" class="btn btn-primary">Ir al menú</a>
                    </div>
                </div>
            </div>

            <?php $urlOrg = base_url('public/assets/images/template/org.svg'); ?>
            <div class="col-md-6">
                <div class="card card-material mb-3">
                    <img src="<?php echo $urlOrg; ?>" class="card-img-top course-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title">Administrar Organizadores</h5>
                        
                        <a href="<?= base_url('/gestionOrganizador')  ?>" class="btn btn-primary">Ir al menú</a>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Incluimos el footer -->
        <?= view('template/footer') ?>