<?php

class AuthController extends BaseController
{
    public function showLogin(): void
    {
        if (is_logged_in()) {
            redirect('dashboard');
        }

        $this->render('auth/login', ['title' => 'Login'], 'auth');
    }

    public function index(): void
    {
        if (!is_post()) {
            redirect('login');
        }

        $userModel = new User();
        $user = $userModel->findByUsername(trim($_POST['username'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (!$user || !password_verify($password, $user['password'])) {
            flash('error', 'Username atau password salah.');
            set_old(['username' => $_POST['username'] ?? '']);
            redirect('login');
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'username' => $user['username'],
            'role' => $user['role'],
        ];

        clear_old();
        flash('success', 'Login berhasil. Selamat datang di sistem inventori.');
        redirect('dashboard');
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        session_start();
        flash('success', 'Anda telah logout dari sistem.');
        redirect('login');
    }
}
