<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Bảng điều khiển Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e8eefc);
        }

        .admin-box {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.96);
            border-radius: 24px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .admin-header {
            text-align: center;
        }

        .admin-header h1 {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            color: #333;
            font-size: 2.1rem;
            font-weight: 700;
        }

        .admin-subtitle {
            margin-top: 10px;
            color: #777;
            font-size: 0.95rem;
        }

        .stats-box {
            margin-top: 40px;
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .stat-card {
            padding: 28px;
            text-align: center;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            margin-bottom: 12px;
            color: #ff6500;
            font-size: 35px;
        }

        .stat-title {
            color: #666;
            font-size: 1rem;
            font-weight: 500;
        }

        .stat-number {
            margin-top: 10px;
            color: #087bff;
            font-size: 2rem;
            font-weight: 700;
        }

        .section-links {
            margin-top: 50px;
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .section-links a {
            padding: 25px 15px;
            color: #333;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            background: #fff;
            border: 2px solid transparent;
            border-radius: 16px;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .section-links a:hover {
            color: #fff;
            transform: translateY(-5px);
            border-color: #ff7b00;
            background: linear-gradient(135deg, #ff7b00, #ff3c00);
            box-shadow: 0 8px 22px rgba(255, 80, 0, 0.3);
        }

        .section-links a i {
            display: block;
            margin-bottom: 10px;
            color: #ff7b00;
            font-size: 28px;
        }

        .section-links a:hover i {
            color: #fff;
        }

        .actions {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }

        .actions a {
            min-width: 150px;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 12px;
            }

            .admin-box {
                padding: 25px 18px;
            }

            .admin-header h1 {
                font-size: 1.6rem;
            }

            .actions {
                flex-direction: column;
            }

            .actions a {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<?php
$adminName = $adminName ?? 'Quản trị viên';

$stats = $stats ?? [
    'users' => 0,
    'products' => 0,
    'orders' => 0,
    'categories' => 0,
    'colors' => 0,
    'sizes' => 0
];
?>

<div class="admin-box">

    <div class="admin-header">
        <h1>
            👋 Xin chào

            <span class="text-primary">
                <?= htmlspecialchars(
                    $adminName,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </span>
        </h1>

        <p class="admin-subtitle">
            Chào mừng bạn đến với bảng điều khiển quản trị.
        </p>
    </div>

    <div class="stats-box">

        <div class="stat-card">
            <i class="fa-solid fa-users stat-icon"></i>

            <div class="stat-title">
                Người dùng
            </div>

            <div class="stat-number">
                <?= (int) ($stats['users'] ?? 0) ?>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-box stat-icon"></i>

            <div class="stat-title">
                Sản phẩm
            </div>

            <div class="stat-number">
                <?= (int) ($stats['products'] ?? 0) ?>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-cart-shopping stat-icon"></i>

            <div class="stat-title">
                Đơn hàng
            </div>

            <div class="stat-number">
                <?= (int) ($stats['orders'] ?? 0) ?>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-list stat-icon"></i>

            <div class="stat-title">
                Danh mục
            </div>

            <div class="stat-number">
                <?= (int) ($stats['categories'] ?? 0) ?>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-palette stat-icon"></i>

            <div class="stat-title">
                Màu sắc
            </div>

            <div class="stat-number">
                <?= (int) ($stats['colors'] ?? 0) ?>
            </div>
        </div>

        <div class="stat-card">
            <i class="fa-solid fa-ruler stat-icon"></i>

            <div class="stat-title">
                Kích thước
            </div>

            <div class="stat-number">
                <?= (int) ($stats['sizes'] ?? 0) ?>
            </div>
        </div>

    </div>

    <div class="section-links">

       <a href="<?= BASE_URL ?>?action=admin-products">
        <i class="fa-solid fa-box"></i>
        Quản lý sản phẩm
        </a>

        <a href="<?= BASE_URL ?>?action=categories">
            <i class="fa-solid fa-list"></i>
            Quản lý danh mục
        </a>

        <a href="<?= BASE_URL ?>?action=colors">
            <i class="fa-solid fa-palette"></i>
            Quản lý màu sắc
        </a>

        <a href="<?= BASE_URL ?>?action=sizes">
            <i class="fa-solid fa-ruler"></i>
            Quản lý kích thước
        </a>

        <a href="<?= BASE_URL ?>?action=accounts">
        <i class="fa-solid fa-user-gear"></i>
             Quản lý tài khoản
        </a>

        <a href="<?= BASE_URL ?>?action=orders">
            <i class="fa-solid fa-cart-shopping"></i>
            Quản lý đơn hàng
        </a>

        <a href="<?= BASE_URL ?>?action=payments">
            <i class="fa-solid fa-credit-card"></i>
            Phương thức thanh toán
        </a>

    </div>

    <div class="actions">

        <a
            href="<?= BASE_URL ?>"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-house me-1"></i>
            Trang chủ
        </a>

        <a
            href="<?= BASE_URL ?>?action=logout"
            class="btn btn-outline-danger"
        >
            <i class="fa-solid fa-right-from-bracket me-1"></i>
            Đăng xuất
        </a>

    </div>

</div>

</body>
</html>