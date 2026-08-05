<?php
$products = $products ?? [];
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Quản lý sản phẩm
            </h2>

            <p class="text-muted mb-0">
                Danh sách sản phẩm và biến thể trong cửa hàng
            </p>
        </div>

        <a
            href="<?= BASE_URL ?>?action=product-create"
            class="btn btn-success"
        >
            <i class="fa-solid fa-plus me-1"></i>
            Thêm sản phẩm
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá thấp nhất</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($products)): ?>

                        <?php foreach ($products as $index => $product): ?>
                            <?php
                            $productId = (int) (
                                $product['Product_id'] ?? 0
                            );

                            $productName =
                                $product['Product_name'] ?? '';

                            $categoryName =
                                $product['Category_name'] ?? 'Chưa có';

                            $baseImage =
                                $product['Base_image'] ?? '';

                            $minPrice =
                                $product['Min_price'] ?? null;

                            $totalStock = (int) (
                                $product['Total_stock'] ?? 0
                            );

                            $status = (int) (
                                $product['Status'] ?? 0
                            );
                            ?>

                            <tr>
                                <td>
                                    <?= $index + 1 ?>
                                </td>

                                <td>
                                    <img
                                        src="<?= BASE_ASSETS_UPLOADS .
                                            htmlspecialchars(
                                                $baseImage,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>"
                                        alt="<?= htmlspecialchars(
                                            $productName,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        width="75"
                                        height="75"
                                        style="
                                            object-fit: contain;
                                            background: #f7f7f7;
                                            border-radius: 10px;
                                        "
                                        onerror="
                                            this.src='<?= BASE_URL ?>assets/images/no-image.png'
                                        "
                                    >
                                </td>

                                <td class="fw-semibold">
                                    <?= htmlspecialchars(
                                        $productName,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $categoryName,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </td>

                                <td>
                                    <?php if ($minPrice !== null): ?>
                                        <span class="text-danger fw-bold">
                                            <?= number_format(
                                                (float) $minPrice,
                                                0,
                                                ',',
                                                '.'
                                            ) ?>đ
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted fw-semibold">
                                            Chưa có giá
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($totalStock > 0): ?>
                                        <span class="fw-semibold text-success">
                                            <?= $totalStock ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-danger">
                                            0
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($status === 1): ?>
                                        <span class="badge bg-success">
                                            Đang bán
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            Đang ẩn
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a
                                            href="<?= BASE_URL ?>?action=product-detail&id=<?= $productId ?>"
                                            class="btn btn-primary btn-sm"
                                        >
                                            <i class="fa-solid fa-eye"></i>
                                            Xem
                                        </a>

                                        <a
                                            href="<?= BASE_URL ?>?action=product-edit&id=<?= $productId ?>"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                            Sửa
                                        </a>

                                        <a
                                            href="<?= BASE_URL ?>?action=product-delete&id=<?= $productId ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm(
                                                'Bạn chắc chắn muốn xóa sản phẩm và toàn bộ biến thể?'
                                            )"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                            Xóa
                                        </a>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td
                                colspan="8"
                                class="text-center py-5 text-muted"
                            >
                                Chưa có sản phẩm nào.
                            </td>
                        </tr>

                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a
        href="<?= BASE_URL ?>?action=admin"
        class="btn btn-outline-secondary mt-4"
    >
        <i class="fa-solid fa-arrow-left me-1"></i>
        Quay lại quản trị
    </a>
</div>