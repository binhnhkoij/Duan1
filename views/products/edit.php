<?php
$categories = $categories ?? [];
$sizes = $sizes ?? [];
$colors = $colors ?? [];
$variants = $variants ?? [];
$error = $error ?? '';
$product = $product ?? [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Sửa sản phẩm</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            padding: 40px 15px;
            background: linear-gradient(135deg, #f5f7fa, #e8eefc);
        }

        .form-box {
            max-width: 1050px;
            margin: auto;
            padding: 32px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
        }

        .variant-row {
            margin-bottom: 12px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .preview-box {
            width: 100%;
            height: 220px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #999;
            background: #f8f8f8;
            border: 2px dashed #ddd;
            border-radius: 12px;
        }

        .preview-box img {
            width: 100%;
            height: 100%;
            padding: 10px;
            object-fit: contain;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px 8px;
            }

            .form-box {
                padding: 22px 15px;
            }
        }
    </style>
</head>

<body>

<div class="form-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fa-solid fa-pen-to-square text-warning me-1"></i>
                Sửa sản phẩm
            </h2>

            <p class="text-muted mb-0">
                Cập nhật sản phẩm và các biến thể.
            </p>
        </div>

        <a
            href="<?= BASE_URL ?>?action=products"
            class="btn btn-outline-secondary"
        >
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

    <form method="POST" enctype="multipart/form-data">

        <div class="row g-4">

            <!-- Tên sản phẩm -->
            <div class="col-md-7">
                <label class="form-label fw-semibold">
                    Tên sản phẩm
                </label>

                <input
                    type="text"
                    name="product_name"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $_POST['product_name']
                        ?? $product['Product_name']
                        ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >
            </div>

            <!-- Danh mục -->
            <div class="col-md-5">
                <label class="form-label fw-semibold">
                    Danh mục
                </label>

                <select
                    name="category_id"
                    class="form-select"
                    required
                >
                    <option value="">
                        -- Chọn danh mục --
                    </option>

                    <?php foreach ($categories as $category): ?>
                        <?php
                        $selectedCategory =
                            $_POST['category_id']
                            ?? $product['Category_id']
                            ?? 0;
                        ?>

                        <option
                            value="<?= (int) $category['Category_id'] ?>"
                            <?= (int) $selectedCategory ===
                                (int) $category['Category_id']
                                ? 'selected'
                                : ''
                            ?>
                        >
                            <?= htmlspecialchars(
                                $category['Category_name'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Mô tả -->
            <div class="col-md-8">
                <label class="form-label fw-semibold">
                    Mô tả
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="6"
                ><?= htmlspecialchars(
                    $_POST['description']
                    ?? $product['Description']
                    ?? '',
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>
            </div>

            <!-- Trạng thái và ảnh -->
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    Trạng thái
                </label>

                <?php
                $selectedStatus = (int) (
                    $_POST['status']
                    ?? $product['Status']
                    ?? 1
                );
                ?>

                <select name="status" class="form-select">
                    <option
                        value="1"
                        <?= $selectedStatus === 1
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Đang bán
                    </option>

                    <option
                        value="0"
                        <?= $selectedStatus === 0
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Tạm ẩn
                    </option>
                </select>

                <label class="form-label fw-semibold mt-3">
                    Thay ảnh chính
                </label>

                <input
                    type="file"
                    name="base_image"
                    id="baseImage"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Không chọn ảnh mới thì giữ ảnh cũ.
                </small>
            </div>

            <!-- Ảnh xem trước -->
            <div class="col-12">
                <div class="preview-box">
                    <img
                        id="imagePreview"
                        src="<?= BASE_ASSETS_UPLOADS .
                            htmlspecialchars(
                                $product['Base_image'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>"
                        alt="Ảnh sản phẩm"
                    >
                </div>
            </div>

        </div>

        <hr class="my-4">

        <!-- Biến thể -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">
                Biến thể sản phẩm
            </h4>

            <button
                type="button"
                id="addVariant"
                class="btn btn-outline-primary"
            >
                <i class="fa-solid fa-plus me-1"></i>
                Thêm dòng biến thể
            </button>
        </div>

        <div id="variantList">

            <?php if (!empty($variants)): ?>

                <?php foreach ($variants as $variant): ?>

                    <div class="variant-row">
                        <div class="row g-2 align-items-end">

                            <!-- Size -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Size
                                </label>

                                <select
                                    name="size_id[]"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        -- Chọn size --
                                    </option>

                                    <?php foreach ($sizes as $size): ?>
                                        <option
                                            value="<?= (int) $size['Size_id'] ?>"
                                            <?= (int) $size['Size_id'] ===
                                                (int) $variant['Size_id']
                                                ? 'selected'
                                                : ''
                                            ?>
                                        >
                                            <?= htmlspecialchars(
                                                $size['Size_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Màu -->
                            <div class="col-md-3">
                                <label class="form-label">
                                    Màu
                                </label>

                                <select
                                    name="color_id[]"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        -- Chọn màu --
                                    </option>

                                    <?php foreach ($colors as $color): ?>
                                        <option
                                            value="<?= (int) $color['Color_id'] ?>"
                                            <?= (int) $color['Color_id'] ===
                                                (int) $variant['Color_id']
                                                ? 'selected'
                                                : ''
                                            ?>
                                        >
                                            <?= htmlspecialchars(
                                                $color['Color_name'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Giá -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Giá
                                </label>

                                <input
                                    type="number"
                                    name="price[]"
                                    class="form-control"
                                    value="<?= (float) $variant['Price'] ?>"
                                    min="1"
                                    required
                                >
                            </div>

                            <!-- Tồn kho -->
                            <div class="col-md-2">
                                <label class="form-label">
                                    Tồn kho
                                </label>

                                <input
                                    type="number"
                                    name="stock[]"
                                    class="form-control"
                                    value="<?= (int) $variant['Stock'] ?>"
                                    min="0"
                                    required
                                >
                            </div>

                            <!-- Xóa dòng -->
                            <div class="col-md-2">
                                <button
                                    type="button"
                                    class="btn btn-danger w-100 remove-variant"
                                >
                                    Xóa dòng
                                </button>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <!-- Dòng mặc định nếu sản phẩm chưa có biến thể -->
                <div class="variant-row">
                    <div class="row g-2 align-items-end">

                        <div class="col-md-3">
                            <label class="form-label">Size</label>

                            <select
                                name="size_id[]"
                                class="form-select"
                                required
                            >
                                <option value="">
                                    -- Chọn size --
                                </option>

                                <?php foreach ($sizes as $size): ?>
                                    <option value="<?= $size['Size_id'] ?>">
                                        <?= htmlspecialchars(
                                            $size['Size_name']
                                        ) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Màu</label>

                            <select
                                name="color_id[]"
                                class="form-select"
                                required
                            >
                                <option value="">
                                    -- Chọn màu --
                                </option>

                                <?php foreach ($colors as $color): ?>
                                    <option value="<?= $color['Color_id'] ?>">
                                        <?= htmlspecialchars(
                                            $color['Color_name']
                                        ) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Giá</label>

                            <input
                                type="number"
                                name="price[]"
                                class="form-control"
                                min="1"
                                required
                            >
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tồn kho</label>

                            <input
                                type="number"
                                name="stock[]"
                                class="form-control"
                                min="0"
                                required
                            >
                        </div>

                        <div class="col-md-2">
                            <button
                                type="button"
                                class="btn btn-danger w-100 remove-variant"
                            >
                                Xóa dòng
                            </button>
                        </div>

                    </div>
                </div>

            <?php endif; ?>

        </div>

        <!-- Nút lưu -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a
                href="<?= BASE_URL ?>?action=products"
                class="btn btn-outline-secondary"
            >
                Hủy
            </a>

            <button
                type="submit"
                class="btn btn-warning"
            >
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Cập nhật sản phẩm
            </button>
        </div>

    </form>
</div>

<script>
    const variantList = document.getElementById('variantList');
    const addVariantButton = document.getElementById('addVariant');

    // Thêm dòng biến thể
    addVariantButton.addEventListener('click', () => {
        const firstRow =
            variantList.querySelector('.variant-row');

        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
        });

        newRow.querySelectorAll('select').forEach(select => {
            select.value = '';
        });

        variantList.appendChild(newRow);
    });

    // Xóa dòng biến thể
    variantList.addEventListener('click', event => {
        const removeButton =
            event.target.closest('.remove-variant');

        if (!removeButton) {
            return;
        }

        const rows =
            variantList.querySelectorAll('.variant-row');

        if (rows.length === 1) {
            alert('Sản phẩm phải có ít nhất một biến thể.');
            return;
        }

        removeButton.closest('.variant-row').remove();
    });

    // Xem trước ảnh mới
    const imageInput = document.getElementById('baseImage');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = event => {
            imagePreview.src = event.target.result;
        };

        reader.readAsDataURL(file);
    });
</script>

</body>
</html>