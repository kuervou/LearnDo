<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <h2 class="text-center mb-4 text-white">Alta Categoría</h2>
        <form id="alta-curso-form" method="POST" action="<?= base_url('/altaCategoria') ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" maxlength="32" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        </form>
    </div>

    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>