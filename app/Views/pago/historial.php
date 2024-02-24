<!-- Incluimos el head -->
<?= view('template/head') ?>

<body class="fullHeight">

    <!-- Incluimos el header -->
    <?= view('template/header') ?>

    <!-- Incluimos los alerts -->
    <?= view('template/alerts') ?>

   <!-- Cuerpo de la página -->
   <div class="container">

   <h2 class="my-4 text-white" >Mis Compras</h2>
        <div class="row">
        <?php if(isset($cursos)){
            foreach($cursos as $curso): ?>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="public/assets/images/Logo.png" class="card-img-top course-card-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $curso['nombre'];?></h5>
                        <p class="card-text"><?php echo $curso['descripcion'];?></p>
                        <p class="card-text">Precio:<?php echo $curso['precio'];?></p>
                        <p class="card-text">Metodo de pago: <?php echo $curso['metodo_pago'];?></p>
                        <a href=" <?= base_url('consultarCurso?id_curso='.$curso['id_curso'])  ?>" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <?php endforeach; 
            }
            if(isset($seminariosV)){ ?>
            <?php foreach($seminariosV as $seminarioV): ?>
                <div class="col-md-4">
                    <div class="card course-card">
                        <img src="public/assets/images/Logo.png" class="card-img-top course-card-img" alt="Curso 1">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $seminarioV['nombre'];?></h5>
                            <p class="card-text"><?php echo $seminarioV['descripcion'];?></p>
                            <p class="card-text">Precio: <?php echo $seminarioV['precio'];?></p>
                            <p class="card-text">Metodo de pago: <?php echo $seminarioV['metodo_pago'];?></p>
                            <a href=" <?= base_url('consultarSeminario/?id_seminario='.$seminarioV['id_seminario_virtual'])  ?>" class="btn btn-primary">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; 
            }
            if(isset($seminariosP)){ 
            foreach($seminariosP as $seminarioP): ?>
            <div class="col-md-4">
                <div class="card course-card">
                    <img src="public/assets/images/Logo.png" class="card-img-top course-card-img" alt="Curso 1">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $seminarioP['nombre'];?></h5>
                        <p class="card-text"><?php echo $seminarioP['descripcion'];?></p>
                        <p class="card-text">Precio: <?php echo $seminarioP['precio'];?></p>
                        <p class="card-text">Metodo de pago: <?php echo $seminarioP['metodo_pago'];?></p>
                        <a href=" <?= base_url('consultarSeminario/?id_seminario='.$seminarioP['id_seminario_presencial'])  ?>" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php } ?>      
    </div>

<!-- Incluimos el footer -->
<?= view('template/footer') ?>