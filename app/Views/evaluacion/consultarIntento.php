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
    <h1 class="text-white">Último Intento</h1>
    <div class="card card-material">
        <div class="card-body">
            <h3 class="card-title"><?= $evaluacion['titulo'] ?></h3>
            <p class="card-text">Porcentaje de Aprobación: <?= $evaluacion['nota_aprobacion'] ?></p>
            <!-- Añadir aquí un campo para la nota total del usuario. Asegúrate de tener una variable $nota_total o similar que guarde esta información. -->
            <?php if(isset($nota_maxima)){ ?>
                <p class="card-text">Nota Máxima: <?= $nota_maxima ?></p>
            <?php } ?>
            <?php if(isset($nota_total)){ ?>
                <p class="card-text">Tu Nota Total: <?= $nota_total ?></p>
            <?php } ?>


            <!-- Añadir aquí una comparación de las notas -->
            <?php if ( isset($aprobado) && ($aprobado)): ?>
                <p class="card-text text-success">¡Felicidades! Has aprobado.</p>
            <?php else: ?>
                <p class="card-text text-danger">Lamentablemente, no has aprobado.</p>
            <?php endif; ?>

            <h5 class="modal-title">Lista de Preguntas</h5>
            <?php foreach ($preguntas as $pregunta): ?>
                <div class="card card-material my-2">
                    <div class="card-body">
                        <h5 class="card-title"><?= $pregunta['contenido'] ?></h5>
                        <?php foreach ($respuestas as $respuesta): ?>
                            <?php if ($respuesta['id_pregunta'] == $pregunta['id_pregunta']): ?>
                                <div class="card-text">
                                    <p>Respondiste: <?= $respuesta['contenido'] ?></p>
                                    <p>Nota Obtenida: <?= $respuesta['nota_obtenida'] ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


                <!-- Incluimos el footer -->
                <?= view('template/footer') ?>