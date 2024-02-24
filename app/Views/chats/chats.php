<!-- Incluimos el head -->
<?= view('template/head') ?>

<body class="fullHeight">
  <!-- Incluimos los alerts -->
  <?= view('template/alerts') ?>

 
      <div class="card-body">
        <div id="chat-messages" class="mb-3 " style="height: 400px; overflow-y: scroll;">
          <?php
          foreach ($datos as $mensaje) :
            $emisor = (isset($mensaje['nick_emisor_estudiante']) && $mensaje['nick_emisor_estudiante'] == session('usuario')) ||
              (isset($mensaje['nick_emisor_organizador']) && $mensaje['nick_emisor_organizador'] == session('usuario'));
          ?>
            <div class="message  <?= $emisor ? 'right text-end' : 'left' ?> text-white">
              <p><?= $mensaje['contenido'] ?></p>
            </div>
          <?php endforeach; ?>
        </div>

        <form id="chat_form" method="POST" action="<?= base_url('/escribirMensaje') ?>" class="d-flex" target="_self">          <input type="hidden" class="form-control" id="tipoReceptorId" name="tipoReceptor" value="<?= $tipoReceptor ?>" required>
          <input type="hidden" class="form-control" id="nickReceptorId" name="nickReceptor" value="<?= $receptor ?>" required>
          <textarea placeholder="Escribe tu mensaje" name="mensaje" class="form-control me-2" rows="1"></textarea>
          <button class="send-button btn btn-primary">Enviar</button>
        </form>
      </div>
    
  <script>
    document.addEventListener('DOMContentLoaded', function(event) {
      scrollToBottom();
    });
  </script>
  <script>
    // Llama a esta función después de añadir un nuevo mensaje al contenedor de mensajes
    function scrollToBottom() {
      var chatMessages = document.getElementById('chat-messages');
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    var messageInput = document.querySelector('textarea[name="mensaje"]');

    messageInput.addEventListener('keydown', function(event) {
      if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        document.getElementById('chat_form').submit();
      }
    });
  </script>


  <!-- Incluimos el footer -->
  <?= view('template/footer') ?>