<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mis Tareas' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #2c3e50;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-family: 'Pacifico', cursive;
            font-size: 1.8rem;
            color: white !important;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 5px;
            padding: 8px 15px !important;
            border-radius: 5px;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #34495e;
            color: white !important;
        }
        .task-card {
            border-left: 4px solid #0d6efd;
            margin-bottom: 15px;
            border-radius: 0 8px 8px 0;
        }
        .high-priority {
            border-left-color: #dc3545;
        }
        .medium-priority {
            border-left-color: #ffc107;
        }
        .low-priority {
            border-left-color: #28a745;
        }
        .completed-task {
            opacity: 0.7;
            background-color: #f8f9fa;
        }
        .filter-section {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Mis Tareas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-list-task me-1"></i> Todas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-briefcase me-1"></i> Trabajo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-calendar-week me-1"></i> Esta semana
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <button class="btn btn-outline-light">
                        <i class="bi bi-plus"></i> Nueva Tarea
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>