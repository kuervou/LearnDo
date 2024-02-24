<!-- Incluimos el head -->
<?= view('template/head') ?>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4CBnz1IbIRqZQ-NULt4Ygcyh-R9D0Qu8&callback=initMap"></script>


<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
     <!-- Cuerpo de la página -->
     <div class="container">
        <h2 class="text-center mb-4 text-white">Alta Seminario</h2>
        <form method="POST" action="<?= base_url('/registrarSeminario') ?> ?>" class="needs-validation" novalidate="" autocomplete="off">
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
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de seminario</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="">Seleccione el tipo</option>
                    <option value="virtual">Virtual</option>
                    <option value="presencial">Presencial</option>
                </select>
            </div>
            <div class="mb-3" id="virtual-info" style="display: none;">
                <label for="plataforma" class="form-label">Link al seminario</label>
                <input type="text" class="form-control" id="plataforma" name="plataforma" maxlength="32">
            </div>

            <div class="mb-3" id="presencial-info" style="display: none;">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="hidden" class="form-control" id="ubicacion-coords" name="ubicacion_coords">
                <div id="map" style="height: 400px; width: 100%; display:none;"></div>
 

                <label for="capacidad" class="form-label">Capacidad</label>
                <input type="number" class="form-control" id="capacidad" name="capacidad">
            </div>
            <div class="mb-3">
                <label for="categorias" class="form-label">Categorías</label>
                <select class="form-select" id="categorias" name="categorias[]" multiple required>
                    <!-- Opciones de categorías a cargar desde la base de datos -->
                    <?php foreach ($categorias as $categoria) : ?>  
                    <option value="<?= $categoria['nombre']?>"><?= $categoria['nombre']?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Seminario</button>
        </form>
    </div>    



<script>

</script>
<script src="<?php echo base_url('public/js/altaSeminario/custom.js'); ?>"></script>
<!-- Incluimos el footer -->
<?= view('template/footer') ?> 