<!-- Incluimos el head -->
<?= view('template/head') ?>

<body>
    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>
       <!-- Contenido principal -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h1 class="card-title">¡Éxito!</h1>
                        <p class="card-text">Acabas de realizar el primer paso hacia un nuevo nivel de crecimiento personal .</p>
                        <p class="card-text">¡Ya puedes comenzar a aprender!</p>
                        <?php
                            if($tipoPrograma == "curso"){
                                $url = base_url('consultarCurso/?'.$tipoId.'='.$idPrograma);
                            }else{ if($tipoPrograma == "virtual"){
                                $url = base_url('consultarSeminario/?id_seminario='.$idPrograma.'&tipo=virtual');
                            }else{
                                $url = base_url('consultarSeminario/?id_seminario='.$idPrograma.'&tipo=presencial');
                                } 
                            }
                        ?>
                        <a href="<?= $url ?>" class="btn btn-primary">Ir al Programa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>