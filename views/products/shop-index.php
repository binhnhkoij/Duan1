<?php
$products = $products ?? [];
?>

<style>
.shop-page {
    max-width: 1200px;
    margin: auto;
    padding: 50px 20px;
}

.shop-title {
    margin-bottom: 30px;
    text-align: center;
    font-weight: 700;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.product-card {
    padding: 15px;
    color: #222;
    text-decoration: none;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, .08);
    transition: .25s;
}

.product-card:hover {
    color: #222;
    transform: translateY(-5px);
}

.product-card img {
    width: 100%;
    height: 220px;
    object-fit: contain;
}

.product-name {
    margin: 12px 0 5px;
    font-size: 17px;
    font-weight: 700;
}

.product-category {
    margin-bottom: 8px;
    color: #777;
}

.product-price {
    color: #dc003c;
    font-size: 18px;
    font-weight: 700;
}

@media (max-width: 900px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 550px) {
    .product-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<section class="shop-page">

    <h2 class="shop-title">
        Danh sách sản phẩm
    </h2>

    <div class="product-grid">

        <?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>
                <?php
                $productId = (int) ($product['Product_id'] ?? 0);
                $productName = $product['Product_name'] ?? '';
                $categoryName = $product['Category_name'] ?? '';
                $baseImage = $product['Base_image'] ?? '';
                $price = $product['Min_price'] ?? null;
                ?>

                <a
                    class="product-card"
                    href="<?= BASE_URL ?>?action=product-detail&id=<?= $productId ?>"
                >
                    <img
                        src="<?= BASE_ASSETS_UPLOADS . htmlspecialchars(
                            $baseImage,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $productName,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                    <div class="product-name">
                        <?= htmlspecialchars(
                            $productName,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </div>

                    <div class="product-category">
                        <?= htmlspecialchars(
                            $categoryName,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </div>

                    <div class="product-price">
                        <?= $price !== null
                            ? number_format(
                                (float) $price,
                                0,
                                ',',
                                '.'
                            ) . '₫'
                            : 'Liên hệ'
                        ?>
                    </div>
                </a>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="text-muted">
                Danh mục này chưa có sản phẩm.
            </p>

        <?php endif; ?>

    </div>

</section>