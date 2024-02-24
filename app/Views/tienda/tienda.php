<!-- Incluimos el head -->
<?= view('template/head') ?>

<!-- Incluimos el header -->
<?= view('template/header') ?>

<!-- Incluimos los alerts -->
<?= view('template/alerts') ?>
<div class="container">
<div class="jumbotron text-center bg-transparent custom-jumbotron text-white py-5">
  <h1 class="display-4 text-center text-white">Cursos y seminarios</h1>
  
</div>

  <?php if (count($cursos) > 0) { ?>

    <h2 class="text-center text-white">Cursos</h2>

  <?php };

  
    $urlImage = base_url('public/assets/images/template/curso.svg'); ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php foreach ($cursos as $curso) : ?>
      <div class="col">
        <div class="card shadow-sm">
          <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
          <div class="card-body">
            <p class="card-text"> <?php echo $curso["nombre"]; ?> </p>
            <p class="card-text"> <?php echo $curso["descripcion"]; ?> </p>
            <p class="card-text"> <?php echo $curso["precio"]; ?> US$  </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a href=" <?= base_url('consultarCurso?id_curso=' . $curso['id_curso'])  ?>" class="btn btn-primary">Ver detalles</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  

  <?php if (count($seminariosV) > 0) { ?>

    <h2 class="text-center text-white">Seminarios Virtuales</h2>

  <?php }; ?>

  
  <?php $urlImage = base_url('public/assets/images/template/virtual.svg'); ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php foreach ($seminariosV as $seminarioV) : ?>
      <div class="col">
        <div class="card shadow-sm">
          <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
          <div class="card-body">
            <p class="card-text"> <?php echo $seminarioV["nombre"]; ?> </p>
            <p class="card-text"> <?php echo $seminarioV["descripcion"]; ?> </p>
            <p class="card-text"> <?php echo $seminarioV["precio"]; ?> US$  </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a href=" <?= base_url('consultarSeminario/?id_seminario=' . $seminarioV['id_seminario_virtual'].'&tipo=virtual')  ?>" class="btn btn-primary">Ver detalles</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  

  <?php if (count($seminariosP) > 0) { ?>

    <h2 class="text-center text-white">Seminarios Presenciales</h2>

  <?php };

  
    $urlImage = base_url('public/assets/images/template/presencial.svg'); ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
     <?php foreach ($seminariosP as $seminarioP) : ?>
      <div class="col">
        <div class="card shadow-sm">
          <img src="<?php echo $urlImage; ?>" class="card-img-top course-card-img" alt="Curso 1">
          <div class="card-body">
            <p class="card-text"> <?php echo $seminarioP["nombre"]; ?> </p>
            <p class="card-text"> <?php echo $seminarioP["descripcion"]; ?> </p>
            <p class="card-text"> <?php echo $seminarioP["precio"]; ?> US$ </p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a href=" <?= base_url('consultarSeminario/?id_seminario=' . $seminarioP['id_seminario_presencial'].'&tipo=presencial')  ?>" class="btn btn-primary">Ver detalles</a>
                <a  class="btn btn-custom">Cupos disponibles: <?php echo $seminarioP["capacidad"]; ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  


  <!-- Incluimos el footer -->
  <?= view('template/footer') ?>