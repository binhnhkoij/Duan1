<?php

class AccountModel extends BaseModel
{
    public function getAll(int $limit, int $offset): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                User_id,
                name,
                email,
                phone_number,
                role
            FROM users
            ORDER BY User_id ASC
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $stmt->bindValue(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->pdo
            ->query("SELECT COUNT(*) FROM users")
            ->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                User_id,
                name,
                email,
                phone_number,
                role
            FROM users
            WHERE User_id = ?
        ");

        $stmt->execute([$id]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function update(
        int $id,
        string $name,
        string $email,
        string $phoneNumber,
        string $role
    ): void {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET
                name = ?,
                email = ?,
                phone_number = ?,
                role = ?
            WHERE User_id = ?
        ");

        $stmt->execute([
            $name,
            $email,
            $phoneNumber,
            $role,
            $id
        ]);
    }

    public function resetPassword(
        int $id,
        string $password
    ): void {
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $this->pdo->prepare("
            UPDATE users
            SET password = ?
            WHERE User_id = ?
        ");

        $stmt->execute([
            $passwordHash,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM users
            WHERE User_id = ?
        ");

        $stmt->execute([$id]);
    }

    public function emailExists(
        string $email,
        int $ignoreId
    ): bool {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE email = ?
              AND User_id != ?
        ");

        $stmt->execute([
            $email,
            $ignoreId
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}