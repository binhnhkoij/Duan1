<?php

class AuthController
{
    public function form(): void
    {
        $loginError = '';
        $registerError = '';
        $registerSuccess = '';
        $showRegister = false;
        $userModel = new UserModel();

        if (isset($_POST['login'])) {
            $email = trim($_POST['login_email'] ?? '');
            $password = $_POST['login_password'] ?? '';
            $user = $userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                $loginError = 'Sai email hoặc mật khẩu.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['User_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                if ($user['role'] === 'admin') {
                header('Location: ' . BASE_URL . '?action=admin');
                } else {
                header('Location: ' . BASE_URL);
                    }
                exit;
            }
        }

        if (isset($_POST['register'])) {
            $showRegister = true;
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['register_email'] ?? '');
            $phone = trim($_POST['phone_number'] ?? '');
            $password = $_POST['register_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if (mb_strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $registerError = 'Thông tin đăng ký chưa hợp lệ.';
            } elseif (strlen($password) < 8) {
                $registerError = 'Mật khẩu phải có ít nhất 8 ký tự.';
            } elseif ($password !== $confirm) {
                $registerError = 'Mật khẩu nhập lại không khớp.';
            } elseif ($userModel->emailExists($email)) {
                $registerError = 'Email này đã được sử dụng.';
            } else {
                $userModel->create($name, $email, $password, $phone);
                $registerSuccess = 'Đăng ký thành công. Bạn hãy đăng nhập.';
                $showRegister = false;
            }
        }

        require PATH_VIEW . 'auth/form.php';
    }

   public function logout(): void
{
    $_SESSION = [];
    session_destroy();

    header('Location: ' . BASE_URL);
    exit;
}
}
