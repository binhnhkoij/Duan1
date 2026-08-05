<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Đăng nhập và đăng ký</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    >

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #fff1b8, #ffd34e, #ff9300);
        }

        .auth-box {
            position: relative;
            width: 900px;
            max-width: 100%;
            min-height: 560px;
            overflow: hidden;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.2);
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 22px;
            z-index: 20;
            color: #444;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
        }

        .back-home:hover {
            color: #ff7b00;
        }

        .form-panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            padding: 60px 42px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
            transition: 0.65s ease;
        }

        .register-panel {
            opacity: 0;
            pointer-events: none;
        }

        .auth-box.active .login-panel {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
        }

        .auth-box.active .register-panel {
            transform: translateX(100%);
            opacity: 1;
            pointer-events: auto;
        }

        .form-panel h2 {
            margin: 0 0 8px;
            color: #222;
            font-size: 32px;
            font-weight: 700;
            text-align: center;
        }

        .subtitle {
            margin: 0 0 24px;
            color: #777;
            font-size: 14px;
            text-align: center;
        }

        .input-box {
            position: relative;
            margin-bottom: 16px;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            padding: 0 44px 0 15px;
            color: #222;
            font-size: 14px;
            border: 1px solid #d9d9d9;
            border-radius: 11px;
            outline: none;
            background: #fafafa;
            transition: 0.25s;
        }

        .input-box input:focus {
            border-color: #ff8a00;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(255, 138, 0, 0.14);
        }

        .input-box i {
            position: absolute;
            top: 50%;
            right: 15px;
            color: #999;
            transform: translateY(-50%);
        }

        .btn-submit {
            width: 100%;
            height: 48px;
            margin-top: 2px;
            color: #111;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 11px;
            cursor: pointer;
            background: linear-gradient(135deg, #ffc107, #ff7b00);
            transition: 0.25s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(255, 123, 0, 0.28);
        }

        .switch-text {
            margin-top: 20px;
            color: #555;
            font-size: 14px;
            text-align: center;
        }

        .switch-text a {
            color: #ff6f00;
            font-weight: 700;
            text-decoration: none;
        }

        .alert-message {
            margin-bottom: 16px;
            padding: 10px 12px;
            color: #b42334;
            font-size: 13px;
            text-align: center;
            border-radius: 9px;
            background: #ffe4e6;
        }

        .alert-message.success {
            color: #167344;
            background: #dcfce7;
        }

        .overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            padding: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #111;
            text-align: center;
            background: linear-gradient(135deg, #ffd54f, #ff9800);
            transition: 0.65s ease;
        }

        .auth-box.active .overlay {
            transform: translateX(-100%);
        }

        .overlay-icon {
            width: 88px;
            height: 88px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.35);
        }

        .overlay h1 {
            margin: 0 0 14px;
            font-size: 35px;
            font-weight: 700;
        }

        .overlay p {
            max-width: 330px;
            margin: 0;
            font-size: 15px;
            line-height: 1.7;
        }

        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding: 15px;
            }

            .auth-box {
                min-height: 720px;
            }

            .form-panel {
                width: 100%;
                padding: 70px 26px 35px;
            }

            .register-panel {
                display: none;
                opacity: 1;
                pointer-events: auto;
            }

            .auth-box.active .login-panel {
                display: none;
                transform: none;
            }

            .auth-box.active .register-panel {
                display: flex;
                transform: none;
            }

            .overlay {
                display: none;
            }
        }
    </style>
</head>

<body>

<?php
$loginError = $loginError ?? '';
$registerError = $registerError ?? '';
$registerSuccess = $registerSuccess ?? '';
$showRegister = $showRegister ?? false;
?>

<div
    class="auth-box <?= $showRegister ? 'active' : '' ?>"
    id="authBox"
