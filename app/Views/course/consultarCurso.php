<!-- Incluimos el head -->
<?= view('template/head') ?>
<?= view('course/recomendarCurso') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container">
        <!-- Detalle del curso -->
        <h2 class="my-4 text-white"> <?php echo $datosCurso[0]['nombre']; ?> </h2>
        <p class="lead text-white"><?php echo $datosCurso[0]['descripcion']; ?></p>


        <?php //cosas que se muestran si es el organizador del curso o un estudiante que compró el curso
        if (session()->get('usuario') == $datosCurso[0]['nick_organizador']  || isset($datosCurso[0]['comprado']) && $datosCurso[0]['comprado'] == true) { ?>

            <div class="d-flex justify-content-center my-4">
                <form method="POST" action="<?= base_url('agregarPublicacion') ?>">
                    <input type="hidden" class="form-control" name="id_curso" value="<?= $datosCurso[0]['id_curso'] ?>">
                    <input type="hidden" class="form-control" name="compartir" value="true">
                    <button onClick="submit()" class="btn btn-primary">Compartir</button>
                </form>
            
            <?php if (session()->get('usuario') == $datosCurso[0]['nick_organizador']) { ?>
                
                    <a href="<?= base_url('listarSugerencias/?id_curso=' . $datosCurso[0]['id_curso']) ?>" class="btn btn-primary mx-2">Consultar Sugerencias</a>
                
            <?php } ?>
            </div>
            <!-- Lista de módulos -->
            <h3 class="my-4 text-white">Módulos</h3>
            <!-- Botón para agregar un nuevo módulo (SOLO ORGANIZADOR) -->
            <?php if (session()->get('usuario') == $datosCurso[0]['nick_organizador']) { ?>
                <div class="d-flex justify-content-center my-4">
                    <a href="<?= base_url('altaModulo/?id_curso=' . $datosCurso[0]['id_curso']) ?>" class="btn btn-primary">Agregar módulo</a>
                </div>


            <?php } ?>
            <div class="row">
                <?php foreach ($modulos as $modulo) :
                    $urlImage = base_url('public/assets/images/template/modulo.svg'); ?>
                    <!-- Tarjeta de módulo individual -->
                    <div class="col-md-4">
                        <div class="card module-card">
                            <img src="<?php echo $urlImage; ?>" class="card-img-top module-card-img" alt="Módulo 1">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $modulo['nombre']; ?></h5>
                                <a href="<?= base_url('consultarModulo?id_modulo=' . $modulo['id_modulo']) ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <!-- Fin tarjeta de módulo individual -->
                <!-- Aquí se agregarán más tarjetas de módulos individuales con un botón para acceder al detalle de cada módulo -->
            </div>

            <!-- Listamos foros -->
            <h3 class="my-4 text-white">Foros</h3>
            <div class="d-flex flex-wrap justify-content-start">
                <?php foreach ($foros as $foro) :
                    $urlImage = base_url('public/assets/images/template/foro.svg'); ?>
                    <div class="p-2">
                        <div class="card module-card" style="width: 18rem;">
                            <img src="<?php echo $urlImage; ?>" class="card-img-top module-card-img" alt="Foro 1">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $foro['nombre']; ?></h5>
                                <a href="<?= base_url('listarDiscusiones/?id_foro=' . $foro['id_foro']) ?>" class="btn btn-primary">Ir al Foro</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php } ?>

        <?php //si es estudiante y no ha comprado el curso le mostramos el boton comprar
        if (session()->get('tipoUser') == null || (session()->get('tipoUser') == "estudiante" && isset($datosCurso[0]['comprado']) && $datosCurso[0]['comprado'] == false)) { ?>
            <div class="d-flex justify-content-center my-4">
                <a href="<?= base_url('realizarPago/?id_curso=' . $datosCurso[0]['id_curso'] . '?nick_estudiante=' . session()->get('usuario')) ?>" class="d-flex align-items-center btn btn-primary mt-2  mx-2"><span class="material-symbols-outlined  mr-2">
                        shopping_cart
                    </span>Comprar curso US$<?php echo $datosCurso[0]['precio']; ?></button></a>
            </div>
            <?php }
        foreach ($colaboradores as $colaborador) { //colaboradores del curso
            if ($colaborador['nick_estudiante'] == session()->get('usuario')) { ?>
                <div class="d-flex justify-content-center my-4">
                    <a href="<?= base_url('sugerirLeccion/?id_curso=' . $datosCurso[0]['id_curso']) ?>" class="btn btn-primary">Sugerir leccion</a>
                </div>
        <?php }
        } ?>

        <?php if (session('tipoUser') == "estudiante") { ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recommendationLink" onclick="recommendationLink()">
                Recomendar Curso
            </button>
        <?php } ?>



        <!-- ESTE SECTOR SE TIENE QUE MOSTRAR SOLO CUANDO EL PIBE TIENE TERMINADO EL CURSO O SEMINARIO -->
        <?php if (session('tipoUser') == "estudiante") { ?>
            <?php if ($porcentaje == 100) { ?>


                <a href="<?= base_url('generate-pdf?nick_estudiante=' . session()->get('usuario') . '&id_curso=' . $datosCurso[0]['id_curso']) ?>" class="btn btn-primary">Descargar Certificado del curso</a>



                <h2 class="my-4 text-white">Valoración</h2>
                <div class="rating mb-3">
                    <span onmouseover="hoverRating(1)" onmouseout="resetRating()" onclick="rate(1)">☆</span>
                    <span onmouseover="hoverRating(2)" onmouseout="resetRating()" onclick="rate(2)">☆</span>
                    <span onmouseover="hoverRating(3)" onmouseout="resetRating()" onclick="rate(3)">☆</span>
                    <span onmouseover="hoverRating(4)" onmouseout="resetRating()" onclick="rate(4)">☆</span>
                    <span onmouseover="hoverRating(5)" onmouseout="resetRating()" onclick="rate(5)">☆</span>
                </div>
                <form>
                    <div class="form-group">
                        <textarea id="opinion" class="form-control" rows="3" placeholder="Escribe tu opinión"></textarea>
                    </div>
                    <button id="enviarButton" class="btn btn-primary my-2">Enviar</button>
                </form>

            <?php } else if (isset($datosCurso[0]['comprado']) && $datosCurso[0]['comprado'] == true) { ?>
                <h2 class="my-4 text-white">Valoración</h2>
                <h5 class="my-4 text-white">Todavía no puedes valorar este curso, completalo y se debloqueará esta sección para ti</h5>
        <?php }
        } ?>
    </div>
    <script>
        let selectedRating = 0;
        let idCurso = <?= $datosCurso[0]['id_curso'] ?>;
        let nick_estudiante = '<?= session()->get('usuario') ?>';

        <?php if (count($valoraciones) > 0) { ?>
            const puntuacionPrevia = <?= $valoraciones[0]['nota'] ?>;
            const opinionPrevia = '<?= $valoraciones[0]['opinion'] ?>';

            // Función para verificar si el usuario ya realizó una valoración
            function verificarValoracionRealizada() {
                if (puntuacionPrevia > 0) {
                    // El usuario ya realizó una valoración previa
                    // Deshabilitar el sector de valoración
                    const ratingContainer = document.querySelector('.rating');
                    const opinionTextArea = document.getElementById('opinion');
                    const enviarButton = document.getElementById('enviarButton');

                    ratingContainer.classList.add('disabled');
                    opinionTextArea.disabled = true;
                    enviarButton.style.display = 'none';

                    // Mostrar la puntuación previa
                    updateRating(puntuacionPrevia);

                    // Mostrar la opinión previa
                    opinionTextArea.value = opinionPrevia;
                }
            }

            // Llamar a la función de verificación al cargar la página
            verificarValoracionRealizada();
        <?php } ?>

        function rate(rating) {
            if (rating === selectedRating) {
                // Si se hace clic en la misma valoración seleccionada, desmarcar todas las estrellas
                selectedRating = 0;
            } else {
                selectedRating = rating;
            }
            updateRating(selectedRating);
            console.log(selectedRating);
        }

        function hoverRating(rating) {
            const ratingContainer = document.querySelector('.rating');
            const stars = ratingContainer.querySelectorAll('span');

            stars.forEach((star, index) => {
                if (index < rating) {
                    star.style.color = 'gold';
                } else {
                    star.style.color = '';
                }
            });
        }

        function resetRating() {
            const ratingContainer = document.querySelector('.rating');
            const stars = ratingContainer.querySelectorAll('span');

            stars.forEach((star, index) => {
                if (index >= selectedRating) {
                    star.style.color = '';
                }
            });
        }

        function updateRating(selectedRating) {
            const ratingContainer = document.querySelector('.rating');
            const stars = ratingContainer.querySelectorAll('span');

            stars.forEach((star, index) => {
                if (index < selectedRating) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }



        function submitRating() {
            const rating = selectedRating;
            const opinion = document.getElementById('opinion').value;

            const data = {
                rating: rating,
                opinion: opinion,
                id_curso: idCurso
            };

            console.log(opinion);
            console.log(rating);
            console.log(idCurso);

            fetch('valorarCurso', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    // Aquí puedes manejar la respuesta del controlador si es necesario
                    console.log(result);

                    location.reload();
                })
                .catch(error => {
                    // Manejo de errores en caso de que la petición falle
                    console.error('Error:', error);
                });
        }

        // Agregar evento de escucha al botón de enviar
        enviarButton.addEventListener('click', submitRating);


        function recommendationLink() {
            let link = "http://localhost/LearnDo/realizarPago?id_curso=+idCurso+&nick_estudiante=+nick_estudiante";

            var modal = document.querySelector('#recommendationLink');

            // Obtén una referencia al elemento de entrada dentro del modal
            var inputCurso = modal.querySelector('#recommLink');

            // Establece el valor del elemento de entrada con los datos que deseas enviar
            inputCurso.value = link; // Reemplaza 'Nombre del curso' con los datos que desees enviar
        }
    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>