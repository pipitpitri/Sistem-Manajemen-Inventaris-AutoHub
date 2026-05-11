<?php

class Seeder
{
    public static function run(): void
    {
        static $hasRun = false;

        if ($hasRun) {
            return;
        }

        $hasRun = true;

        try {
            $db = Database::getInstance();
            $stmt = $db->query('SELECT COUNT(*) AS total FROM users');
            $count = (int) $stmt->fetch()['total'];

            if ($count > 0) {
                return;
            }

            $insert = $db->prepare(
                'INSERT INTO users (name, username, password, role) VALUES (:name, :username, :password, :role)'
            );

            foreach ([
                ['Administrator', 'admin', 'admin123', 'admin'],
                ['Inventory Manager', 'manager', 'manager123', 'manager'],
            ] as [$name, $username, $password, $role]) {
                $insert->execute([
                    'name' => $name,
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role,
                ]);
            }
        } catch (Throwable $exception) {
            // Silent by design.
        }
    }
}
