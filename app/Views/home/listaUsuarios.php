<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <!-- Titulo de chats -->
                <h2 class="mb-4 text-white">Chats</h2>
                <!-- Lista de chats -->
                <div class="container">
                    <div class="row">
                        <?php foreach ($estudiantes as $estudiante) :
                            if ($estudiante['nick'] != session('usuario')) { ?>
                                <div class="col-lg-12 col-md-6 mb-4">
                                    <div class="card card-material bg-transparent custom-jumbotron text-white my-4 justify-content-center">
                                        <a href="<?= base_url('cargarChats?receptor=' . $estudiante['nick']) ?>" target="chatframe" class="d-flex align-items-center card-body">
                                            <img src="<?php echo base_url($estudiante['ruta_multimedia']) ?>" alt="<?= $estudiante['nick'] ?>" width="50" height="50" class="rounded-circle me-3">
                                            <div>
                                                <h5 class="card-title mb-0"><?= $estudiante['nick'] ?></h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        <?php } ?>
                        <?php endforeach; ?>
                        <?php foreach ($organizadores as $organizador) :
                            if ($organizador['nick'] != session('usuario')) { ?>
                                <div class="col-lg-12 col-md-6 mb-4">
                                    <div class="card card-material bg-transparent custom-jumbotron text-white my-4 justify-content-center">
                                        <a href="<?= base_url('cargarChats?receptor=' . $organizador['nick']) ?>" target="chatframe" class="d-flex align-items-center card-body">
                                            <img src="<?php echo base_url($organizador['ruta_multimedia']) ?>" alt="<?= $organizador['nick'] ?>" width="50" height="50" class="rounded-circle me-3">
                                            <div>
                                                <h5 class="card-title mb-0"><?= $organizador['nick'] ?></h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        <?php } ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <!-- Aquí es donde se cargará el contenido del chat seleccionado -->
                <iframe  name="chatframe" style="width:100%; height:480px;"></iframe>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?> 

</body>
