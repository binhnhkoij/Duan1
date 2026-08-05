<?php

class UserModel extends BaseModel
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT User_id, name, email, password, role FROM users WHERE email = ? LIMIT 1'
        );
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT User_id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function create(string $name, string $email, string $password, string $phone): void
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password, phone_number, role)
             VALUES (?, ?, ?, ?, 'user')"
        );
        $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $phone]);
    }
}
