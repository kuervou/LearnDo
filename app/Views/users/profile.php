<!-- Incluimos el head -->
<?= view('template/head') ?>
<style>
    .profile-field {
        cursor: pointer;
    }

    .profile-field:hover {
        background-color: #106474;
    }
</style>


<?php include('cambiarContraseñaModal.php') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex flex-column align-items-center text-center">
                    <img id="profile-img" src="<?php echo base_url($datos[0]['ruta_multimedia']); ?>" alt="Admin" class="rounded-circle p-1 bg-custom" width="110">
                    <input id="img-input" type="file" style="display:none;" accept="image/*">
                    <div class="mt-3 text-white">
                        <h4 id="nickname" class="my-1">Nickname</h4>
                        <?php if(session()->get('tipoUser') == 'estudiante'){ 
                            if($datos[0]['id_linkedin'] != null){?>
                                <p class=" font-size-sm">Conectado con: <img src="<?php echo base_url('public/assets/images/Linkedin.png'); ?>" alt="Social Media" width="30"></p>
                         <?php }
                             } ?>
                        <button id="edit-img-btn" class="d-flex align-items-center btn btn-primary my-2 ml-4"><span class="material-symbols-outlined  mr-2">upload</span>Editar imagen </button>
                        <button id="saveImage" class="d-flex align-items-center btn btn-primary  my-2 ml-4"><span class="material-symbols-outlined  mr-2">save</span>Guardar cambios</button>
                        <?php if(session()->get('tipoUser') == 'estudiante'){ ?>
                            <form method="POST" action="<?= base_url('/historialPagos') ?>">
                                <button onclick="submit" class="d-flex align-items-center btn btn-primary my-2 ml-4"><span class="material-symbols-outlined  mr-2">shopping_bag</span>Mis Compras</button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">

                <div class="row">
                    <div class="col">
                        <h1 class="font-weight-bold text-white mb-0 text-center">Editar datos de la cuenta</h1>
                    </div>
                    <div class="card-material card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nombre</h6>
                                </div>
                                <div id="nombre" class="col-sm-9 text-white profile-field">
                                    <?php echo $datos[0]['nombre']; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Apellido</h6>
                                </div>
                                <div id="apellido" class="col-sm-9 text-white profile-field">
                                    <?php echo $datos[0]['apellido']; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div id="email" class="col-sm-9 text-white profile-field">
                                    <?php echo $datos[0]['email']; ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Teléfono</h6>
                                </div>
                                <div id="phone" class="col-sm-9 text-white profile-field">
                                    <?php echo $datos[0]['telefono']; ?>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Biografía</h6>
                                </div>
                                <div id="bio" class="col-sm-9 text-white profile-field">
                                    <?php echo $datos[0]['biografia']; ?>

                                </div>
                            </div>
                            <?php if (session()->get('tipoUser') == 'estudiante') { ?>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Créditos</h6>
                                    </div>
                                    <div id="credits" class="col-sm-9 text-white profile-field">
                                        <?php echo $datos[0]['creditos']; ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    Cambiar contraseña
                                </button>
                                </div>      
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-end">
                            <button id="save" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       


        <script>
            // Lista de campos del perfil que se pueden editar
            const editableFields = ['nombre', 'apellido', 'phone', 'bio'];

            // Seleccionamos el botón de guardar y lo ocultamos inicialmente
            const saveButton = document.querySelector('#save');
            saveButton.style.display = 'none';

            // Función para habilitar la edición en el campo al hacer clic
            function makeFieldEditable(id) {
                const element = document.getElementById(id);

                element.addEventListener('click', function() {
                    // Cambiamos el elemento a un input
                    const inputValue = this.innerText;
                    this.innerText = '';
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = inputValue;
                    input.id = id;
                    input.className = 'form-control';
                    this.append(input);
                    input.focus();

                    // Cuando el input pierde el foco, cambiamos de vuelta a texto
                    input.addEventListener('blur', function() {
                        const text = this.value;
                        this.parentElement.innerText = text;
                        saveButton.style.display = 'block'; // Mostramos el botón de guardar
                    });
                });
            }

            // Aplicamos la función a todos los campos editables
            editableFields.forEach(makeFieldEditable);

            //LOGICA PARA LA IMAGEN
            const imgInput = document.getElementById('img-input');
            const profileImg = document.getElementById('profile-img');
            const editImgBtn = document.getElementById('edit-img-btn');

            // Cuando el botón de edición de imagen es clickeado, simulamos un clic en el input de la imagen.
            editImgBtn.addEventListener('click', function() {
                imgInput.click();
            });

            // Cuando se selecciona una imagen, actualizamos la imagen de perfil.
            imgInput.addEventListener('change', function() {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profileImg.src = e.target.result;
                    saveButton.style.display = 'block'; // Mostramos el botón de guardar
                }

                reader.readAsDataURL(this.files[0]);
            });

            function sendDataToServer(data) {
                $.ajax({
                    url: "actualizarPerfil", // Asegúrate de que la URL sea correcta
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(response) {
                        alert('Datos actualizados correctamente');
                        // Aquí puedes mostrar un mensaje de éxito, actualizar la vista, etc.
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al actualizar los datos:', error);
                        // Aquí puedes mostrar un mensaje de error
                    }
                });
            }


            save.addEventListener('click', function() {
                const data = {
                    nombre: document.getElementById('nombre').innerText,
                    apellido: document.getElementById('apellido').innerText,
                    phone: document.getElementById('phone').innerText,
                    bio: document.getElementById('bio').innerText,
                };

                sendDataToServer(data);
                saveButton.style.display = 'none'; // Ocultamos el botón de guardar
            });



            //SECTOR FALOPA
            function sendDataToServerImagen(data) {
    $.ajax({
        url: "actualizarImagen",
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        success: function(response) {
            alert('Datos actualizados correctamente');
        },
        error: function(xhr, status, error) {
            console.error('Error al actualizar los datos:', error);
        }
    });
}

document.getElementById('saveImage').addEventListener('click', function() {
    var input = document.getElementById('img-input');
    var file = input.files[0];

    if (file) {
        var formData = new FormData();
        formData.append('image', file);

        // Enviar el objeto FormData al servidor
        sendDataToServerImagen(formData);
    }
});

        </script>
        <!-- Incluimos el footer -->
        <?= view('template/footer') ?>