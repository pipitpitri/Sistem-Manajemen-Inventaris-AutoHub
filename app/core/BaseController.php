<?php

class BaseController
{
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $view . '.php';
        $layoutFile = __DIR__ . '/../views/layouts/' . $layout . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException('View not found: ' . $view);
        }

        require $layoutFile;
    }

    protected function authRequired(): void
    {
        if (!is_logged_in()) {
            flash('error', 'Silakan login terlebih dahulu.');
            redirect('login');
        }
    }

    protected function adminRequired(): void
    {
        $this->authRequired();

        if (!is_admin()) {
            flash('error', 'Akses dibatasi hanya untuk Admin.');
            redirect('dashboard');
        }
    }
}
