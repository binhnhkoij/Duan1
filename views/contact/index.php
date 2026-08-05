<?php
$success = $success ?? '';
$error = $error ?? '';
?>

<style>
    .contact-page {
        padding: 60px 20px;
        background:
            linear-gradient(
                135deg,
                rgba(245, 247, 250, 0.96),
                rgba(231, 238, 252, 0.96)
            );
    }

    .contact-container {
        width: 100%;
        max-width: 1200px;
        margin: auto;
    }

    .contact-heading {
        margin-bottom: 40px;
        text-align: center;
    }

    .contact-heading h1 {
        margin-bottom: 12px;
        color: #222;
        font-size: 38px;
        font-weight: 750;
    }

    .contact-heading p {
        max-width: 650px;
        margin: auto;
        color: #6c757d;
        font-size: 16px;
        line-height: 1.7;
    }

    .contact-wrapper {
        display: grid;
        grid-template-columns: 38% 62%;
        overflow: hidden;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
        padding: 45px 35px;
        color: #fff;
        background: linear-gradient(145deg, #151515, #303030);
    }

    .contact-info h2 {
        margin-bottom: 12px;
        font-size: 27px;
        font-weight: 700;
    }

    .contact-info > p {
        margin-bottom: 35px;
        color: rgba(255, 255, 255, 0.72);
        line-height: 1.7;
    }

    .info-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        align-items: flex-start;
    }

    .info-icon {
        width: 46px;
        height: 46px;
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: #dc003c;
        border-radius: 50%;
    }

    .info-content h4 {
        margin: 0 0 5px;
        font-size: 16px;
        font-weight: 700;
    }

    .info-content p,
    .info-content a {
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        text-decoration: none;
        line-height: 1.6;
    }

    .info-content a:hover {
        color: #fff;
    }

    .social-list {
        display: flex;
        gap: 12px;
        margin-top: 35px;
    }

    .social-list a {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
        transition: 0.25s;
    }

    .social-list a:hover {
        background: #dc003c;
        transform: translateY(-3px);
    }

    .contact-form {
        padding: 45px;
    }

    .contact-form h2 {
        margin-bottom: 8px;
        color: #222;
        font-size: 27px;
        font-weight: 700;
    }

    .contact-form > p {
        margin-bottom: 25px;
        color: #777;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .form-control-contact {
        width: 100%;
        padding: 13px 15px;
        color: #333;
        background: #f8f9fa;
        border: 1px solid #e1e4e8;
        border-radius: 10px;
        outline: none;
        transition: 0.2s;
    }

    .form-control-contact:focus {
        background: #fff;
        border-color: #dc003c;
        box-shadow: 0 0 0 3px rgba(220, 0, 60, 0.1);
    }

    textarea.form-control-contact {
        min-height: 145px;
        resize: vertical;
    }

    .contact-btn {
        min-width: 190px;
        padding: 14px 25px;
        color: #fff;
        font-weight: 650;
        background: #dc003c;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.25s;
    }

    .contact-btn:hover {
        background: #b90032;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(220, 0, 60, 0.25);
    }

    .contact-alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 10px;
    }

    .contact-alert.success {
        color: #0f5132;
        background: #d1e7dd;
        border: 1px solid #badbcc;
    }

    .contact-alert.error {
        color: #842029;
        background: #f8d7da;
        border: 1px solid #f5c2c7;
    }

    .contact-map {
        margin-top: 35px;
        overflow: hidden;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    }

    .contact-map iframe {
        width: 100%;
        height: 360px;
        display: block;
        border: 0;
    }

    @media (max-width: 900px) {
        .contact-wrapper {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .contact-page {
            padding: 35px 12px;
        }

        .contact-heading h1 {
            font-size: 30px;
        }

        .contact-info,
        .contact-form {
            padding: 30px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .contact-btn {
            width: 100%;
        }
    }
</style>

<section class="contact-page">
    <div class="contact-container">

        <div class="contact-heading">
            <h1>Liên hệ với chúng tôi</h1>

            <p>
                Bạn cần hỗ trợ về sản phẩm, đơn hàng hoặc chính sách đổi trả?
                Hãy gửi thông tin để cửa hàng hỗ trợ bạn nhanh nhất.
            </p>
        </div>

        <div class="contact-wrapper">

            <!-- Thông tin cửa hàng -->
            <div class="contact-info">
                <h2>Thông tin liên hệ</h2>

                <p>
                    Đội ngũ của chúng tôi luôn sẵn sàng hỗ trợ và giải đáp
                    các thắc mắc của bạn.
                </p>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>

                    <div class="info-content">
                        <h4>Địa chỉ</h4>
                        <p>
                            58 Lê Văn Hiến, Bắc Từ Liêm, Hà Nội
                        </p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>

                    <div class="info-content">
                        <h4>Số điện thoại</h4>
                        <a href="tel:0123456789">
                            0123 456 789
                        </a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="info-content">
                        <h4>Email</h4>
                        <a href="mailto:support@thegioigiaydep.vn">
                            support@thegioigiaydep.vn
                        </a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fa-solid fa-clock"></i>
                    </div>

                    <div class="info-content">
                        <h4>Thời gian làm việc</h4>
                        <p>Thứ 2 – Chủ nhật: 8:00 – 22:00</p>
                    </div>
                </div>

                <div class="social-list">
                    <a href="#" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="#" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>

                    <a href="#" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>

                    <a href="#" aria-label="Youtube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Form liên hệ -->
            <div class="contact-form">
                <h2>Gửi lời nhắn</h2>

                <p>
                    Điền thông tin bên dưới, chúng tôi sẽ phản hồi sớm.
                </p>

                <?php if ($success !== ''): ?>
                    <div class="contact-alert success">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <?php if ($error !== ''): ?>
                    <div class="contact-alert error">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">
                                Họ và tên
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control-contact"
                                placeholder="Nhập họ và tên"
                                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="phone">
                                Số điện thoại
                            </label>

                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                class="form-control-contact"
                                placeholder="Nhập số điện thoại"
                                value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            Email
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control-contact"
                            placeholder="Nhập địa chỉ email"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="message">
                            Nội dung
                            <span class="text-danger">*</span>
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            class="form-control-contact"
                            placeholder="Nhập nội dung cần hỗ trợ"
                            required
                        ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="contact-btn">
                        <i class="fa-solid fa-paper-plane me-1"></i>
                        Gửi liên hệ
                    </button>

                </form>
            </div>

        </div>

        <!-- Bản đồ -->
        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps?q=58%20L%C3%AA%20V%C4%83n%20Hi%E1%BA%BFn%20H%C3%A0%20N%E1%BB%99i&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Bản đồ cửa hàng"
            ></iframe>
        </div>

    </div>
</section>