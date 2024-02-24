<!-- Incluimos el head -->
<?= view('template/head') ?>

<script>
  function initMap() {
        var mapOptions = {
        center: new google.maps.LatLng(-34.9, -56.2),
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
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4CBnz1IbIRqZQ-NULt4Ygcyh-R9D0Qu8&callback=initMap"></script>


<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <!--Titulo con lo que haya en la variable $ubicacion_coords -->
        <div id="map" style="height: 400px; width: 100%;"></div>


<!-- Incluimos el footer -->
<?= view('template/footer') ?> 