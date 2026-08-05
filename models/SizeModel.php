<?php

class SizeModel extends BaseModel
{
    public function getAll(): array
    {
        return $this->pdo
            ->query("
                SELECT Size_id, Size_name
                FROM sizes
                ORDER BY Size_id DESC
            ")
            ->fetchAll();
    }

    public function create(string $name): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO sizes (Size_name)
            VALUES (?)
        ");

        $stmt->execute([$name]);
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE sizes
            SET Size_name = ?
            WHERE Size_id = ?
        ");

        $stmt->execute([$name, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM sizes
            WHERE Size_id = ?
        ");

        $stmt->execute([$id]);
    }
}