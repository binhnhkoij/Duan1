<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Shoes Store') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        .site-footer {
    margin-top: 60px;
    padding: 28px 0 18px;
    color: #fff;
    background: #202428;
}

.footer-grid {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1fr;
    gap: 70px;
}

.footer-brand {
    margin-bottom: 10px;
    color: #ffc107;
    font-weight: 700;
}

.footer-brand i {
    margin-right: 8px;
}

.site-footer h6 {
    margin-bottom: 12px;
    font-weight: 700;
}

.site-footer p {
    margin-bottom: 10px;
    line-height: 1.5;
}

.site-footer p i {
    width: 24px;
}

.social-links {
    display: flex;
    gap: 18px;
}

.social-links a {
    color: #fff;
    font-size: 20px;
    transition: .25s;
}

.social-links a:hover {
    color: #ffc107;
    transform: translateY(-3px);
}

.footer-bottom {
    margin-top: 35px;
    padding-top: 18px;
    text-align: center;
    border-top: 1px solid rgba(255,255,255,.12);
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>">
            Shoes Store
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainMenu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainMenu">

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>">
                        Trang chủ
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        Danh mục
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= BASE_URL ?>?action=products&category=1"
                            >
                                Giày nam
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= BASE_URL ?>?action=products&category=2"
                            >
                                Giày nữ
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= BASE_URL ?>?action=products&category=3"
                            >
                                Giày thể thao
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= BASE_URL ?>?action=products&category=4"
                            >
                                Dép thời trang
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>?action=orders"
                    >
                        Lịch sử đơn hàng
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="<?= BASE_URL ?>?action=contact"
                    >
                        Liên hệ
                    </a>
                </li>
</li>
            </ul>

            <form
                class="d-flex me-3"
                method="GET"
                action="<?= BASE_URL ?>"
            >
                <input type="hidden" name="action" value="products">

                <input
                    class="form-control me-2"
                    type="search"
                    name="search"
                    placeholder="Tìm giày, dép..."
                >

                <button class="btn btn-outline-light" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <a
                href="<?= BASE_URL ?>?action=cart"
                class="text-white text-decoration-none me-3 position-relative"
            >
                <i class="fa-solid fa-cart-shopping fs-5"></i>

                <span
                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                >
                    0
                </span>
            </a>

            <?php if (!empty($_SESSION['user_id'])): ?>

    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>

        <a
            href="<?= BASE_URL ?>?action=admin"
            class="text-white text-decoration-none me-3"
        >
            <i class="fa-solid fa-user-shield me-1"></i>

            <?= htmlspecialchars(
                $_SESSION['name'] ?? 'Quản trị viên',
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </a>

    <?php else: ?>

        <span class="text-white me-3">
            <i class="fa-solid fa-user me-1"></i>

            <?= htmlspecialchars(
                $_SESSION['name'] ?? 'Tài khoản',
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </span>

    <?php endif; ?>

    <a
        href="<?= BASE_URL ?>?action=logout"
        class="btn btn-outline-warning btn-sm"
    >
        Đăng xuất
    </a>

        <?php else: ?>

    <a
        href="<?= BASE_URL ?>?action=login"
        class="text-white text-decoration-none"
    >
        <i class="fa-solid fa-right-to-bracket me-1"></i>
        Đăng nhập
    </a>

        <?php endif; ?>

        </div>
    </div>
</nav>
<?php
if (!empty($view)) {
    require PATH_VIEW . $view . '.php';
}
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">

            <div>
                <h5 class="footer-brand">
                    <i class="fa-solid fa-shoe-prints"></i>
                    Thế Giới Giày Dép
                </h5>

                <p>
                    Chuyên cung cấp các loại giày dép thời trang như
                    giày nam, giày nữ, giày thể thao, sneaker, sandal
                    và dép với nhiều mẫu mã đa dạng.
                </p>
            </div>

            <div>
                <h6>Liên hệ</h6>

                <p>
                    <i class="fa-solid fa-location-dot"></i>
                    Hà Nội
                </p>

                <p>
                    <i class="fa-solid fa-envelope"></i>
                    support@thegioigiaydep.vn
                </p>

                <p>
                    <i class="fa-solid fa-phone"></i>
                    0123 456 789
                </p>
            </div>

            <div>
                <h6>Kết nối với chúng tôi</h6>

                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            © <?= date('Y') ?> Thế Giới Giày Dép. Đã đăng ký bản quyền.
        </div>
    </div>
</footer>
</body>
</html>
