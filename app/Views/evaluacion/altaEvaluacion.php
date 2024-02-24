<!-- Incluimos el head -->
<?= view('template/head') ?>

<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

   <!-- Cuerpo de la página -->
   <div class="container mt-5">
        <h1 class="text-white">Crear Evaluación</h1>
        <form id="alta-evaluacion-form" method="POST" action="<?= base_url('/agregarEvaluacion') ?>">
            <div class="mb-3">
                <label for="tituloEvaluacion" class="form-label">Título de la Evaluación</label>
                <input type="hidden" class="form-control" id="course_id" name="id_modulo" value="<?= $id_modulo ?>" required> 
                <input type="text" class="form-control" id="tituloEvaluacion" name="titulo" maxlength="32" required>
            </div>
            <div class="mb-3">
                <label for="notaAprobacion" class="form-label">Porcentaje de Aprobación</label>
                <input type="number" class="form-control" id="notaAprobacion" name="notaAprobacion" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar evaluación</button>
        </form>
    </div>

   

<!-- Incluimos el footer -->
<?= view('template/footer') ?>