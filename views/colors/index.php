<?php
$colors = $colors ?? [];
$error = $error ?? '';
$editColor = $editColor ?? null;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Quản lý màu sắc</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    >

    <style>
        body {
            min-height: 100vh;
            padding: 40px 15px;
            background: #f5f7fa;
        }

        .color-box {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }
    </style>
</head>

<body>

<div class="color-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Quản lý màu sắc</h2>

            <p class="text-muted mb-0">
                Thêm, sửa và xóa màu sản phẩm
            </p>
        </div>

        <a
            href="<?= BASE_URL ?>?action=admin"
            class="btn btn-outline-secondary"
        >
            Quay lại
        </a>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="row g-2 mb-4">

        <input
            type="hidden"
            name="color_id"
            value="<?= (int) ($editColor['Color_id'] ?? 0) ?>"
        >

        <div class="col-md-9">
            <input
                type="text"
                name="color_name"
                class="form-control"
                placeholder="Nhập tên màu sắc"
                value="<?= htmlspecialchars(
                    $editColor['Color_name'] ?? ''
                ) ?>"
                required
            >
        </div>

        <div class="col-md-3">
            <button class="btn btn-success w-100">
                <?= $editColor ? 'Cập nhật' : 'Thêm màu' ?>
            </button>
        </div>

    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">

            <thead class="table-dark">
                <tr>
                    <th width="80">STT</th>
                    <th>Tên màu</th>
                    <th width="180">Hành động</th>
                </tr>
            </thead>

            <tbody>

            <?php if ($colors): ?>

                <?php foreach ($colors as $index => $color): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>

                        <td>
                            <?= htmlspecialchars($color['Color_name']) ?>
                        </td>

                        <td>
                            <a
                                href="<?= BASE_URL ?>?action=colors&edit=<?= (int) $color['Color_id'] ?>"
                                class="btn btn-warning btn-sm"
                            >
                                Sửa
                            </a>

                            <a
                                href="<?= BASE_URL ?>?action=color-delete&id=<?= (int) $color['Color_id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa màu này?')"
                            >
                                Xóa
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="3" class="text-center">
                        Chưa có màu sắc.
                    </td>
                </tr>

            <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

</body>
</html>