<style>
.banner-wrapper {
    max-width: 1400px;
    margin: 24px auto 50px;
    padding: 0 12px;
}

#mainCarousel {
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.16);
}

#mainCarousel .carousel-inner,
#mainCarousel .carousel-item {
    height: 280px;
}

.banner-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #000;
}

.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 30px;
    font-size: 1.65rem;
    font-weight: 700;
    text-transform: uppercase;
}

.section-title::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 70px;
    height: 4px;
    border-radius: 10px;
    background: linear-gradient(90deg,#ffc107,#ff7b00);
}

.category-card,
.product-card {
    height: 100%;
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    transition: .3s;
}

.category-card:hover,
.product-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 12px 28px rgba(0,0,0,.14) !important;
}

.category-image-box,
.product-image-box {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f7f7f7;
    overflow: hidden;
}

.category-image-box {
    height: 220px;
    padding: 20px;
}

.product-image-box {
    height: 250px;
    padding: 12px;
}

.category-image-box img,
.product-image-box img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: .35s;
}

.product-card:hover .product-image-box img {
    transform: scale(1.05);
}

.product-name {
    min-height: 48px;
    font-weight: 600;
}

.product-price {
    color: #dc3545;
    font-size: 1.15rem;
    font-weight: 700;
}

.btn-view-product {
    padding: 9px 16px;
    border-radius: 10px;
    font-weight: 600;
}

@media (max-width: 768px) {
    #mainCarousel .carousel-inner,
    #mainCarousel .carousel-item {
        height: 190px;
    }

    .category-image-box {
        height: 180px;
    }

    .product-image-box {
        height: 220px;
    }
}

@media (max-width: 576px) {
    #mainCarousel .carousel-inner,
    #mainCarousel .carousel-item {
        height: 150px;
    }
}
</style>

<!-- Banner -->
<div class="banner-wrapper">
    <div
        id="mainCarousel"
        class="carousel slide"
        data-bs-ride="carousel"
        data-bs-interval="4000"
    >
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel"
                    data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel"
                    data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel"
                    data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img
                    src="<?= BASE_URL ?>assets/images/banner.jpg"
                    class="banner-img"
                    alt="Banner 1"
                >
            </div>

            <div class="carousel-item">
                <img
                    src="<?= BASE_URL ?>assets/images/banner2.jpg"
                    class="banner-img"
                    alt="Banner 2"
                >
            </div>

            <div class="carousel-item">
                <img
                    src="<?= BASE_URL ?>assets/images/banner3.jpg"
                    class="banner-img"
                    alt="Banner 3"
                >
            </div>
        </div>

        <button class="carousel-control-prev" type="button"
                data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button"
                data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>

<!-- Danh mục -->
<section class="container mb-5">
    <h3 class="section-title">Danh mục nổi bật</h3>

    <div class="row g-4 text-center">
        <?php
        $categories = [
            [1, 'Giày nam', 'giay.png'],
            [2, 'Giày nữ', 'giay2.png'],
            [3, 'Giày thể thao', 'giay3.png'],
            [4, 'Dép thời trang', 'dep.png']
        ];
        ?>

        <?php foreach ($categories as $category): ?>
            <div class="col-lg-3 col-md-6">
                <a
                    href="<?= BASE_URL ?>?action=products&category=<?= $category[0] ?>"
                    class="text-decoration-none text-dark"
                >
                    <div class="card category-card shadow-sm">
                        <div class="category-image-box">
                            <img
                                src="<?= BASE_URL ?>assets/images/<?= $category[2] ?>"
                                alt="<?= htmlspecialchars($category[1]) ?>"
                                onerror="this.src='<?= BASE_URL ?>assets/images/no-image.png'"
                            >
                        </div>

                        <div class="card-body">
                            <h6 class="card-title mb-0">
                                <?= htmlspecialchars($category[1]) ?>
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sản phẩm mới nhất -->
<section class="container mt-5 mb-5">
    <h3 class="section-title">Sản phẩm mới nhất</h3>

    <div class="row g-4">
        <?php if (!empty($products)): ?>

            <?php foreach ($products as $product): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card product-card shadow-sm">
                        <div class="product-image-box">
                            <img
                                src="<?= BASE_ASSETS_UPLOADS .
                                    htmlspecialchars($product['Base_image'] ?? '') ?>"
                                alt="<?= htmlspecialchars($product['Product_name'] ?? '') ?>"
                                onerror="this.src='<?= BASE_URL ?>assets/images/no-image.png'"
                            >
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="product-name mb-2">
                                <?= htmlspecialchars($product['Product_name']) ?>
                            </h6>

                            <?php $minPrice = $product['Min_price'] ?? null; ?>
                                <p class="<?= $minPrice !== null
                                    ? 'product-price'
                                    : 'text-muted'
                            ?> mb-3">
                            <?= $minPrice !== null
                            ? 'Từ ' . number_format(
                            (float) $minPrice,
                             0,
                            ',',
                            '.'
                            ) . '₫'
                            : 'Chưa có giá'
                            ?>
                            </p>
                            <a
                                href="<?= BASE_URL ?>?action=product-detail&id=<?= (int) $product['Product_id'] ?>"
                                class="btn btn-outline-warning btn-view-product mt-auto"
                            >
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Hiện chưa có sản phẩm.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>