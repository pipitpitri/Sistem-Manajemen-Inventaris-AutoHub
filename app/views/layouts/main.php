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
        // ACCORDION SIDEBAR
const accordionButtons = document.querySelectorAll('.sidebar-group-title');

accordionButtons.forEach((button) => {

    button.addEventListener('click', () => {

        const targetId = button.getAttribute('data-target');
        const submenu = document.getElementById(targetId);

        // toggle submenu
        submenu.classList.toggle('show');

        // toggle icon rotate
        button.classList.toggle('open');
    });

});
/* =========================
   LOGOUT CONFIRM
========================= */

const btnLogout = document.getElementById('btn-logout');
const logoutAlert = document.getElementById('logoutAlert');
const logoutOverlay = document.getElementById('logoutOverlay');
const cancelLogout = document.getElementById('cancelLogout');
const confirmLogout = document.getElementById('confirmLogout');

const openLogoutAlert = () => {
    logoutAlert.classList.add('show');
    logoutOverlay.classList.add('show');
};

const closeLogoutAlert = () => {
    logoutAlert.classList.remove('show');
    logoutOverlay.classList.remove('show');
};

if (btnLogout) {
    btnLogout.addEventListener('click', openLogoutAlert);
}

if (cancelLogout) {
    cancelLogout.addEventListener('click', closeLogoutAlert);
}

if (logoutOverlay) {
    logoutOverlay.addEventListener('click', closeLogoutAlert);
}

if (confirmLogout) {
    confirmLogout.addEventListener('click', () => {
        window.location.href = 'index.php?route=logout';
    });
}

/* =========================
   PAGE MODALS
========================= */

const openPageModal = (modal) => {
    if (!modal) {
        return;
    }

    document.querySelectorAll('.modal-page-overlay:not([hidden])').forEach((openModal) => {
        if (openModal !== modal) {
            openModal.hidden = true;
        }
    });

    modal.hidden = false;
    document.body.classList.add('app-modal-open');

    const firstField = modal.querySelector('input, select, textarea, button, a');
    if (firstField) {
        firstField.focus({ preventScroll: true });
    }
};

const closePageModal = (modal) => {
    if (!modal) {
        return;
    }

    modal.hidden = true;

    if (!document.querySelector('.modal-page-overlay:not([hidden])')) {
        document.body.classList.remove('app-modal-open');
    }
};

document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
        const modal = document.getElementById(trigger.dataset.modalTarget);

        if (!modal) {
            return;
        }

        event.preventDefault();
        openPageModal(modal);
    });
});

document.querySelectorAll('[data-modal-close]').forEach((trigger) => {
    trigger.addEventListener('click', (event) => {
        const modal = trigger.closest('.modal-page-overlay');

        if (!modal) {
            return;
        }

        event.preventDefault();
        closePageModal(modal);
    });
});

document.querySelectorAll('.modal-page-overlay').forEach((modal) => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closePageModal(modal);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    const modal = document.querySelector('.modal-page-overlay:not([hidden])');
    if (modal) {
        closePageModal(modal);
    }
});
    </script>
</body>
</html>
