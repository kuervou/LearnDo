<!-- Incluimos el head -->
<?= view('template/head') ?>

<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

   <!-- Cuerpo de la página -->
   <div class="container">
       <!-- Agregar una nueva lección -->
       <h2 class="my-4 text-white">Confirmar o Rechazar Sugerencia</h2>
       <div class="lesson-form-container">
       <form method="POST" action="<?= base_url('/aceptarSugerencia') ?> "  enctype="multipart/form-data">
               <div class="mb-3 text-white">
                   <label for="lesson_name" class="form-label">Nombre de la lección</label>
                   <input type="text" class="form-control" id="lesson_name" name = "nombre" required>
                   <input type="hidden" class="form-control" id="id_sugerencia" name="id_sugerencia" value="<?= $sugerencia[0]['id_sugerencia'] ?>" required> 
               </div>
               <div class="mb-3 text-white">
                   <label for="lesson_duration" class="form-label">Duración (minutos)</label>
                   <input type="number" class="form-control" id="lesson_duration" name = "duracion" required>
               </div>
               <div class="mb-3 text-white">
                   <label for="lesson_media" class="form-label">Contenido multimedia</label>
                   <div class="row">
                    <div class="col-md-12">
                        <?php 
                            $extension = pathinfo($sugerencia[0]['ruta_multimedia'], PATHINFO_EXTENSION);
                            $src = base_url('/public/uploads/contenidoMultimedia/lecciones/').$sugerencia[0]['ruta_multimedia'];
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
               </div>

               <div class="mb-3 text-white">
                    <label for="lesson_duration" class="form-label">Módulos (Seleccion el módulo en el que irá la lección)</label>
                    <div class="mb-3">
                    <select class="form-select" id="modulos" name="modulos[]" multiple required>
                        <!-- Opciones de módulos a cargar desde la base de datos -->

                        <?php // Obtenemos los módulos del $data que viene del controlador

                        foreach ($modulos as $modulo) : ?>
                            <option value="<?= $modulo['id_modulo'] ?>"><?php echo $modulo['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
               <button type="submit" class="btn btn-primary">Aceptar Sugerencia</button>
               </form>

                <form method="POST" action="<?= base_url('/rechazarSugerencia') ?> ">
                    <input type="hidden" class="form-control" id="id_sugerencia" name="id_sugerencia" value="<?= $sugerencia[0]['id_sugerencia'] ?>" required> 
                    <button onclick="" class="btn btn-primary">Rechazar Sugerencia</button>
                </form>
       </div>
   </div>

   <script>
    // JavaScript code to allow only one option to be selected
    const selectElement = document.getElementById('modulos');

    selectElement.addEventListener('change', function() {
        const selectedOptions = Array.from(selectElement.selectedOptions);

        if (selectedOptions.length > 1) {
            selectedOptions.shift().selected = false;
        }
    });

    
</script>   

<!-- Incluimos el footer -->
<?= view('template/footer') ?>