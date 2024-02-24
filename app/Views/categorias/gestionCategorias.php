<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <div class="col-12">
            <a href=" <?= base_url('/altaCategoria')  ?>" class="btn btn-primary">Agregar Categoría</a>
        </div>

        <div class="row">
            <?php $urlImage = base_url('public/assets/images/template/categorias.svg');
            foreach ($categorias as $categoria) : ?>

                <div class="col-md-4">
                    <div class="card course-card">
                        <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $categoria['nombre']; ?></h5>
                            <a href=" <?= base_url('modificarCategoria?cat=' . $categoria['nombre'])  ?>" class="btn btn-primary">Editar</a>
                            <a href=" <?= base_url('eliminarCategoria?cat=' . $categoria['nombre'])  ?>" class="btn btn-primary">Eliminar</a>
                        </div>
                    </div>
                </div>

            <?php endforeach;  ?>

        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>