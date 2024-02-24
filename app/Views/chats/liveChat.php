<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>
    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <!-- Cuerpo de la página -->
    <div class="container py-5">
        <!-- Título del chat -->
        <div class="jumbotron text-center bg-transparent custom-jumbotron text-white py-5">
            <h1 class="display-4">Chat en Vivo del seminario: <?php echo $nombre ; ?></h1>
            <p class="lead">Comunícate en tiempo real con otros usuarios</p>
        </div>

        <!-- Zona de chat -->
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="card card-material">
                    <div class="card-body">
                        <!-- Mensajes -->
                        <div id="messages" style="height: 400px; overflow-y: scroll;" class="mb-3"></div>

                        <!-- Formulario de envío de mensajes -->
                        <form id="message-form" class="d-flex">
                            <input type="text" id="message-input" class="form-control me-2" placeholder="Escribe tu mensaje aquí">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>

    <script>

var id_seminario =  <?php echo $id_seminario; ?>;

var conn = new WebSocket('ws://localhost:8080');
var messages = document.getElementById('messages');
var messageInput = document.getElementById('message-input');

function displayMessage(messageData) {
    // Crea un elemento para el mensaje y asigna los datos del mensaje
    var msg = document.createElement('div');
    msg.classList.add('message-item');

    var userPic = document.createElement('img');
    userPic.classList.add('message-pic');
    userPic.src = messageData.userPicURL;
    userPic.alt = messageData.userName + "'s Picture";

    var userName = document.createElement('span');
    userName.classList.add('message-user');
    userName.textContent = messageData.userName;

    var userMessage = document.createElement('p');
    userMessage.classList.add('message-text');
    userMessage.textContent = messageData.message;

    if (messageData.userName === nick) {
        userMessage.classList.add('user-message');
    }

    if (messageData.userName !== nick) {
        msg.appendChild(userPic);
        msg.appendChild(userName);
    }

    msg.appendChild(userMessage);
    messages.appendChild(msg);
}






conn.onopen = function(e) {
    console.log("Conexión establecida!");
};
var nick = "<?= session()->get('usuario') ?>";
conn.onmessage = function(e) {
    // Parse the incoming message
    var incomingMsg = JSON.parse(e.data);

    var msg = document.createElement('div');
    msg.classList.add('message-item'); // Nueva clase para el contenedor del mensaje

    var userPic = document.createElement('img');
    userPic.classList.add('message-pic'); // Nueva clase para la foto del usuario

    var userName = document.createElement('span');
    userName.classList.add('message-user'); // Nueva clase para el nombre del usuario

    var userMessage = document.createElement('p');
    userMessage.classList.add('message-text'); // Nueva clase para el texto del mensaje

    if (incomingMsg.userName === nick) {
        userMessage.classList.add('user-message');
    }
    // Set the source and the alt text for the user image
    userPic.src = incomingMsg.userPicURL;
    userPic.alt = incomingMsg.userName + "'s Picture";

    // Set the user name text
    userName.textContent = incomingMsg.userName;

    // Set the message text
    userMessage.textContent = incomingMsg.message;

    if (incomingMsg.userName !== nick) {
        // Append the user picture and the user name to the div
        msg.appendChild(userPic);
        msg.appendChild(userName);
    }


    // Append the message to the div
    msg.appendChild(userMessage);

    // Append the div to the messages
    messages.appendChild(msg);

    // Scroll to the last received message
    messages.scrollTop = messages.scrollHeight;
};

document.getElementById('message-form').onsubmit = function(e) {
    e.preventDefault();

    // Verificar si estamos dentro de la hora permitida para enviar mensajes
    <?php
    $seminar_time = strtotime($fecha . ' ' . $hora); // Convertir la fecha y hora del seminario a un formato comparable
    if (env('HORA_PERSONALIZADA_ENVIRONMENT')){
        $fecha_hora = strtotime(env('FECHA_HORA_ENVIRONMENT'));
    }
    else{
        $fecha_hora = time();
    }
    if ($fecha_hora < $seminar_time || $fecha_hora > $seminar_time + 3600) {
        echo 'return false;'; // Si no estamos dentro de la hora permitida, no enviamos el mensaje
    }
    ?>

    var messageContent = messageInput.value;
    var fecha_hora = new Date().toISOString().slice(0, 19).replace('T', ' ');


    var tipo_user = "<?php echo session()->get('tipoUser'); ?>";
    var nick = "<?php echo session()->get('usuario'); ?>";

    var messageData = {
        userPicURL: "<?php echo base_url(session()->get('ruta_multimedia')); ?>",
        userName: nick,
        message: messageContent,
        contenido: messageContent,
        fecha_hora: fecha_hora,
        id_seminario: id_seminario,
        nick_emisor_estudiante: tipo_user === "estudiante" ? nick : null,
        nick_emisor_organizador: tipo_user === "organizador" ? nick : null
    };

    var messageDataBD = {

        contenido: messageContent,
        fecha_hora: fecha_hora,
        id_seminario: id_seminario,
        nick_emisor_estudiante: tipo_user === "estudiante" ? nick : null,
        nick_emisor_organizador: tipo_user === "organizador" ? nick : null
    };

    // Create the sent message element
    var msg = document.createElement('p');
    msg.textContent = messageInput.value;
    // Add a class to identify the user-sent messages
    msg.classList.add("user-message");
    messages.appendChild(msg);
    messages.scrollTop = messages.scrollHeight;
    // Send the message to the WebSocket server
    conn.send(JSON.stringify(messageData));
    messageInput.value = "";

    // Enviar el mensaje al servidor a través de AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/LearnDo/chat/insertMessage', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (this.status === 200) {
            console.log("Mensaje guardado en la base de datos.");
        } else {
            console.log("Hubo un error al guardar el mensaje en la base de datos.");
        }
    };
    xhr.send(JSON.stringify(messageDataBD));
};
window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/LearnDo/chat/getMessages', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (this.status === 200) {
            var messages = JSON.parse(this.responseText);
            messages.forEach(function(msg) {
                // Crear una estructura de mensaje compatible con la función displayMessage
                var displayMsg = {
                    userPicURL: msg.estudiante_ruta_multimedia || msg.organizador_ruta_multimedia,
                    userName: msg.nick_emisor_organizador || msg.nick_emisor_estudiante,
                    message: msg.contenido
                };
                displayMessage(displayMsg);
            });
        } else {
            console.log("Hubo un error al recuperar los mensajes de la base de datos.");
        }
    };
    xhr.send(JSON.stringify({
        id_seminario: id_seminario
    }));
};
    </script> 
</body>

</html>