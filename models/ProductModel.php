<?php

class ProductModel extends BaseModel
{
    public function latest(int $limit = 8): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                p.Product_id,
                p.Product_name,
                p.Description,
                p.Base_image,
                MIN(pv.Price) AS Min_price,
                COALESCE(SUM(pv.Stock), 0) AS Total_stock
            FROM products p
            LEFT JOIN product_variants pv
                ON p.Product_id = pv.Product_id
            WHERE p.Status = 1
            GROUP BY
                p.Product_id,
                p.Product_name,
                p.Description,
                p.Base_image
            ORDER BY p.Product_id DESC
            LIMIT :limit
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                p.Product_id,
                p.Category_id,
                p.Product_name,
                p.Description,
                p.Base_image,
                p.Status,
                c.Category_name,
                MIN(pv.Price) AS Min_price,
                COALESCE(SUM(pv.Stock), 0) AS Total_stock
            FROM products p
            LEFT JOIN categories c
                ON p.Category_id = c.Category_id
            LEFT JOIN product_variants pv
                ON p.Product_id = pv.Product_id
            GROUP BY
                p.Product_id,
                p.Category_id,
                p.Product_name,
                p.Description,
                p.Base_image,
                p.Status,
                c.Category_name
            ORDER BY p.Product_id DESC
        ";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function getByCategory(int $categoryId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                p.Product_id,
                p.Category_id,
                p.Product_name,
                p.Description,
                p.Base_image,
                p.Status,
                c.Category_name,
                MIN(pv.Price) AS Min_price,
                COALESCE(SUM(pv.Stock), 0) AS Total_stock
            FROM products p
            LEFT JOIN categories c
                ON p.Category_id = c.Category_id
            LEFT JOIN product_variants pv
                ON p.Product_id = pv.Product_id
            WHERE p.Category_id = ?
            GROUP BY
                p.Product_id,
                p.Category_id,
                p.Product_name,
                p.Description,
                p.Base_image,
                p.Status,
                c.Category_name
            ORDER BY p.Product_id DESC
        ");

        $stmt->execute([$categoryId]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                p.*,
                c.Category_name
            FROM products p
            LEFT JOIN categories c
                ON p.Category_id = c.Category_id
            WHERE p.Product_id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public function variants(int $productId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                pv.*,
                s.Size_name,
                c.Color_name
            FROM product_variants pv
            JOIN sizes s
                ON pv.Size_id = s.Size_id
            JOIN colors c
                ON pv.Color_id = c.Color_id
            WHERE pv.Product_id = ?
            ORDER BY c.Color_name, s.Size_name
        ");

        $stmt->execute([$productId]);

        return $stmt->fetchAll();
    }

    public function related(
        int $categoryId,
        int $productId
    ): array {
        $stmt = $this->pdo->prepare("
            SELECT
                p.Product_id,
                p.Product_name,
                p.Base_image,
                MIN(pv.Price) AS Min_price
            FROM products p
            LEFT JOIN product_variants pv
                ON p.Product_id = pv.Product_id
            WHERE p.Category_id = ?
              AND p.Product_id != ?
              AND p.Status = 1
            GROUP BY
                p.Product_id,
                p.Product_name,
                p.Base_image
            ORDER BY p.Product_id DESC
            LIMIT 4
        ");

        $stmt->execute([
            $categoryId,
            $productId
        ]);

        return $stmt->fetchAll();
    }

    public function getCategories(): array
    {
        return $this->pdo
            ->query("
                SELECT Category_id, Category_name
                FROM categories
                ORDER BY Category_name ASC
            ")
            ->fetchAll();
    }

    public function getSizes(): array
    {
        return $this->pdo
            ->query("
                SELECT Size_id, Size_name
                FROM sizes
                ORDER BY Size_name ASC
            ")
            ->fetchAll();
    }

    public function getColors(): array
    {
        return $this->pdo
            ->query("
                SELECT Color_id, Color_name
                FROM colors
                ORDER BY Color_name ASC
            ")
            ->fetchAll();
    }

    public function createWithVariants(
        array $product,
        array $variants
    ): void {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO products (
                    Category_id,
                    Product_name,
                    Description,
                    Base_image,
                    Status
                )
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $product['category_id'],
                $product['product_name'],
                $product['description'],
                $product['base_image'],
                $product['status']
            ]);

            $productId = (int) $this->pdo->lastInsertId();

            $variantStmt = $this->pdo->prepare("
                INSERT INTO product_variants (
                    Product_id,
                    Size_id,
                    Color_id,
                    Price,
                    Stock
                )
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($variants as $variant) {
                $variantStmt->execute([
                    $productId,
                    $variant['size_id'],
                    $variant['color_id'],
                    $variant['price'],
                    $variant['stock']
                ]);
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function updateWithVariants(
        int $productId,
        array $product,
        array $variants
    ): void {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("
                UPDATE products
                SET
                    Category_id = ?,
                    Product_name = ?,
                    Description = ?,
                    Base_image = ?,
                    Status = ?
                WHERE Product_id = ?
            ");

            $stmt->execute([
                $product['category_id'],
                $product['product_name'],
                $product['description'],
                $product['base_image'],
                $product['status'],
                $productId
            ]);

            $stmt = $this->pdo->prepare("
                DELETE FROM product_variants
                WHERE Product_id = ?
            ");

            $stmt->execute([$productId]);

            $variantStmt = $this->pdo->prepare("
                INSERT INTO product_variants (
                    Product_id,
                    Size_id,
                    Color_id,
                    Price,
                    Stock
                )
                VALUES (?, ?, ?, ?, ?)
            ");

            foreach ($variants as $variant) {
                $variantStmt->execute([
                    $productId,
                    $variant['size_id'],
                    $variant['color_id'],
                    $variant['price'],
                    $variant['stock']
                ]);
            }

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function deleteProduct(int $id): void
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM product_variants
                WHERE Product_id = ?
            ");

            $stmt->execute([$id]);

            $stmt = $this->pdo->prepare("
                DELETE FROM products
                WHERE Product_id = ?
            ");

            $stmt->execute([$id]);

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}