<!-- Incluimos el head -->
<?= view('template/head') ?>

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
    0% {background-size: 100%;}
    50% {background-size: 110%;}
    100% {background-size: 100%;}
}
@keyframes scroll {
  0% { background-position: 0 30; }
  100% { background-position: 0 169px; }
}
    .banner {
        padding: 50px;
        color: white;
        text-align: center;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        height: 100%;
    }

  


    .banner.login {
        background-image: url('<?php echo base_url("public/assets/images/template/miCurso.svg") ?>');
        animation: zoom 25s infinite;
    }

    

    .glass-container {
        background: rgba( 255, 255, 255, 0.10 );
        box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
        backdrop-filter: blur( 3px );
        border-radius: 10px;
        border: 1px solid rgba( 255, 255, 255, 0.18 );
        padding: 20px;
    }
</style>
<body>

   
<!-- Banner de bienvenida -->
<section class="py-5">
    <div class="container banner login">
        <div class="glass-container">
            <h2 class="mb-4">¡Ups!</h2>
            <p>Parece que no tienes permiso para acceder a este lugar.</p>
            <p>Si crees que esto es un error, por favor contacta con el administrador.</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary">Inicio</a>
        </div>
    </div>
</section>

