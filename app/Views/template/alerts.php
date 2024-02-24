<!-- Detectar errores -->

<?php 
if(session()->has('errores')):
    foreach(session('errores') as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show alerta-error " role="alert">
            <strong>Error!</strong> <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php    endforeach; ?>
    <?php session()->setFlashdata('errores', null); ?>
<?php endif; ?>

<!-- Detectar mensajes -->

<?php 
if(session()->has('mensajes')):
    foreach(session('mensajes') as $mensaje): ?>
        <div class="alert alert-success alert-dismissible fade show alerta-exito " role="alert">
            <strong>Nashe!</strong> <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php    endforeach; ?>
    <?php session()->setFlashdata('mensajes', null); ?>
<?php endif; ?>            