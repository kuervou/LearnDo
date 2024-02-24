//JAVASCRIPT-->

    function mostrarHora() {
        var fecha = new Date();
        var opcionesFecha = { hour: 'numeric', minute: 'numeric', hour12: true };
        var horaFormateada = fecha.toLocaleString('es-ES', opcionesFecha);
        var elementosTimestamp = document.getElementsByClassName('timestamp');
        for (var i = 0; i < elementosTimestamp.length; i++) {
            elementosTimestamp[i].textContent = 'Publicado el ' + horaFormateada;
        }
    }

    mostrarHora();
