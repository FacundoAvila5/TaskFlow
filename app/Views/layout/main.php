<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mis Tareas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg  navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url('/index') ?>"><h1 class="text-center brand-title">TaskFlow</h1></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link bg-black" href="<?= site_url('/archivadas') ?>">
                            <i class="bi bi-list-task me-1"></i> Archivadas
                        </a>
                    </li>
                </ul>
                  <div class="d-flex align-items-center">
                    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#createTask">
                        <i class="bi bi-plus"></i> Nueva Tarea
                    </button>
                    
                    <div class="dropdown">
                        <button class="btn btn-outline-light bg-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li class="text-center">
                                <span class="dropdown-header fw-bold text-primary ">
                                    <?= session()->get('nombre') ?? 'Usuario' ?>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cambiarContrasenia">
                                    <i class="bi bi-key me-2"></i> Cambiar Contraseña
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= site_url('auth/logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <?= $this->renderSection('content') ?>
        <?= view('actualizarContrasenia') ?>
    </div>

    <?= $this->renderSection('modals') ?>
    <?= view('createTask') ?>
    
    
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('hidden.bs.modal', function () {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());

            document.body.classList.remove('modal-open');
            document.body.style = ''; 
        });
    </script>

</body>
</html>