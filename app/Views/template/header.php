<nav class="navbar custom-navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url('/'); ?>">
      LearnDo
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/'); ?>">Inicio</a>
        </li>
        
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/listarCursos'); ?>">Mis Cursos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/listarSeminarios'); ?>">Mis Seminarios</a>
          </li>
        
        <?php if(session('tipoUser') == 'organizador' || session('tipoUser') == 'estudiante'){ ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/listarUsuarios'); ?>">Usuarios</a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/tienda'); ?>">Tienda</a>
        </li>
        <?php if(session('tipoUser') == 'organizador' || session('tipoUser') == 'estudiante'){ ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('/muro'); ?>"><b>Feed</b></a>
          </li>
        <?php } ?>
        <?php if(session('tipoUser') == 'organizador'){ ?>
          <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('/estadisticas'); ?>">Estadísticas</a>
        </li>
        <?php } ?>
      </ul>
      <?php if(session()->has('usuario')): ?>
        <li class="nav-item dropdown align-items-flex-start">
          <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo base_url(session()->get('ruta_multimedia'));?>" alt="Imagen de perfil" style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%; margin-right: 8px;"> 
            Hola, <?= session()->get('usuario')?>
          </a>
          <ul class="dropdown-menu align-items-center text-white" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="<?php echo base_url('profile/?nick_usuario='.session()->get('usuario').'&tipo='.session()->get('tipoUser'));?>">Configuración de la cuenta</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?php echo base_url('/logout'); ?>">Cerrar Sesión</a></li>
          </ul>
        </li>



      <?php else: ?>

            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('/login'); ?>"><b>Iniciar sesión</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php  echo base_url('/register'); ?>"><b>Registrarse</b></a>
            </li>
            </ul>

        <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Nuevo navbar con búsqueda y categorías -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark my-0 py-0">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#searchAndCategoriesNavbar" aria-controls="searchAndCategoriesNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="searchAndCategoriesNavbar">
                <div class="input-group my-1">
                  <form id="buscar-form" method="POST" action="<?= base_url('/buscar') ?>">
                    <input type="text" class="py-2 rounded" placeholder="Buscar cursos y seminarios..."
                           aria-label="Buscar cursos y seminarios" aria-describedby="search-btn" name="busqueda">
                    <button class="btn btn-secondary mb-1" type="submit" id="search-btn">Buscar</button>
                  </form>
                </div>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            Categorías destacadas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <?php $categorias = session('categorias');
                            foreach($categorias as $categoria): ?>
                              <li><a class="dropdown-item" href="<?php echo base_url('/buscarXCategoria?nombreCategoria='.$categoria['nombre']); ?>"><?php echo $categoria['nombre'];?></a></li>                            <!-- Agrega más categorías aquí -->
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
