<!-- Incluimos el head -->
<?= view('template/head') ?>

<script>
    //Script para que funcione el tooltip
    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip()
    })
</script>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <div class="container">
            <!-- ... -->

            <!-- Detalle de la lección -->

            <h2 class="my-4 text-white"><?php echo $datosLeccion[0]['nombre']; ?></h2>
            <p class="lead text-white">Duracion:<?php echo $datosLeccion[0]['duracion']; ?> minutos</p>

            <?php if ($datosLeccion['isDownload']) { ?>
                <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="La lección ya ha sido descargada.">
                    <span class="material-symbols-outlined">
                        done
                    </span>
                </button>
            <?php } else { ?>
                <a href="<?= base_url('descargarLeccion/?id_leccion=' . $datosLeccion[0]['id_leccion']) ?>" class="btn btn-primary" id="offlineButton" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="custom-tooltip" data-bs-title="Hacé click para descargar la lección.">
                    <span class="material-symbols-outlined">
                        download
                    </span>
                </a>
            <?php }
            ?>

            <!-- Contenido multimedia -->
            <h3 class="my-4 text-white">Contenido multimedia</h3>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $extension = pathinfo($datosLeccion[0]['ruta_multimedia'], PATHINFO_EXTENSION);
                    $src = base_url('/public/uploads/contenidoMultimedia/lecciones/') . $datosLeccion[0]['ruta_multimedia'];
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':
                            echo "<img src='$src' alt='Media' style='max-width:100%; height:auto;'>";
                            break;
                        case 'mp4':
                        case 'webm':
                            echo "<video controls style='max-width:100%; height:auto;'><source src='$src' type='video/$extension'></video>";
                            break;
                        case 'pdf':
                            echo "<iframe src='$src' width='100%' height='500px'></iframe>";
                            break;
                        default:
                            echo "Formato de archivo no soportado. <br>";
                            echo "<a href='$src' download><button>Descargar archivo</button></a>";
                            break;
                    }
                    ?>
                </div>
            </div>

            <!-- Navegación entre lecciones -->
            <div class="d-flex justify-content-between my-4">
                <a href="<?= base_url('leccionAnterior/?id_Leccion=' . $datosLeccion[0]['id_leccion'] . '&id_modulo=' . $datosLeccion[0]['id_modulo']) ?>" class="btn btn-secondary">Lección anterior</a>
                <a href="<?= base_url('leccionSiguiente/?id_Leccion=' . $datosLeccion[0]['id_leccion'] . '&id_modulo=' . $datosLeccion[0]['id_modulo']) ?>" class="btn btn-primary">Lección siguiente</a>
            </div>
        </div>
        <script src="<?php echo base_url('public/js/cargarCache/custom.js'); ?>"></script>
        <!-- Incluimos el footer -->
        <?= view('template/footer') ?>