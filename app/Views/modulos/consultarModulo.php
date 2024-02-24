<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Detalle del módulo -->
        <h2 class="my-4 text-white"><?php echo $datosModulo[0]['nombre']; ?> </h2>
        <?php if (session()->get('usuario') == $datosModulo[0]['nick_organizador']) { ?>
            <!-- Botón para agregar una nueva lección -->
            <div class="d-flex justify-content-center my-4">
                <a href="<?= base_url('altaLeccion/?id_modulo=' . $datosModulo[0]['id_modulo']) ?>" class="btn btn-primary">Agregar lección</a>
            </div>
            <div class="d-flex justify-content-center my-4">
                <a href="<?= base_url('altaEvaluacion/?id_modulo=' . $datosModulo[0]['id_modulo']) ?>" class="btn btn-primary">Agregar Evaluación</a>
            </div>
        <?php } ?>

        <!-- Lista de lecciones -->
        <h3 class="my-4 text-white">Lecciones</h3>
        <div class="row">
            <?php foreach ($lecciones as $leccion) : ?>
                <!-- Tarjeta de lección individual -->
                <div class="col-md-12 text-white ">
                    <div class="card card-material">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $leccion['nombre']; ?></h5>
                            <p class="card-text"><?php echo $leccion['duracion']; ?> minutos</p>
                            <a href="<?= base_url('consultarLeccion?id_Leccion=' . $leccion['id_leccion']) ?>" class="btn btn-primary">Ver contenido</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Fin tarjeta de lección individual -->

            <!-- Aquí se agregarán más tarjetas de lecciones individuales con un botón para acceder al contenido multimedia de cada lección -->
        </div>
        <h3 class="my-4 text-white">Evaluacion del módulo</h3>
        <div class="row">
            <?php if (isset($evaluaciones)) {
                foreach ($evaluaciones as $evaluacion) : ?>
                    <!-- Tarjeta de lección individual -->
                    <div class="col-md-12 text-white ">
                        <div class="card card-material">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $evaluacion['titulo'];?> </h5>
                                <?php
                                 if(isset($prueba) && $prueba['aprobado']){
                                    echo '
                                    <div class="d-flex justify-content-start my-4">
                                    <span class="material-symbols-outlined ml-1">
                                    done
                                </span>Aprobado
                                </div>
                                    ';
                                }
                                ?>
                                <?php if (session('tipoUser') == 'organizador') { ?>
                                    <a href="<?= base_url('editarEvaluacion/?id_evaluacion=' . $evaluacion['id_evaluacion']) ?>" class="btn btn-primary">Ver contenido</a>
                                <?php } else { ?>
                                    <div class="d-flex justify-content-start my-4">
                                    <?php if (!isset($prueba) || (isset($prueba) && !$prueba['aprobado'])) { ?>
                                        <a href="<?= base_url('editarEvaluacion/?id_evaluacion=' . $evaluacion['id_evaluacion']) ?>" class="btn btn-primary mx-2">Realizar Evaluacion</a>
                                        <?php } ?>
                                        <?php if (isset($prueba)) { ?>
                                            <a href="<?= base_url('consultarIntento/?id_prueba=' . $prueba['id_prueba']) ?>" class="btn btn-primary mx-2">Ver Último Intento</a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
            <?php endforeach;
            } ?>

            <!-- Fin tarjeta de lección individual -->

            <!-- Aquí se agregarán más tarjetas de lecciones individuales con un botón para acceder al contenido multimedia de cada lección -->
        </div>


    </div>

    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>