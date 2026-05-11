<div class="topbar">
    <div class="topbar-title-group">
        <button class="sidebar-toggle-btn" id="sidebarToggle" type="button" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
        <h4 class="mb-1"><?= e($title ?? 'Dashboard') ?></h4>
    </div>
    <div class="user-pill">
        <i class="bi bi-person-circle"></i>
        <span><?= e((current_user()['role'] ?? 'tamu') === 'admin' ? 'Admin' : ((current_user()['role'] ?? 'tamu') === 'manager' ? 'Manajer' : 'Tamu')) ?></span>
    </div>
</div>
