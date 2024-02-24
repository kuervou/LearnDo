<!-- Incluimos el head -->
<?= view('template/head') ?>

<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

<div class="container">
       <!-- Agregar un nuevo módulo -->
       <h2 class="my-4 text-white">Agregar un nuevo módulo</h2>
       <div class="module-form-container">
           <form id="module_form" method="POST" action="<?= base_url('/agregarModulo') ?>">
               <div class="mb-3">
                   <label for="module_name " class="form-label text-white">Nombre del módulo</label>
                   <input type="text " class="form-control" id="module_name" name="nombre" maxlength="32" required>
                   <input type="hidden" class="form-control" id="course_id" name="id_curso" value="<?= $id_curso ?>" required> 
               </div>
               <button type="submit" class="btn btn-primary">Crear módulo</button>
           </form>
       </div>
   </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>