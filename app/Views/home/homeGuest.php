<!-- Incluimos el head -->
<?= view('template/head') ?>

<script>
    function initMap() {
        var mapOptions = {
            center: new google.maps.LatLng(-32.6, -55.8),
            zoom: 7,
        };
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

        // Coordenadas de los puntos desde el controlador
        var puntos = <?= json_encode($puntos) ?>;

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

    //desconfigurar service workers
    navigator.serviceWorker.getRegistrations()
        .then(function(registrations) {
            for (let registration of registrations) {
                registration.unregister();
            }
        });
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4CBnz1IbIRqZQ-NULt4Ygcyh-R9D0Qu8&callback=initMap"></script>

<style>
    @keyframes ripple {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 10% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    @keyframes zoom {
        0% {
            background-size: 100%;
        }

        50% {
            background-size: 110%;
        }

        100% {
            background-size: 100%;
        }
    }

    @keyframes scroll {
        0% {
            background-position: 0 30;
        }

        100% {
            background-position: 0 169px;
        }
    }

    .banner {
        padding: 50px;
        color: white;
        text-align: center;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
    }



    .banner.welcome {
        background-image: url('<?php echo base_url("public/assets/images/template/curso.svg") ?>');
        animation: zoom 25s infinite;
    }


    .banner.shop {
        background-image: url('<?php echo base_url("public/assets/images/template/discusion.svg") ?>');
        animation: scroll 15s infinite;
    }

    .banner.login {
        background-image: url('<?php echo base_url("public/assets/images/template/miCurso.svg") ?>');
        animation: zoom 25s infinite;
    }

    .banner.mapa {
        background-image: url('<?php echo base_url("public/assets/images/template/modulo.svg") ?>');
        animation: ripple 15s infinite;
    }

    .banner.testimonios {
        background-image: url('<?php echo base_url("public/assets/images/template/semi.svg") ?>');
       
    }

    .glass-container {
        background: rgba(255, 255, 255, 0.10);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        backdrop-filter: blur(3px);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 20px;
    }

    .img-fluid {
        width: 30%;
        height: auto;
    }

    .text-muted {
        color: #FFD700 !important;
    }
</style>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>
    <!-- Banner de bienvenida -->
    <section class="py-5">
        <div class="container banner welcome">
            <div class="glass-container">
                <h2 class="mb-4">¡Bienvenido!</h2>
                <p>Estás en el lugar correcto para comenzar a aprender.</p>
            </div>
        </div>
    </section>

    <!-- Banner de tienda -->
    <section class="py-5">
        <div class="container banner shop">
            <div class="glass-container">
                <h2 class="mb-4">Visita nuestra tienda</h2>
                <p>Descubre nuestros cursos y seminarios disponibles.</p>
                <a href="<?= base_url('/tienda') ?>" class="btn btn-primary">Ir a la tienda</a>
            </div>
        </div>
    </section>

    <!-- Banner de inicio de sesión -->
    <section class="py-5">
        <div class="container banner login">
            <div class="glass-container">
                <h2 class="mb-4">¡Únete a la comunidad Learndo!</h2>
                <p>Inicia sesión y conviértete en parte de nuestra creciente comunidad.</p>
                <a href="<?= base_url('/login') ?>" class="btn btn-primary">Iniciar sesión</a>
                <a href="<?= base_url('/register') ?>" class="btn btn-primary">Registrate</a>
            </div>
        </div>
    </section>



    <!-- Banner de testimonios -->
    <section class="py-5">
        <div class="container banner">
            <div class="glass-container">
                <h2 class="mb-4">Testimonios</h2>
                <p>Ellos ya comprobaron la efectividad de nuestros cursos</p>
                <!-- Carrousel -->
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Usamos un foreach para recorrer las opiniones y mostrarlas -->
                        <?php foreach ($valoracionesCursos as $index => $valoracion) : ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="card  card-material my-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <!-- Aquí mostramos la imagen del estudiante. Ahora $estudiantes es un array asociativo donde el nick del estudiante es la clave -->
                                            <img src="<?= base_url($estudiantesAsociativo[$valoracion['nick_estudiante']]['ruta_multimedia']) ?>" class="img-fluid rounded-start" alt="Foto de <?= $valoracion['nick_estudiante'] ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $valoracion['nick_estudiante'] ?></h5>
                                                <!-- Aquí mostramos las estrellas amarillas. Puedes cambiar la representación de las estrellas según lo que necesites -->
                                                <div class="card-rating">
                                                    <p class="card-text rating-text"><small class="text-muted">★★★★★</small></p>
                                                </div>

                                                <p class="card-text"><?= $valoracion['opinion'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
        </div>
    </section>





    <!-- Mapa -->
    <section class="py-5">
        <div class="container banner mapa">
            <div class="glass-container p-4 text-center text-white">
                <h2 class="text-center mb-5">Próximos seminarios</h2>
                <div id="map" class="rounded shadow" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url('public/js/cargarCache/custom.js'); ?>"></script>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>