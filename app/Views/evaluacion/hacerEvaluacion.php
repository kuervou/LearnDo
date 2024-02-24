<!-- Incluimos el head -->
<?= view('template/head') ?>



<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

   <!-- Cuerpo de la página -->
   <div class="container mt-5 ">
   <h1 class="text-white">Realizar Evaluación</h1>
    <div class="card card-material">
        <div class="card-body">
            <form method="POST" action="<?= base_url('/realizarEvaluacion') ?>">
                <input type="hidden" class="form-control" id="id_evaluacion" name="id_evaluacion" value="<?= $datosEvaluacion['id_evaluacion']  ?>" required>
                <!-- Añadiendo título y nota de aprobación como entradas ocultas -->
                <input type="hidden" id="tituloEvaluacion" name="tituloEvaluacion" value="<?= $datosEvaluacion['titulo'] ?>">
                <input type="hidden" id="notaAprobacion" name="notaAprobacion" value="<?= $datosEvaluacion['nota_aprobacion'] ?>">

                <h3 class="card-title"><?= $datosEvaluacion['titulo'] ?></h3>
                <p class="card-text">Nota de Aprobación: <?= $datosEvaluacion['nota_aprobacion'] ?></p>

                <h5 class="modal-title">Lista de Preguntas</h5>
                <?php foreach ($preguntas as $pregunta): ?>
                    <div class="card card-material my-2">
                        <div class="card-body">
                            <h5 class="card-title"><?= $pregunta['contenido'] ?></h5>
                            <?php foreach ($opciones[$pregunta['id_pregunta']] as $opcion): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="respuestas[<?= $pregunta['id_pregunta'] ?>][]" value="<?= $opcion['contenido'] ?>">
                                    <label class="form-check-label" for="check<?= $opcion['contenido'] ?>">
                                        <?= $opcion['contenido'] ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary mt-3">Terminar evaluacion</button>
            </form>
        </div>
    </div>
</div>



    <script>
    // Obtener todos los elementos de tipo checkbox dentro del formulario
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');

    // Agregar un event listener a cada checkbox
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
        // Obtener todos los checkboxes dentro del mismo grupo (misma pregunta)
        const checkboxesGrupo = document.querySelectorAll(`input[type="checkbox"][name="${this.name}"]`);

        // Desmarcar los otros checkboxes dentro del grupo
        checkboxesGrupo.forEach(cb => {
            if (cb !== this) {
            cb.checked = false;
            }
        });
        });
    });
    </script>


<!-- Incluimos el footer -->
<?= view('template/footer') ?>