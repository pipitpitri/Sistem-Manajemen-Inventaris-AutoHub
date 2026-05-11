<?php
/** @var array $viewFile */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= e(asset('assets/css/style.css')) ?>" rel="stylesheet">
</head>
<body>
    <div class="app-shell">
        <button class="sidebar-backdrop" id="sidebarBackdrop" type="button" aria-label="Tutup menu"></button>
        <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        <main class="content-wrapper">
            <?php require __DIR__ . '/../partials/topbar.php'; ?>
            <div class="container-fluid py-4">
                <?php require __DIR__ . '/../partials/alerts.php'; ?>
                <?php require $viewFile; ?>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const body = document.body;
            const sidebar = document.querySelector('.sidebar');
            const openBtn = document.getElementById('sidebarToggle');
            const closeBtn = document.getElementById('sidebarBackdrop');

            const closeSidebar = () => {
                body.classList.remove('sidebar-open');
            };

            const toggleSidebar = () => {
                body.classList.toggle('sidebar-open');
            };

            if (openBtn) {
                openBtn.addEventListener('click', toggleSidebar);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeSidebar);
            }

            if (sidebar) {
                sidebar.querySelectorAll('a').forEach((link) => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth < 1200) {
                            closeSidebar();
                        }
                    });
                });
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1200) {
                    closeSidebar();
                }
            });
        })();
    </script>
</body>
</html>
