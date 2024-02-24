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
            <!-- Botón que dispara el modal -->
            <button type="button" class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#nuevoOrganizadorModal">
                Agregar Organizador
            </button>
        </div>

        <div class="row">
            <?php $urlImage = base_url('public/assets/images/template/organizador.svg');
            foreach ($organizadores as $organizador) : ?>

                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <div class="position-relative">
                                    <img src="<?php echo $urlImage; ?>" class="img-fluid" alt="Organizador">
                                    <img src="<?php echo base_url($organizador['ruta_multimedia']) ?>" class="position-absolute top-50 start-50 translate-middle rounded-circle" style="max-width:100px; max-height:100px;" alt="Imagen de perfil">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $organizador['nombre']; ?></h5>
                                    <a href=" <?= base_url('eliminarOrganizador?nick=' . $organizador['nick'])  ?>" class="btn btn-primary">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach;  ?>

        </div>
    </div>

    <!-- Modal Nuevo Organizador -->
    <div class="modal fade" id="nuevoOrganizadorModal" tabindex="-1" aria-labelledby="nuevoOrganizadorModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoOrganizadorModalLabel">Nuevo Organizador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?= base_url('/altaOrganizador') ?> ">
                        <div class="mb-3">
                            <label for="nick" class="form-label">Nick</label>
                            <input type="text" class="form-control" id="nick" name="nick" maxlength="32" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" maxlength="16" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="32" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" maxlength="32" required>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>
