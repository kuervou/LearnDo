<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>
    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container py-5">
        <!-- Título del foro -->
        <div class="jumbotron text-center bg-transparent custom-jumbotron text-white py-5">
            <h1 class="display-4">Foro: <?= $data[0]['nombre']; ?></h1>
            <p class="lead"><?= $data[0]['descripcion']; ?></p>
        </div>

        <!-- Contenido multimedia -->
        <?php
        $extension = pathinfo($data[0]['ruta_multimedia'], PATHINFO_EXTENSION);
        $src = base_url('/public/uploads/contenidoMultimedia/discusiones/') . $data[0]['ruta_multimedia'];
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'JPG':
            case 'JPEG':
            case 'PNG':
            case 'GIF':
                echo "<img src='$src' alt='Media' style='max-width:100%; height:auto;'>";
                break;
            case 'mp4':
            case 'webm':
            case 'MP4':
            case 'WEBM':
                echo "<video controls style='max-width:100%; height:auto;'><source src='$src' type='video/$extension'></video>";
                break;
            case 'pdf':
            case 'PDF':
                echo "<iframe src='$src' width='100%' height='500px'></iframe>";
                break;
            default:
                echo "Formato de archivo no soportado. <br>";
                echo "<a href='$src' download><button>Descargar archivo</button></a>";
                break;
        }
        ?>

        <!-- Zona de discusión -->
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card card-material">
                    <div class="card-body">

                        <!-- Mensajes -->
                        <div id="messages" style="height: 400px; overflow-y: scroll;" class="mb-3">

                            <!-- Comentarios -->
                            <?php if (isset($mensajes)) { ?>
                                <?php foreach ($mensajes as $mensaje) : ?>
                                    <div class="comments">
                                        <!-- Comentarios -->
                                        <div class="comment">
                                            <?php if (session('tipoUser') == 'organizador') { ?>
                                                <h3> <?= $mensaje['nick_emisor_organizador'] ?> </h3>
                                            <?php } else { ?>
                                                <h3> <?= $mensaje['nick_emisor_estudiante'] ?> </h3>
                                            <?php } ?>
                                            <p> <?= $mensaje['contenido'] ?> </p>
                                            <p class="timestamp"></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php } ?>
                        </div>

                        <!-- Formulario de envío de mensajes -->
                        <div class="reply-options">
                            <form method="POST" action="<?= base_url('/agregarMensaje') ?> ">
                                <input type="hidden" class="form-control" name="id_discusion" value="<?= $data[0]['id_discusion'] ?>" required>
                                <input type="text" name="mensaje" placeholder="Responder...">
                                <button type="submit">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Incluimos el archivo js -->
    <script src="<?= base_url('js/foro/discusion.js') ?>"></script>


    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>