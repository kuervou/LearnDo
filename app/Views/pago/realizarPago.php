<!-- Incluimos el head -->
<?= view('template/head') ?>
<?php include('modalPago.php') ?>

<body>

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>


    <!-- Cuerpo de la página -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h2 class="card-title">Estás a punto de comprar el curso: </h2>

                        <form action="<?= base_url('/pagarCreditos') ?>" method="POST">
                            <?php if (isset($id_curso)) { ?>
                                <input type="hidden" class="form-control" id="course_id" name="id_curso" value="<?= $id_curso ?>" required>
                            <?php } else if (isset($id_seminario_virtual)) { ?>
                                <input type="hidden" class="form-control" id="id_seminario_virtual" name="id_seminario_virtual" value="<?= $id_seminario_virtual ?>" required>
                            <?php } else if (isset($id_seminario_presencial)) { ?>
                                <input type="hidden" class="form-control" id="id_seminario_presencial" name="id_seminario_presencial" value="<?= $id_seminario_presencial ?>" required>
                            <?php } 
                            if (isset($nick_estudiante)) { ?>
                                <input type="hidden" class="form-control" id="nick_estudiante" name="nick_estudiante" value="<?= $nick_estudiante ?>" required>
                            <?php }?>
                            <div class="text-center mt-4 d-flex justify-content-center">
                                <button type="button" class="btn btn-primary d-flex align-items-center" onclick="submit()">
                                    <span class="material-symbols-outlined  mr-2">
                                        savings
                                    </span>Utilizar Creditos</button>
                            </div>

                        </form>


                        <div class="text-center mt-4 d-flex justify-content-center">
                            <?php
                            if (isset($id_curso)) {
                                $tipoPrograma = "curso";
                                $idPrograma = $id_curso;
                            } else if (isset($id_seminario_virtual)) {
                                $tipoPrograma = "virtual";
                                $idPrograma = $id_seminario_virtual;
                            } else if (isset($id_seminario_presencial)) {
                                $tipoPrograma = "presencial";
                                $idPrograma = $id_seminario_presencial;
                            }
                            ?>
                            <a class=" btn btn-primary d-flex align-items-center " href="<?= base_url("PaypalController/payWithPaypal?tipoPrograma=" . $tipoPrograma . "&idPrograma=" . $idPrograma . "&nick_estudiante=" . $nick_estudiante) ?>"><span class="material-symbols-outlined  mr-2">
                                    payments
                                </span>
                                Pagar con PayPal
                            </a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluimos el footer -->
    <?= view('template/footer') ?>