<?php

function route(string $path = ''): string
{
    $path = trim($path, '/');
    return 'index.php' . ($path !== '' ? '?route=' . $path : '');
}

function current_route(): string
{
    return trim($_GET['route'] ?? '', '/');
}

function route_is(string $path): bool
{
    return current_route() === trim($path, '/');
}

function route_starts_with(string $path): bool
{
    $current = current_route();
    $path = trim($path, '/');
    return $current === $path || str_starts_with($current, $path . '/');
}

function asset(string $path): string
{
    return 'public/' . ltrim($path, '/');
}

function redirect(string $path = ''): void
{
    header('Location: ' . route($path));
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function old(string $key, string $default = ''): string
{
    return $_SESSION['old'][$key] ?? $default;
}

function set_old(array $data): void
{
    $_SESSION['old'] = $data;
}

function clear_old(): void
{
    unset($_SESSION['old']);
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $message;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    return is_logged_in() && current_user()['role'] === 'admin';
}

function format_currency($amount): string
{
    return 'Rp ' . number_format((float) $amount, 0, ',', '.');
}

function format_date(?string $date): string
{
    if (!$date) {
        return '-';
    }

    return date('d M Y', strtotime($date));
}

function selected($value, $expected): string
{
    return (string) $value === (string) $expected ? 'selected' : '';
}

function months_list(): array
{
    return [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
}
