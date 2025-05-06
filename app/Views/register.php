<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | TaskFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            align-items: center;
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
        }
        .input-group-text {
            cursor: pointer;
        }
        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }
            .card {
                width: 100%;
            }
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
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h1 class="text-center brand-title mb-2">TaskFlow</h1>
                        <h4 class="text-center mb-3">Crear una cuenta</h4>
                        
                        <p class="text-center mb-4">¿Ya tienes una cuenta? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a></p>

                        <?php if (session('success')): ?>
                            <div class="alert alert-success"><?= session('success') ?></div>
                        <?php endif; ?>

                        <?= form_open('form/register') ?>
                            <div class="row">
                                <!-- Nombre -->
                                <div class="col-md-12 mb-3">
                                    <?= form_label('Nombre', 'nombre', ['class' => 'form-label']) ?>
                                    <?= form_input([
                                        'name' => 'nombre',
                                        'id' => 'nombre',
                                        'class' => 'form-control ' . (session('errors.nombre') ? 'is-invalid' : ''),
                                        'value' => old('nombre')
                                    ]) ?>
                                    <?php if (session('errors.nombre')): ?>
                                        <div class="invalid-feedback"><?= session('errors.nombre') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Correo electrónico -->
                            <div class="mb-3">
                                <?= form_label('Correo electrónico', 'email', ['class' => 'form-label']) ?>
                                <?= form_input([
                                    'name' => 'email',
                                    'type' => 'email',
                                    'class' => 'form-control ' . (session('errors.email') ? 'is-invalid' : ''),
                                    'value' => old('email')
                                ]) ?>
                                <?php if (session('errors.email')): ?>
                                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                                <?php endif; ?>
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-3">
                                <?= form_label('Contraseña (mínimo 8 caracteres)', 'password', ['class' => 'form-label']) ?>
                                <div class="input-group">
                                    <?= form_password([
                                        'name' => 'password',
                                        'id' => 'password',
                                        'class' => 'form-control ' . (session('errors.password') ? 'is-invalid' : '')
                                    ]) ?>
                                    <button class="btn btn-secondary" type="button" onclick="togglePassword('password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (session('errors.password')): ?>
                                        <div class="invalid-feedback"><?= session('errors.password') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="mb-3">
                                <?= form_label('Confirmar Contraseña', 'password_confirm', ['class' => 'form-label']) ?>
                                <div class="input-group">
                                    <?= form_password([
                                        'name' => 'password_confirm',
                                        'id' => 'password_confirm',
                                        'class' => 'form-control ' . (session('errors.password_confirm') ? 'is-invalid' : '')
                                    ]) ?>
                                    <button class="btn btn-secondary" type="button" onclick="togglePassword('password_confirm', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if (session('errors.password_confirm')): ?>
                                        <div class="invalid-feedback"><?= session('errors.password_confirm') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <?= form_submit('submit', 'Registrarse', ['class' => 'btn btn-primary py-2']) ?>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword(id, button) {
        const input = document.getElementById(id);
        const icon = button.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>