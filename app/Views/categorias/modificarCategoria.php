<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <h2 class="text-center mb-4 text-white">modificar Categoría</h2>
        <form id="alta-curso-form" method="POST" action="<?= base_url('/modificarCategoria') ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="32" required>

                <input type="hidden" class="form-control" id="catNombre" name="nombreCat" value="<?= $cat ?>" required> 
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>