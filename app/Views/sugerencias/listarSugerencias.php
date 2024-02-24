<!-- Incluimos el head -->
<?= view('template/head') ?>

<script>
    //Script para que funcione el tooltip
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip()
    })
</script>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Lista de cursos -->
        <h2 class="my-4 text-white">Sugerencias</h2>
        <div class="row">
            <!-- Tarjeta de curso individual -->
            <!-- listamos los cursos -->
            <?php foreach ($sugerencias as $sugerencia) :
                $urlImage = base_url('public/assets/images/template/miCurso.svg'); ?>
                <div class="col-md-4">
                    <div class="card course-card">
                        <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $sugerencia['nick_estudiante']; ?></h5>
                            <p class="card-text"><?php echo $sugerencia['fecha']; ?></p>
                            <a href="<?= base_url('consultarSugerencia?id_sugerencia=' . $sugerencia['id_sugerencia'])  ?>" class="btn btn-primary">Consultar Sugerencia</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>