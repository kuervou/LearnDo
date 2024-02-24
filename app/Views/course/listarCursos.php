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
    <?php if (isset($offline)) {
        if ($offline) { ?>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container container-header-offline ">
                    <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Puedes ver todas las lecciones que hayas descargado">
                        <span class="material-symbols-outlined">
                            warning
                        </span>
                        Modo sin conexión
                        <span class="material-symbols-outlined">
                            wifi_off
                        </span>
                    </button>
                </div>
            </nav>
            <script>
                alert("ESTAS OFFLINE! Pero aún así puedes ver el contenido que has descargado");
            </script>
    <?php }
    }; ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Lista de cursos -->
        <h2 class="my-4 text-white">Mis cursos</h2>
        <?php if(session("tipoUser") == "organizador"){ ?>
            <!-- Seccion con un boton para crear un curso, que nos lleve a la vista de alta Curso -->
            <div class="col-12">
                <a href="<?= base_url('altaCurso') ?>" class="btn btn-primary">Crear un curso</a>
            </div>
        <?php } ?>
        <div class="row">
            <!-- Tarjeta de curso individual -->
            <!-- listamos los cursos -->
            <?php foreach ($cursos as $curso) :
                $urlImage = base_url('public/assets/images/template/miCurso.svg'); ?>
                <div class="col-md-4">
                    <div class="card course-card">
                        <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                        <?php if (isset($offline)) {
                            if (!$offline) { ?>
                                <?php if (isset($porcentajes)) { ?>

                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:<?php echo $porcentajes[$curso['id_curso']]; ?>%;" aria-valuenow="<?php echo $porcentajes[$curso['id_curso']]; ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo $porcentajes[$curso['id_curso']]; ?>
                                            %
                                        </div>
                                    </div>
                                <?php } ?>
                        <?php }
                        }; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $curso['nombre']; ?></h5>
                            <p class="card-text"><?php echo $curso['descripcion']; ?></p>
                            <?php if (isset($porcentajes) && (isset($offline)) && !$offline) { ?>
                                <a href="<?= base_url('consultarCurso?id_curso=' . $curso['id_curso'] . '&porcentaje=' . $porcentajes[$curso['id_curso']]) ?>" class="btn btn-primary">Ver detalles</a>
                            <?php } else { ?>
                                <a href=" <?= base_url('consultarCurso?id_curso=' . $curso['id_curso'])  ?>" class="btn btn-primary">Ver detalles</a>
                            <?php } ?>
                            <?php if (isset($offline)) {
                                if (!$offline) { ?>
                                    <!-- Botón para descargar el curso para ver más tarde 
                                    <a href="<?// base_url('descargarCurso?id_curso=' . $curso['id_curso'])  ?>" class="btn btn-primary">
                                        <span class="material-symbols-outlined">
                                            download
                                        </span>
                                    </a>-->
                            <?php }
                            }; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>