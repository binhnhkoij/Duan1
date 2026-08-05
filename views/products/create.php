<?php
$categories = $categories ?? [];
$sizes = $sizes ?? [];
$colors = $colors ?? [];
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Thêm sản phẩm</title>

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
            padding: 15px;
            margin-bottom: 12px;
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
            display: none;
            object-fit: contain;
        }
    </style>
</head>

<body>

<div class="form-box">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Thêm sản phẩm và biến thể
            </h2>

            <p class="text-muted mb-0">
                Thêm thông tin sản phẩm, size, màu, giá và tồn kho.
            </p>
        </div>

        <a
            href="<?= BASE_URL ?>?action=products"
            class="btn btn-outline-secondary"
        >
            Quay lại
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="row g-4">

            <div class="col-md-7">
                <label class="form-label fw-semibold">
                    Tên sản phẩm
                </label>

                <input
                    type="text"
                    name="product_name"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $_POST['product_name'] ?? ''
                    ) ?>"
                    required
                >
            </div>

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
                        <option
                            value="<?= $category['Category_id'] ?>"
                            <?= (
                                $_POST['category_id'] ?? ''
                            ) == $category['Category_id']
                                ? 'selected'
                                : ''
                            ?>
                        >
                            <?= htmlspecialchars(
                                $category['Category_name']
                            ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-8">
                <label class="form-label fw-semibold">
                    Mô tả
                </label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="6"
                ><?= htmlspecialchars(
                    $_POST['description'] ?? ''
                ) ?></textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    Trạng thái
                </label>

                <select name="status" class="form-select">
                    <option value="1">Đang bán</option>
                    <option value="0">Tạm ẩn</option>
                </select>

                <label class="form-label fw-semibold mt-3">
                    Ảnh chính
                </label>

                <input
                    type="file"
                    name="base_image"
                    id="baseImage"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                    required
                >
            </div>

            <div class="col-12">
                <div class="preview-box">
                    <span id="previewText">
                        Chọn ảnh để xem trước
                    </span>

                    <img
                        id="imagePreview"
                        src=""
                        alt="Ảnh xem trước"
                    >
                </div>
            </div>

        </div>

        <hr class="my-4">

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

            <div class="variant-row">
                <div class="row g-2 align-items-end">

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
                                <option value="<?= $size['Size_id'] ?>">
                                    <?= htmlspecialchars(
                                        $size['Size_name']
                                    ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

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
                                <option value="<?= $color['Color_id'] ?>">
                                    <?= htmlspecialchars(
                                        $color['Color_name']
                                    ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Giá
                        </label>

                        <input
                            type="number"
                            name="price[]"
                            class="form-control"
                            min="1"
                            required
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">
                            Tồn kho
                        </label>

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

        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a
                href="<?= BASE_URL ?>?action=products"
                class="btn btn-outline-secondary"
            >
                Hủy
            </a>

            <button
                type="submit"
                class="btn btn-success"
            >
                <i class="fa-solid fa-floppy-disk me-1"></i>
                Lưu sản phẩm
            </button>
        </div>

    </form>
</div>

<script>
    const variantList = document.getElementById('variantList');
    const addVariantButton = document.getElementById('addVariant');

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

    const imageInput = document.getElementById('baseImage');
    const imagePreview = document.getElementById('imagePreview');
    const previewText = document.getElementById('previewText');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            imagePreview.style.display = 'none';
            previewText.style.display = 'block';
            return;
        }

        const reader = new FileReader();

        reader.onload = event => {
            imagePreview.src = event.target.result;
            imagePreview.style.display = 'block';
            previewText.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });
</script>

</body>
</html>