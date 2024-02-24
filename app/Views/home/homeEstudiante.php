<!-- Incluimos el head -->
<?= view('template/head') ?>
<script>
  //Script para que funcione el tooltip
  $(function() {
    $('[data-bs-toggle="tooltip"]').tooltip()
  })
</script>
<!-- Cargar el Service Worker -->
<script>
  
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('sw.js')
                .then(function() {
                    console.log("Service Worker Registrado");
                });
        }
</script>
<style>
  .sidebar {
    position: sticky;
    width: 4.5rem;
    overflow-y: auto;
    height: calc(100vh - 60px);
    /* altura de la ventana de visualización menos la altura del encabezado */
  }
</style>

<body>

  <!-- Incluimos el header -->
  <?= view('template/header') ?>

  <!-- Incluimos los alerts -->
  <?= view('template/alerts') ?>

  <div class="d-flex">

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
      <div id="liveToast" class="toast" data-bs-autohide="false" role="alert" aria-live="assertive" aria-atomic="true" style="min-width: 300px; max-height: 400px;">
        <div class="toast-header">
          <img id="chatUserImage" src="" class="rounded me-2" alt="" style="width: 40px; height: 40px;">
          <strong id="chatUserName" class="me-auto">Chat</strong>
          <small>LearnDo</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" style="overflow-y: auto; height: 300px;">
          <iframe id="chatIframe" style="display: none; width: 100%; height: 100%; border: none;"></iframe>
        </div>

      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar bg-body-dark d-flex flex-column align-items-center py-3" style="width: 4.5rem;">
      <!-- Titulo de chats -->
      <h5 class="text-secondary">Chats</h5>


      <?php foreach ($estudiantes as $estudiante) :
        if ($estudiante['nick'] != session('usuario')) { ?>
          <a href="#" onclick="openChat('<?= base_url('cargarChats?receptor=' . $estudiante['nick']) ?>', '<?= $estudiante['nick'] ?>', '<?= base_url($estudiante['ruta_multimedia']) ?>');" class="nav-link py-3 rounded-circle mb-2" title="<?= $estudiante['nick'] ?>" data-bs-toggle="tooltip" data-bs-placement="right">
            <img src="<?php echo base_url($estudiante['ruta_multimedia']) ?>" alt="<?= $estudiante['nick'] ?>" width="40" height="40" class="rounded-circle">
          </a>


        <?php } ?>
      <?php endforeach; ?>
      <?php foreach ($organizadores as $organizador) :
        if ($organizador['nick'] != session('usuario')) { ?>
          <a href="#" onclick="openChat('<?= base_url('cargarChats?receptor=' . $organizador['nick']) ?>', '<?= $organizador['nick'] ?>', '<?= base_url($organizador['ruta_multimedia']) ?>');" class="nav-link py-3 rounded-circle mb-2" title="<?= $organizador['nick'] ?>" data-bs-toggle="tooltip" data-bs-placement="right">
            <img src="<?php echo base_url($organizador['ruta_multimedia']) ?>" alt="<?= $organizador['nick'] ?>" width="40" height="40" class="rounded-circle">
          </a>
        <?php } ?>

      <?php endforeach; ?>
    </div>
    <!-- Cuerpo de la página -->
    <div class="container">
      <!-- Banner promocional -->
      <div class="jumbotron text-center bg-transparent custom-jumbotron text-white py-5">
        <h1 class="display-4">Bienvenido a LearnDo</h1>
        <p class="lead">Aprende, comparte y crece con nuestra plataforma de e-learning</p>
      </div>
      <!-- Cursos recomendados y calificaciones -->
      <div class="row">
        <div class="col-12">
          <h2 class="my-4 text-white">Cursos recomendados</h2>
        </div>
        <!-- Tarjeta de curso 1 -->
        <?php foreach ($cursos as $curso) :
          $urlImage = base_url('public/assets/images/template/curso.svg'); ?>
          <div class="col-md-6">
            <div class="card card-material mb-3">
              <img src="<?php echo $urlImage; ?>" class="card-img-top course-img" alt="Curso 1">
              <div class="card-body">
                <h5 class="card-title"><?php echo $curso['nombre'] ?></h5>
                <p class="card-text"><?php echo $curso['descripcion'] ?></p>
                <h6 class="card-title">Precio: <?php echo $curso['precio'] ?>US$</h6>
                <?php if (isset($curso['valoracion'])) : ?>
                  <h6 class="card-title">Valoración:
                    <?php
                    $valoracion = $curso['valoracion'];
                    for ($i = 1; $i <= 5; $i++) {
                      if ($i <= $valoracion) {
                        echo '<span style="color: goldenrod;">★</span>'; // Estrella llena de color dorado
                      } else {
                        echo '<span style="color: goldenrod;">☆</span>'; // Estrella vacía de color dorado
                      }
                    }
                    ?>
                  </h6>
                <?php endif; ?>
                <a href="<?= base_url('consultarCurso/?id_curso=' . $curso['id_curso']) ?>" class="btn btn-primary">Ver detalles</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="row">
        <div class="col-12">
          <h2 class="my-4 text-white">Seminarios virtuales recomendados</h2>
        </div>
        <!-- Tarjeta de curso 1 -->
        <?php foreach ($seminarios as $seminario) :
          $urlImage = base_url('public/assets/images/template/semi.svg'); ?>
          <div class="col-md-6">
            <div class="card card-material mb-3">
              <img src="<?php echo $urlImage; ?>" class="card-img-top course-img" alt="Curso 1">
              <div class="card-body">
                <h5 class="card-title"><?php echo $seminario['nombre'] ?></h5>
                <p class="card-text"><?php echo $seminario['descripcion'] ?></p>
                <h6 class="card-title">Precio: <?php echo $seminario['precio'] ?>US$</h6>
                <?php if (isset($seminario['valoracion'])) : ?>
                  <h6 class="card-title">Valoración:
                    <?php
                    $valoracion = $seminario['valoracion'];
                    for ($i = 1; $i <= 5; $i++) {
                      if ($i <= $valoracion) {
                        echo '<span style="color: goldenrod;">★</span>'; // Estrella llena de color dorado
                      } else {
                        echo '<span style="color: goldenrod;">☆</span>'; // Estrella vacía de color dorado
                      }
                    }
                    ?>
                  </h6>
                <?php endif; ?>
                <a href="<?= base_url('consultarSeminario/?id_seminario=' . $seminario['id_seminario_virtual'] . '&tipo=virtual')  ?>" class="btn btn-primary">Ver detalles</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>


      <div class="row">
        <div class="col-12">
          <h2 class="my-4 text-white">Seminarios presenciales recomendados</h2>
        </div>
        <!-- Tarjeta de curso 1 -->
        <?php foreach ($seminariosPresenciales as $seminarioPresencial) :
          $urlImage = base_url('public/assets/images/template/semi.svg'); ?>
          <div class="col-md-6">
            <div class="card card-material mb-3">
              <img src="<?php echo $urlImage; ?>" class="card-img-top course-img" alt="Curso 1">
              <div class="card-body">
                <h5 class="card-title"><?php echo $seminarioPresencial['nombre'] ?></h5>
                <p class="card-text"><?php echo $seminarioPresencial['descripcion'] ?></p>
                <h6 class="card-title">Precio: <?php echo $seminarioPresencial['precio'] ?>US$</h6>
                <?php if (isset($seminarioPresencial['valoracion'])) : ?>
                  <h6 class="card-title">Valoración:
                    <?php
                    $valoracion = $seminarioPresencial['valoracion'];
                    for ($i = 1; $i <= 5; $i++) {
                      if ($i <= $valoracion) {
                        echo '<span style="color: goldenrod;">★</span>'; // Estrella llena de color dorado
                      } else {
                        echo '<span style="color: goldenrod;">☆</span>'; // Estrella vacía de color dorado
                      }
                    }
                    ?>
                  </h6>
                <?php endif; ?>
                <a href="<?= base_url('consultarSeminario/?id_seminario=' . $seminarioPresencial['id_seminario_presencial'] . '&tipo=presencial')  ?>" class="btn btn-primary">Ver detalles</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">
  function openChat(url, userName, userImage) {
    // Get the iframe and header elements
    var iframe = document.getElementById('chatIframe');
    var chatUserName = document.getElementById('chatUserName');
    var chatUserImage = document.getElementById('chatUserImage');

    // Set the iframe's src attribute to the given URL
    iframe.src = url;

    // Make the iframe visible
    iframe.style.display = 'block';

    // Set the user name and image in the toast header
    chatUserName.textContent = userName;
    chatUserImage.src = userImage;

    // Display the toast
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl)
    });
    toastList.forEach(toast => toast.show());
  }
</script>

  <script src="<?php echo base_url('public/js/cargarCache/custom.js'); ?>"></script> 
  <!-- Incluimos el footer -->
  <?= view('template/footer');?>