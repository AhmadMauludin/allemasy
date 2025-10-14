<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Allemasy Welcome'); ?></title>

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Background foto sekolah */
        body {
            background: url('<?= base_url("assets/img/bg.jpg") ?>') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        /* Efek transparan dan blur */
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            color: #fff;
        }

        h4 {
            font-weight: 600;
        }

        label {
            color: #fff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: none;
            color: #fff;
        }

        .btn-primary {
            background: #c1b000ff;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #7d7d00ff;
        }

        .alert {
            background: rgba(255, 0, 0, 0.6);
            border: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="col-md-4">
        <div class="card p-4 shadow-lg">
            <div class="card-body">
                <h4 class="text-center mb-4">Login LMS</h4>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger text-center"><?= session('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('login/auth') ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>