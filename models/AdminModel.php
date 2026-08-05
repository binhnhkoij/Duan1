<?php

class AdminModel extends BaseModel
{
    public function countTable(string $table): int
    {
        $allowed = [
            'users',
            'products',
            'orders',
            'categories',
            'colors',
            'sizes'
        ];

        if (!in_array($table, $allowed, true)) {
            return 0;
        }

        return (int) $this->pdo
            ->query("SELECT COUNT(*) FROM `$table`")
            ->fetchColumn();
    }
}