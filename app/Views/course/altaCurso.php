<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <h2 class="text-center mb-4 text-white">Alta Curso</h2>
        <form id="alta-curso-form" method="POST" action="<?= base_url('/altaCurso') ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="32" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
            </div>
            <div class="mb-3">
                <label for="creditos" class="form-label">Créditos</label>
                <input type="number" class="form-control" id="creditos" name="creditos" required>
            </div>
            <div class="mb-3">
                <label for="instructores" class="form-label">Instructores</label>
                <div id="instructores-list">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="instructores[]" placeholder="Nombre del instructor">
                        <button type="button" class="btn btn-outline-danger" onclick="removeInstructor(this)">Eliminar</button>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary" id="add-instructor">Agregar Instructor</button>
            </div>
            <div class="mb-3">
                <label for="categorias" class="form-label">Categorías</label>
                <select class="form-select" id="categorias" name="categorias[]" multiple required>
                    <!-- Opciones de categorías a cargar desde la base de datos -->

                    <?php //Obtenemos las categorias del $data que viene del controlador

                    foreach ($categorias as $categoria) : ?>
                        <option value="<?= $categoria['nombre'] ?>"><?php echo $categoria['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="categorias" class="form-label">Colaboradores</label>
                <input type="text" id="search-input" class="form-control" placeholder="Buscar usuario">
                <select class="form-select" id="colaboradores" name="colaboradores[]" multiple>
                    <!-- Opciones de categorías a cargar desde la base de datos -->
                    <?php foreach ($estudiantes as $estudiante) { ?>
                        <option value="<?php echo $estudiante['nick'] ?>"><?php echo $estudiante['nick'] ?></option>
                    <?php } ?>
                    <!-- Agrega más opciones aquí -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Curso</button>
        </form>
    </div>

    <script src="<?php echo base_url('public/js/altaCurso/custom.js'); ?>"></script>

    <script>

        $(document).ready(function() {
            $('#search-input').on('input', function() {
                var searchValue = $(this).val().toLowerCase();
                $('#colaboradores option').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
                });
            });
        });
    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>