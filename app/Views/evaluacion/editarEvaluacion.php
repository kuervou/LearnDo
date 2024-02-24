<!-- Incluimos el head -->
<?= view('template/head') ?>

<!--  Incluimos el modal modalPreguntas-->
<?php include('modalPreguntas.php') ?>

<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

   <!-- Cuerpo de la página -->
   <div class="container mt-5">
        <h1 class="text-white">Editar Evaluación</h1>
        <div class="card card-material">
            <div class="card-body">
                <form>
                    <input type="hidden" id="tituloEvaluacion" value="<?= $datosEvaluacion['titulo']?>">
                    <input type="hidden" id="notaAprobacion" value="<?= $datosEvaluacion['nota_aprobacion']?>">
                    
                    <h3 class="card-title"><?= $datosEvaluacion['titulo'] ?></h3>
                    <p class="card-text">Nota de Aprobación: <?= $datosEvaluacion['nota_aprobacion'] ?></p>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearPregunta">Añadir Preguntas</button>

                    <div class="mt-3">
                        <h5 class="modal-title">Lista de Preguntas</h5>
                        <?php if(isset($preguntas)){ foreach ($preguntas as $pregunta): ?>
                        <div class="card card-material my-2">
                            <div class="card-body">
                                <h5 class="card-title"><?= $pregunta['contenido']; ?></h5>
                                <?php foreach ($opciones[$pregunta['id_pregunta']] as $opcion): ?>
                                    <p class="card-text"><?= $opcion['contenido']; ?></p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>
