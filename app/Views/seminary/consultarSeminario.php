<!-- Incluimos el head -->
<?= view('template/head') ?>
<?php if ($tipo == "presencial") { ?>

    <script>
        function initMap() {
            // Coordenadas de los puntos desde el controlador
            var puntos = <?= json_encode($puntos) ?>;
            var mapOptions = {
                center: new google.maps.LatLng(puntos[0].lat, puntos[0].lng),
                zoom: 15,
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);



            // Agregar marcadores al mapa
            for (var i = 0; i < puntos.length; i++) {
                var punto = puntos[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(punto.lat, punto.lng),
                    map: map,
                });
            }
        }

        // Ejecutar la función initMap cuando se carga la página
        window.onload = initMap;
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4CBnz1IbIRqZQ-NULt4Ygcyh-R9D0Qu8&callback=initMap"></script>



<?php } ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <div class="container">
        <!-- Course Details -->
        <div class="card card-material bg-transparent custom-jumbotron text-white my-4 justify-content-center">
            <div class="card-body">
                <h2 class="card-title"> <?php echo $datosSeminario[0]['nombre']; ?> </h2>
                <h5 class="mb-1 text-white-50">Descripción</h5>
                <p class="card-text mb-2"><?php echo $datosSeminario[0]['descripcion']; ?></p>
                <h5 class="mb-1 text-white-50">Fecha</h5>
                <p class="card-text mb-2"><?php echo $datosSeminario[0]['fecha']; ?></p>
                <h5 class="mb-1 text-white-50">Hora</h5>
                <p class="card-text mb-2"><?php echo $datosSeminario[0]['hora']; ?></p>
                <?php if ($tipo == "virtual") { ?>
                    <!-- si es el organizador del curso o un estudiante que compró el curso -->
                    <?php if (session()->get('usuario') == $datosSeminario[0]['nick_organizador']  || isset($datosSeminario[0]['comprado']) && $datosSeminario[0]['comprado'] == true) { ?>
                        <h5 class="mb-1 text-white-50">Plataforma</h5>
                        <p class="card-text mb-2"><?php echo $datosSeminario[0]['plataforma']; ?></p>
                        <?php if ($tipo == "virtual" && isset($datosSeminario[0]['chat']) && $datosSeminario[0]['chat']) { //Si el curso el virtual y es la hora
                        ?>
                            <a href="<?= base_url('liveChat/?id_seminario=' . $datosSeminario[0]['id_seminario_virtual'] . '&nombre=' . $datosSeminario[0]['nombre'] . '&fecha=' . $datosSeminario[0]['fecha'] . '&hora=' . $datosSeminario[0]['hora']) ?>" class="d-flex align-items-center btn btn-primary mt-2 mx-2 "><span class="material-symbols-outlined  mr-2">
                                    chat
                                </span>Ir al chat en vivo</button></a>
                        <?php }
                        ?>
                    <?php } ?>
                    <?php } else {
                    if ($tipo == "presencial" && (session()->get('usuario') == $datosSeminario[0]['nick_organizador']  || isset($datosSeminario[0]['comprado']) && $datosSeminario[0]['comprado'] == true)) { //Si el curso es presencial y es el organizador o un estudiante que compró el curso
                    ?><h5 class="mb-1 text-white-50">Ubicación</h5>
                        <div id="map" class="rounded shadow" style="height: 400px; width: 100%;"></div>
                        <h5 class="mb-1 text-white-50">Capacidad</h5>
                        <p class="card-text mb-2"><?php echo $datosSeminario[0]['capacidad']; ?></p>
                    <?php } ?>

                <?php } ?>







                <!-- Botones con acciones -->

                <div class="text-center mt-4 mx-2  d-flex justify-content-left">
                    <?php if (session()->get('tipoUser') == null ||(session("tipoUser") == "estudiante" && isset($datosSeminario[0]["comprado"]) && !$datosSeminario[0]['comprado'])) { //SI ES ESTUDIANTE Y NO COMPRO EL CURSO 
                    ?>
                        <?php if ($tipo == "virtual") { ?>
                            <a href="<?= base_url('realizarPago/?id_seminario_virtual=' . $datosSeminario[0]['id_seminario_virtual'] . '&nick_estudiante=' . session()->get('usuario')) ?>" class="d-flex align-items-center btn btn-primary mt-2  mx-2"><span class="material-symbols-outlined  mr-2">
                                    shopping_cart
                                </span>Comprar seminario US$<?php echo $datosSeminario[0]['precio']; ?></button></a>
                            <?php } else {
                            if (isset($datosSeminario[0]["capacidad"]) && ($datosSeminario[0]['capacidad'] > 0)) { ?>
                                <a href="<?= base_url('realizarPago/?id_seminario_presencial=' . $datosSeminario[0]['id_seminario_presencial'] . '&nick_estudiante=' . session()->get('usuario')) ?>" class="d-flex align-items-center btn btn-primary mt-2  mx-2"><span class="material-symbols-outlined  mr-2">
                                        shopping_cart
                                    </span>Comprar seminario US$<?php echo $datosSeminario[0]['precio']; ?></button></a>
                            <?php           } else if (isset($datosSeminario[0]["capacidad"]) && ($datosSeminario[0]['capacidad'] == 0)) { ?>
                                <a href="#" class="d-flex align-items-center btn btn-secondary mt-2  mx-2"><span class="material-symbols-outlined  mr-2">
                                        sentiment_dissatisfied
                                    </span>Cupos agotados</button></a>
                    <?php           }
                        }
                    } ?>
                    <?php
                    if (isset($datosSeminario[0]["comprado"]) && $datosSeminario[0]["comprado"]) { //Si es estudiante y ya compró el curso 
                    ?>



                        <a href="<?= base_url('/add-to-google-calendar') ?>" class="d-flex align-items-center btn btn-primary mt-2 mx-2">
                            <span class="material-symbols-outlined   mr-2">
                                event
                            </span>Agregar al calendario
                        </a>
                    <?php } ?>

                </div>
                <?php
                if (isset($datosSeminario[0]["comprado"]) && $datosSeminario[0]["comprado"]) { //Si es estudiante y ya compró el curso 
                ?>
                    <?php // Me fijo si el seminario ya se hizo, comprobando la fecha del seminario con la del datosCalendaar de la sesion
                    if (env('HORA_PERSONALIZADA_ENVIRONMENT')) {
                        $fecha_hora = env('FECHA_HORA_ENVIRONMENT');
                    } else {
                        $fecha_hora = date("Y-m-d H:i:s");
                    }

                    if (isset($datosSeminario[0]['fecha']) && $fecha_hora >= $datosSeminario[0]['fecha']) { ?>
                        <!-- Rating Section - Only shown when the user finishes the course -->
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
                    <?php } else { ?>
                        <h2 class="my-4 text-white">Valoración</h2>
                        <h5 class="my-4 text-white">Todavía no puedes valorar este seminario, luego de que el seminario se haya realizado puedes valorarlo</h5>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

    </div>



    <script>
        let selectedRating = 0;

        <?php if ($tipo == "virtual") { ?>
            let idSeminario = <?= $datosSeminario[0]['id_seminario_virtual'] ?>
        <?php } else { ?>
            let idSeminario = <?= $datosSeminario[0]['id_seminario_presencial'] ?>
        <?php } ?>


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
            const tipo = '<?= $tipo ?>';

            const data = {
                rating: rating,
                opinion: opinion,
                idSeminario: idSeminario,
                tipo: tipo
            };

            fetch('valorarSeminario', {
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
    </script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>