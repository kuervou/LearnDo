<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Lista de cursos -->
        <h2 class="my-4 text-white">Mis Seminarios</h2>
        <?php if(session("tipoUser") == "organizador"){ ?>
            <div class="col-12">
                <a href="<?= base_url('altaSeminario') ?>" class="btn btn-primary">Crear un Seminario</a>
            </div>
            <?php } ?>
        <div class="row">
            <!-- Tarjeta de curso individual -->
            <!-- listamos los cursos -->
            <?php foreach($seminariosV as $seminarioV): 
                $urlImage = base_url('public/assets/images/template/virtual.svg');?>
                <div class="col-md-4">
                    <div class="card course-card">
                        <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $seminarioV['nombre'];?></h5>
                            <p class="card-text"><?php echo $seminarioV['descripcion'];?></p>
                            <a href=" <?= base_url('consultarSeminario/?id_seminario='.$seminarioV['id_seminario_virtual'].'&tipo=virtual')  ?>" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php foreach($seminariosP as $seminarioP): 
                $urlImage = base_url('public/assets/images/template/presencial.svg');?>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $seminarioP['nombre'];?></h5>
                        <p class="card-text"><?php echo $seminarioP['descripcion'];?></p>
                        <a href=" <?= base_url('consultarSeminario/?id_seminario='.$seminarioP['id_seminario_presencial'].'&tipo=presencial')  ?>" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- Fin tarjeta de seminario individual -->

            
            </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?> 