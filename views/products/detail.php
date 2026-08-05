<?php
$product = $product ?? [];
$variants = $variants ?? [];
$related = $related ?? [];

$colors = [];
$minPrice = null;

foreach ($variants as $variant) {
    $price = (float) $variant['Price'];
    $minPrice = $minPrice === null ? $price : min($minPrice, $price);

    $colorId = (int) $variant['Color_id'];

    if (!isset($colors[$colorId])) {
        $colors[$colorId] = [
            'id' => $colorId,
            'name' => $variant['Color_name'],
            'image' => $variant['Variant_image']
                ?: ($product['Base_image'] ?? '')
        ];
    }
}

$firstColor = $colors ? reset($colors) : null;
$mainImage = $firstColor['image'] ?? ($product['Base_image'] ?? '');
?>

<style>
.detail{max-width:1300px;margin:auto;padding:40px 20px}
.detail-main{display:grid;grid-template-columns:30% 40% 30%;gap:25px;align-items:center}
.main-image{width:100%;height:430px;object-fit:contain}
.price{color:#dc003c;font-size:24px;font-weight:700}
.color-list{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin:15px 0}
.color-btn{height:70px;padding:5px;border:1px solid transparent;background:#fff}
.color-btn.active{border-color:#111}
.color-btn img{width:100%;height:100%;object-fit:contain}
.option,.cart-btn{width:100%;height:50px;margin-bottom:12px}
.option{padding:0 12px}
.cart-btn{border:0;color:#fff;background:#dc003c}
.related{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.related img{width:100%;height:220px;object-fit:contain}
@media(max-width:900px){
    .detail-main{grid-template-columns:1fr}
    .related{grid-template-columns:repeat(2,1fr)}
}
</style>

<div class="detail">

    <div class="detail-main">

        <div>
            <small><?= e($product['Category_name'] ?? '') ?></small>

            <h1><?= e($product['Product_name'] ?? '') ?></h1>

            <p class="price" id="price">
                <?= $minPrice !== null
                    ? number_format($minPrice, 0, ',', '.') . '₫'
                    : 'Chưa có giá'
                ?>
            </p>

            <p>
                <?= nl2br(e(
                    $product['Description']
                    ?: 'Sản phẩm chưa có mô tả.'
                )) ?>
            </p>
        </div>

        <img
            id="mainImage"
            class="main-image"
            src="<?= BASE_ASSETS_UPLOADS . e($mainImage) ?>"
            alt="<?= e($product['Product_name'] ?? '') ?>"
        >

        <div>
            <?php if ($colors): ?>

                <p>
                    Màu:
                    <strong id="colorName">
                        <?= e($firstColor['name']) ?>
                    </strong>
                </p>

                <div class="color-list">
                    <?php $index = 0; ?>

                    <?php foreach ($colors as $color): ?>
                        <button
                            type="button"
                            class="color-btn <?= $index++ === 0 ? 'active' : '' ?>"
                            data-color="<?= $color['id'] ?>"
                            data-name="<?= e($color['name']) ?>"
                            data-image="<?= BASE_ASSETS_UPLOADS . e($color['image']) ?>"
                        >
                            <img
                                src="<?= BASE_ASSETS_UPLOADS . e($color['image']) ?>"
                                alt="<?= e($color['name']) ?>"
                            >
                        </button>
                    <?php endforeach; ?>
                </div>

                <form
                    method="POST"
                    action="<?= BASE_URL ?>?action=cart-add"
                >
                    <select
                        name="variant_id"
                        id="sizeSelect"
                        class="option"
                        required
                    >
                        <option value="">-- Chọn kích thước --</option>
                    </select>

                    <select
                        name="quantity"
                        id="quantitySelect"
                        class="option"
                    >
                        <option value="1">Số lượng: 1</option>
                    </select>

                    <button class="cart-btn">
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </form>

                <small id="stock" class="text-success">
                    Vui lòng chọn kích thước.
                </small>

            <?php else: ?>

                <div class="alert alert-warning">
                    Sản phẩm chưa có biến thể.
                </div>

            <?php endif; ?>
        </div>

    </div>

    <?php if ($related): ?>
        <h3 class="text-center my-5">
            BẠN CÓ THỂ THÍCH
        </h3>

        <div class="related">
            <?php foreach ($related as $item): ?>
                <a
                    href="<?= BASE_URL ?>?action=product-detail&id=<?= (int) $item['Product_id'] ?>"
                    class="text-decoration-none text-dark"
                >
                    <img
                        src="<?= BASE_ASSETS_UPLOADS . e($item['Base_image']) ?>"
                        alt="<?= e($item['Product_name']) ?>"
                    >

                    <p><?= e($item['Product_name']) ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script>
const variants = <?= json_encode(
    $variants,
    JSON_UNESCAPED_UNICODE
) ?>;

const colorButtons = document.querySelectorAll('.color-btn');
const sizeSelect = document.getElementById('sizeSelect');
const quantitySelect = document.getElementById('quantitySelect');
const mainImage = document.getElementById('mainImage');
const colorName = document.getElementById('colorName');
const price = document.getElementById('price');
const stock = document.getElementById('stock');

function loadSizes(colorId) {
    if (!sizeSelect) return;

    sizeSelect.innerHTML =
        '<option value="">-- Chọn kích thước --</option>';

    variants
        .filter(item => Number(item.Color_id) === Number(colorId))
        .forEach(item => {
            sizeSelect.innerHTML += `
                <option
                    value="${item.Variant_id}"
                    data-price="${item.Price}"
                    data-stock="${item.Stock}"
                    ${Number(item.Stock) <= 0 ? 'disabled' : ''}
                >
                    Size ${item.Size_name}
                </option>
            `;
        });
}

colorButtons.forEach(button => {
    button.onclick = () => {
        colorButtons.forEach(item => item.classList.remove('active'));
        button.classList.add('active');

        mainImage.src = button.dataset.image;
        colorName.textContent = button.dataset.name;

        loadSizes(button.dataset.color);
    };
});

sizeSelect?.addEventListener('change', function () {
    const option = this.options[this.selectedIndex];

    if (!this.value) return;

    const productPrice = Number(option.dataset.price);
    const productStock = Number(option.dataset.stock);

    price.textContent =
        new Intl.NumberFormat('vi-VN').format(productPrice) + '₫';

    stock.textContent = `Còn ${productStock} sản phẩm`;

    quantitySelect.innerHTML = '';

    for (let i = 1; i <= Math.min(productStock, 10); i++) {
        quantitySelect.innerHTML += `
            <option value="${i}">
                Số lượng: ${i}
            </option>
        `;
    }
});

const firstColor = document.querySelector('.color-btn');

if (firstColor) {
    loadSizes(firstColor.dataset.color);
}
</script>