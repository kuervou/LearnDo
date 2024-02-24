<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">¡Hola!</h1>
                        <p class="card-text">Te han invitado a colaborar en el curso <?php echo $curso[0]['nombre']; ?>.</p>
                        <p class="card-text">¡Acepta o rechaza esta propuesta aquí!</p>
                        <form method="POST" action="<?= base_url('/aceptarInvitacion') ?>">
                            <input type="hidden" class="form-control" name="nick" value="<?= $user ?>" required>
                            <input type="hidden" class="form-control" name="id_curso" value="<?= $curso[0]['id_curso'] ?>" required>
                            <button type="submit" class="btn btn-primary">Aceptar</button>
                        </form>
                            <button type="submit" class="btn btn-primary mt-2" href="<?php echo base_url('/'); ?>">Rechazar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>