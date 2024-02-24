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
                    <h2 class="my-4 text-white">Mis Cursos</h2>
                </div>
                <?php foreach ($cursos as $curso) : ?>
                    <!-- Tarjeta de curso 1 -->
                    <div class="col-md-6">
                        <div class="card card-material mb-3">
                            <!-- <img src="Logo.png" class="card-img-top course-img" alt="Curso 1">-->
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $curso['nombre'] ?></h5>
                                <p class="card-text"><?php echo $curso['descripcion'] ?></p>
                                <!--  -->
                                <a href=" <?= base_url('consultarCurso/?id_curso=' . $curso['id_curso'])  ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
                        var toastList = toastElList.map(function(toastEl) {
                            return new bootstrap.Toast(toastEl)
                        });
                        toastList.forEach(toast => toast.show());
                    }
                </script>
                <!-- Incluimos el footer -->
                <?= view('template/footer') ?>