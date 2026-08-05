<?php
$categories = $categories ?? [];
$error = $error ?? '';
$editCategory = $editCategory ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quản lý danh mục</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <style>
        body {
            min-height: 100vh;
            padding: 40px 15px;
            background: linear-gradient(135deg, #f5f7fa, #e8eefc);
        }

        .category-box {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .category-link {
            color: #212529;
            font-weight: 600;
            text-decoration: none;
        }

        .category-link:hover {
            color: #0d6efd;
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="category-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-list me-1"></i>
                Quản lý danh mục
            </h2>

            <p class="text-muted mb-0">
                Thêm, sửa và xóa danh mục sản phẩm
            </p>
        </div>

        <a
            href="<?= BASE_URL ?>?action=admin"
            class="btn btn-outline-secondary"
        >
            <i class="fa-solid fa-arrow-left me-1"></i>
            Quay lại
        </a>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars(
                $error,
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="row g-2 mb-4">

        <input
            type="hidden"
            name="category_id"
            value="<?= (int) ($editCategory['Category_id'] ?? 0) ?>"
        >

        <div class="col-md-9">
            <input
                type="text"
                name="category_name"
                class="form-control"
                placeholder="Nhập tên danh mục"
                value="<?= htmlspecialchars(
                    $editCategory['Category_name'] ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
                required
            >
        </div>

        <div class="col-md-3">
            <button class="btn btn-success w-100">
                <?php if ($editCategory): ?>
                    <i class="fa-solid fa-floppy-disk me-1"></i>
                    Cập nhật
                <?php else: ?>
                    <i class="fa-solid fa-plus me-1"></i>
                    Thêm danh mục
                <?php endif; ?>
            </button>
        </div>

    </form>

    <?php if ($editCategory): ?>
        <div class="mb-3">
            <a
                href="<?= BASE_URL ?>?action=categories"
                class="btn btn-sm btn-outline-secondary"
            >
                Hủy sửa
            </a>
        </div>
    <?php endif; ?>

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th width="80">STT</th>
                    <th>Tên danh mục</th>
                    <th width="190">Hành động</th>
                </tr>
            </thead>

            <tbody>

            <?php if (!empty($categories)): ?>

                <?php foreach ($categories as $index => $category): ?>
                    <tr>

                        <td><?= $index + 1 ?></td>

                        <td>
                            <a
                                href="<?= BASE_URL ?>?action=products&category_id=<?= (int) $category['Category_id'] ?>"
                                class="category-link"
                                title="Xem sản phẩm thuộc danh mục này"
                            >
                                <i class="fa-solid fa-folder-open me-1"></i>

                                <?= htmlspecialchars(
                                    $category['Category_name'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </a>
                        </td>

                        <td>
                            <a
                                href="<?= BASE_URL ?>?action=categories&edit=<?= (int) $category['Category_id'] ?>"
                                class="btn btn-warning btn-sm"
                            >
                                <i class="fa-solid fa-pen"></i>
                                Sửa
                            </a>

                            <a
                                href="<?= BASE_URL ?>?action=category-delete&id=<?= (int) $category['Category_id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')"
                            >
                                <i class="fa-solid fa-trash"></i>
                                Xóa
                            </a>
                        </td>

                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        Chưa có danh mục.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>

    </div>

</div>

</body>
</html>