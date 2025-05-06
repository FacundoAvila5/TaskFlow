<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakFlow - Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            align-items: center;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            height: 45px;
            border-radius: 8px;
        }
        .btn-login {
            height: 45px;
            border-radius: 8px;
            font-weight: 600;
        }
        .brand-title {
            font-family: 'Pacifico', cursive;
            font-size: 2.5rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card login-card">
                    <div class="card-body p-4">
                        <h1 class="text-center brand-title mb-2">TaskFlow</h1>
                        <h3 class="text-center mb-3">Bienvenido de nuevo</h3>
                        
                        <?php if (session('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-3">
                                <?= session('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session('errors')): ?>
                            <?php foreach (session('errors') as $error): ?>
                                <div class="alert alert-danger alert-dismissible fade show mb-3">
                                    <?= $error ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <p class="text-center mb-4">¿No tienes una cuenta? <a href="<?= base_url('register') ?>" class="text-decoration-none fw-medium">Regístrate aquí</a></p>

                        <?= form_open('auth/login', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="user" value="<?= old('user') ?>" required>
                                <div class="invalid-feedback">Por favor ingresa un correo válido</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="pass" required>
                                <div class="invalid-feedback">Por favor ingresa tu contraseña</div>
                            </div>
                            <div class="mb-3 d-flex justify-content-end">
                                <a href="<?= base_url('password/reset') ?>" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                            </div>
                            <button type="submit" class="btn btn-primary btn-login w-100 mb-3">Iniciar sesión</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Validación del lado del cliente
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</body>
</html>