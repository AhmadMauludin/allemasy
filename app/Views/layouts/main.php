<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'LMS App'); ?></title>

    <!-- Bootstrap CSS Lokal -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 180px;
            background-color: #0d6efd;
            color: white;
            transition: width 0.3s;
            position: relative;
        }

        .sidebar.collapsed {
            width: 45px;
        }

        .sidebar .nav-link {
            color: white;
            display: flex;
            align-items: center;
            padding: 10px 15px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .content {
            flex-grow: 1;
            padding: 10px;
            background-color: #f8f9fa;
        }

        /* Header sidebar */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar.collapsed .sidebar-header span {
            display: none;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.4rem;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        /* Font Apple */
        @font-face {
            font-family: "SF Pro";
            src: url("<?= base_url('assets/fonts/SF-Pro-Display-Regular.otf') ?>") format("opentype");
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: "SF Pro", -apple-system, BlinkMacSystemFont, "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <button class="toggle-btn" id="toggleSidebarBtn">
                <i class="bi bi-list"></i>
            </button>
            <span class="fw-bold">ALMALEARNSY</span>
        </div>

        <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
    </div>

    <!-- Main Content -->
    <div class="content">
        <?= $this->renderSection('content') ?>
        <footer class="text-center py-3 mt-5 border-top">
            <small>© <?= date('Y') ?> Maldin</small>
        </footer>
    </div>

    <!-- Bootstrap JS Lokal -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');

        // Saat pertama kali load, buka sidebar (default) kecuali user sudah pernah tutup sebelumnya
        const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
        }

        // Event toggle
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        });
    </script>
</body>

</html>