<?php

class CategoryModel extends BaseModel
{
    public function getAll(): array
    {
        return $this->pdo
            ->query("
                SELECT Category_id, Category_name
                FROM categories
                ORDER BY Category_id DESC
            ")
            ->fetchAll();
    }

    public function create(string $name): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO categories (Category_name)
            VALUES (?)
        ");

        $stmt->execute([$name]);
    }

    public function update(int $id, string $name): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE categories
            SET Category_name = ?
            WHERE Category_id = ?
        ");

        $stmt->execute([$name, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM categories
            WHERE Category_id = ?
        ");

        $stmt->execute([$id]);
    }
}