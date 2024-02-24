function initMap() {
   
    var mapOptions = {
        center: new google.maps.LatLng(-34.9, -56.2),
        zoom: 7,
        streetViewControl: false, // Deshabilitar el control de Street View
    };
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);
    // Inicialmente no hay marcador
    var marker = null;

    // Listener para el evento click en el mapa
    google.maps.event.addListener(map, 'click', function (event) {
        // Si ya existe un marcador, lo eliminamos del mapa
        if (marker) {
            marker.setMap(null);
        }

        // Creamos un nuevo marcador en la posición seleccionada
        marker = new google.maps.Marker({
            position: event.latLng,
            map: map,
            title: "Ubicación del seminario",
        });

        // Guardamos las coordenadas en el input oculto
        document.getElementById('ubicacion-coords').value = event.latLng.toUrlValue();
    });
}



document.getElementById('tipo').addEventListener('change', function () {
    var tipo = this.value;
    if (tipo === 'virtual') {
        document.getElementById('virtual-info').style.display = 'block';
        document.getElementById('presencial-info').style.display = 'none';
        document.getElementById('map').style.display = 'none';
    } else if (tipo === 'presencial') {
        document.getElementById('virtual-info').style.display = 'none';
        document.getElementById('presencial-info').style.display = 'block';
        document.getElementById('map').style.display = 'block';
        initMap();
    } else {
        document.getElementById('virtual-info').style.display = 'none';
        document.getElementById('presencial-info').style.display = 'none';
        document.getElementById('map').style.display = 'none';
    }
});