<!-- Incluimos el head -->
<?= view('template/head') ?>

<style>
    /* Estilos personalizados para el modal */
    .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 5px;
        width: 100%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

  
    .pdf-container {
    position: relative;
    padding-bottom: 75%; /* This can be adjusted as needed; it controls the aspect ratio */
    height: 0;
    overflow: hidden;
    }

    .pdf-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    }

</style>



<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <div class="container py-5">
        <div class="glassmorphism p-4">
            <h1 class="text-center mb-4">Muro de publicaciones</h1>

            <!-- Botón para abrir el modal -->
            <button class="btn btn-primary" onclick="openModal()">Crear nueva publicación</button>
        </div>

        <!-- Modal -->
        
<!-- Modal -->
<div id="myModal" class="modal glassmorphism">
    <!-- Modal dialog -->
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content bg-dark text-light ">
            <div class="modal-header">
                <h2 class="modal-title">Crear nueva publicación</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/agregarPublicacion') ?> " method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Contenido de texto:</label>
                        <textarea class="form-control" name="contenidoTexto"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contenido multimedia:</label>
                        <input class="form-control" type="file" name="contenidoMultimedia" required>
                    </div>
                    <div class="mb-3">
                        <input class="btn btn-primary" type="submit" value="Crear publicación">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <div class="publications row">
        <?php if (!empty($publicaciones)) : ?>
            <?php foreach ($publicaciones as $publicacion) : ?>
                <div class="col-md-6 col-lg-4 my-2">
                    <div class="card glassmorphism h-100">
                        <div class="card-body">
                            <?php 
                            // Obtén la foto de perfil del usuario
                            $foto = "";
                            $nombreUsuario = "";
                            foreach($estudiantes as $estudiante) {
                                if($estudiante['nick'] == $publicacion['nick_estudiante']) {
                                    $foto = base_url($estudiante['ruta_multimedia']);
                                    $nombreUsuario = $estudiante['nick'];
                                    break;
                                }
                            }
                            if(empty($nombreUsuario)) {
                                foreach($organizadores as $organizador) {
                                    if($organizador['nick'] == $publicacion['nick_organizador']) {
                                        $foto = base_url($organizador['ruta_multimedia']);
                                        $nombreUsuario = $organizador['nick'];
                                        break;
                                    }
                                }
                            }

                            // Mostrar la foto de perfil y el nombre del usuario
                            if(!empty($foto) && !empty($nombreUsuario)) {
                                echo "<div class='d-flex align-items-center mb-3'>";
                                echo "<img src='$foto' alt='$nombreUsuario' width='40' height='40' class='rounded-circle me-2'>";
                                echo "<h5 class='mb-0'>$nombreUsuario</h5></div>";
                            }
                            ?>

                            <?php if (!empty($publicacion['contenido'])) : ?>
                                <p><?php echo $publicacion['contenido']; ?></p>
                            <?php endif; ?>

                            <?php if (!empty($publicacion['ruta_multimedia'])) : ?>
                                <?php 
                                    $extension = pathinfo($publicacion['ruta_multimedia'], PATHINFO_EXTENSION);
                                    $src = base_url('/public/uploads/contenidoMultimedia/publicaciones/').$publicacion['ruta_multimedia'];
                                    switch ($extension) {
                                        case 'jpg':
                                        case 'jpeg':
                                        case 'png':
                                        case 'svg':
                                        case 'gif':
                                            echo "<img class='img-fluid mb-2' src='$src' alt='Media'>";
                                            break;
                                        case 'mp4':
                                        case 'webm':
                                            echo "<video class='img-fluid mb-2' controls><source src='$src' type='video/$extension'></video>";
                                            break;
                                        case 'pdf':
                                            echo "<div class='pdf-container'><iframe class=' mb-2' src='$src'></iframe></div>";
                                            break;
                                        default:
                                            echo "Formato de archivo no soportado. <br>";
                                            break;
                                    }
                                ?>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer text-muted text-end">
                            Publicado el: <?php echo $publicacion['fecha_hora']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="glassmorphism p-4">No hay publicaciones disponibles.</p>
        <?php endif; ?>
    </div>


    <script>
        // Función para abrir el modal
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    </script>
</body>
<!-- Incluimos el footer -->
<?= view('template/footer') ?>
