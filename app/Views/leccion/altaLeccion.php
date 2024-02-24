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
       <h2 class="my-4 text-white">Agregar una nueva lección</h2>
       <div class="lesson-form-container">
       <form id="lesson_form" method="POST" action="<?= base_url('/agregarLeccion') ?> "  enctype="multipart/form-data">
               <div class="mb-3 text-white">
                   <label for="lesson_name" class="form-label">Nombre de la lección</label>
                   <input type="text" class="form-control" id="lesson_name" name = "nombre" maxlength="32" required>
                   <input type="hidden" class="form-control" id="course_id" name="id_modulo" value="<?= $id_modulo ?>" required> 
               </div>
               <div class="mb-3 text-white">
                   <label for="lesson_duration" class="form-label">Duración (minutos)</label>
                   <input type="number" class="form-control" id="lesson_duration" name = "duracion" required>
               </div>
               <div class="mb-3 text-white">
                   <label for="lesson_media" class="form-label">Contenido multimedia</label>
                   <input type="file" class="form-control" id="lesson_media" name = "contenido_multimedia" required>
               </div>
               <button type="submit" class="btn btn-primary">Crear lección</button>
           </form>
       </div>
   </div>

   

<!-- Incluimos el footer -->
<?= view('template/footer') ?>