>
    <a href="<?= BASE_URL ?>" class="back-home">
        <i class="fa-solid fa-arrow-left"></i>
        Trang chủ
    </a>

    <section class="form-panel login-panel">
        <h2>Đăng nhập</h2>
        <p class="subtitle">Đăng nhập để tiếp tục mua sắm</p>

        <?php if ($loginError !== ''): ?>
            <div class="alert-message">
                <?= htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php if ($registerSuccess !== ''): ?>
            <div class="alert-message success">
                <?= htmlspecialchars($registerSuccess, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="input-box">
                <input
                    type="email"
                    name="login_email"
                    placeholder="Email"
                    value="<?= htmlspecialchars(
                        $_POST['login_email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >
                <i class="fa-solid fa-envelope"></i>
            </div>

            <div class="input-box">
                <input
                    type="password"
                    name="login_password"
                    placeholder="Mật khẩu"
                    required
                >
                <i class="fa-solid fa-lock"></i>
            </div>

            <button
                type="submit"
                name="login"
                class="btn-submit"
            >
                Đăng nhập
            </button>
        </form>

        <p class="switch-text">
            Chưa có tài khoản?
            <a href="#" id="showRegister">Đăng ký</a>
        </p>
    </section>

    <section class="form-panel register-panel">
        <h2>Đăng ký</h2>
        <p class="subtitle">Tạo tài khoản mua sắm mới</p>

        <?php if ($registerError !== ''): ?>
            <div class="alert-message">
                <?= htmlspecialchars($registerError, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <div class="input-box">
                <input
                    type="text"
                    name="name"
                    placeholder="Họ và tên"
                    value="<?= htmlspecialchars(
                        $_POST['name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >
                <i class="fa-solid fa-user"></i>
            </div>

            <div class="input-box">
                <input
                    type="email"
                    name="register_email"
                    placeholder="Email"
                    value="<?= htmlspecialchars(
                        $_POST['register_email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >
                <i class="fa-solid fa-envelope"></i>
            </div>

            <div class="input-box">
                <input
                    type="tel"
                    name="phone_number"
                    placeholder="Số điện thoại"
                    value="<?= htmlspecialchars(
                        $_POST['phone_number'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                >
                <i class="fa-solid fa-phone"></i>
            </div>

            <div class="input-box">
                <input
                    type="password"
                    name="register_password"
                    placeholder="Mật khẩu"
                    required
                >
                <i class="fa-solid fa-lock"></i>
            </div>

            <div class="input-box">
                <input
                    type="password"
                    name="confirm_password"
                    placeholder="Nhập lại mật khẩu"
                    required
                >
                <i class="fa-solid fa-shield-halved"></i>
            </div>

            <button
                type="submit"
                name="register"
                class="btn-submit"
            >
                Đăng ký
            </button>
        </form>

        <p class="switch-text">
            Đã có tài khoản?
            <a href="#" id="showLogin">Đăng nhập</a>
        </p>
    </section>

    <aside class="overlay">
        <div class="overlay-icon">
            <i class="fa-solid fa-shoe-prints"></i>
        </div>

        <h1>WELCOME BACK!</h1>

        <p>
            Chào mừng bạn đến với Shoes Store.
            Đăng nhập hoặc tạo tài khoản để khám phá các sản phẩm mới nhất.
        </p>
    </aside>
</div>

<script>
    const authBox = document.getElementById('authBox');

    document
        .getElementById('showRegister')
        ?.addEventListener('click', event => {
            event.preventDefault();
            authBox.classList.add('active');
        });

    document
        .getElementById('showLogin')
        ?.addEventListener('click', event => {
            event.preventDefault();
            authBox.classList.remove('active');
        });

    setTimeout(() => {
        document.querySelectorAll('.alert-message').forEach(alert => {
            alert.style.transition = 'opacity .4s ease';
            alert.style.opacity = '0';

            setTimeout(() => alert.remove(), 400);
        });
    }, 3500);
</script>

</body>
</html>