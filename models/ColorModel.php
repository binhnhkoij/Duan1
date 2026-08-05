<?php

class ColorModel extends BaseModel
{
    public function getAll(): array
    {
        return $this->pdo
            ->query("
                SELECT Color_id, Color_name
                FROM colors
                ORDER BY Color_id DESC
            ")
            ->fetchAll();
    }

    public function create(string $name): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO colors (Color_name)
            VALUES (?)
        ");

        $stmt->execute([$name]);
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE colors
            SET Color_name = ?
            WHERE Color_id = ?
        ");

        $stmt->execute([$name, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM colors
            WHERE Color_id = ?
        ");

        $stmt->execute([$id]);
    }
}