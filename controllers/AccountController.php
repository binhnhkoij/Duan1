<?php

class AccountController
{
    private function checkAdmin(): void
    {
        if (
            empty($_SESSION['user_id']) ||
            ($_SESSION['role'] ?? '') !== 'admin'
        ) {
            header(
                'Location: ' .
                BASE_URL .
                '?action=login'
            );

            exit;
        }
    }

    public function index(): void
    {
        $this->checkAdmin();

        $model = new AccountModel();

        $limit = 10;

        $page = max(
            1,
            (int) ($_GET['page'] ?? 1)
        );

        $totalUsers = $model->countAll();

        $totalPages = max(
            1,
            (int) ceil($totalUsers / $limit)
        );

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;

        $users = $model->getAll(
            $limit,
            $offset
        );

        $success =
            $_SESSION['account_success'] ?? '';

        $error =
            $_SESSION['account_error'] ?? '';

        unset(
            $_SESSION['account_success'],
            $_SESSION['account_error']
        );

        $title = 'Quản lý tài khoản';
        $view = 'accounts/index';

        require PATH_VIEW_MAIN;
    }

    public function update(): void
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectAccounts();
        }

        $id = (int) ($_POST['user_id'] ?? 0);

        $name = trim(
            $_POST['name'] ?? ''
        );

        $email = trim(
            $_POST['email'] ?? ''
        );

        $phoneNumber = trim(
            $_POST['phone_number'] ?? ''
        );

        $role = $_POST['role'] ?? 'user';

        if (
            $id <= 0 ||
            $name === '' ||
            $email === ''
        ) {
            $_SESSION['account_error'] =
                'Vui lòng nhập đầy đủ thông tin.';

            $this->redirectAccounts();
        }

        if (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {
            $_SESSION['account_error'] =
                'Email không đúng định dạng.';

            $this->redirectAccounts();
        }

        if (
            !in_array(
                $role,
                ['admin', 'user'],
                true
            )
        ) {
            $role = 'user';
        }

        $model = new AccountModel();

        if ($model->emailExists($email, $id)) {
            $_SESSION['account_error'] =
                'Email đã được sử dụng.';

            $this->redirectAccounts();
        }

        try {
            $model->update(
                $id,
                $name,
                $email,
                $phoneNumber,
                $role
            );

            if (
                $id ===
                (int) ($_SESSION['user_id'] ?? 0)
            ) {
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
            }

            $_SESSION['account_success'] =
                'Cập nhật tài khoản thành công.';
        } catch (Throwable $e) {
            $_SESSION['account_error'] =
                'Không thể cập nhật tài khoản.';
        }

        $this->redirectAccounts();
    }

    public function resetPassword(): void
    {
        $this->checkAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectAccounts();
        }

        $id = (int) (
            $_POST['user_id'] ?? 0
        );

        $newPassword = trim(
            $_POST['new_password'] ?? ''
        );

        if ($id <= 0) {
            $_SESSION['account_error'] =
                'Tài khoản không hợp lệ.';

            $this->redirectAccounts();
        }

        if (strlen($newPassword) < 5) {
            $_SESSION['account_error'] =
                'Mật khẩu phải có ít nhất 5 ký tự.';

            $this->redirectAccounts();
        }

        try {
            (new AccountModel())
                ->resetPassword(
                    $id,
                    $newPassword
                );

            $_SESSION['account_success'] =
                'Đặt lại mật khẩu thành công.';
        } catch (Throwable $e) {
            $_SESSION['account_error'] =
                'Không thể đặt lại mật khẩu.';
        }

        $this->redirectAccounts();
    }

    public function delete(): void
    {
        $this->checkAdmin();

        $id = (int) (
            $_GET['id'] ?? 0
        );

        $currentUserId = (int) (
            $_SESSION['user_id'] ?? 0
        );

        if ($id <= 0) {
            $_SESSION['account_error'] =
                'Tài khoản không hợp lệ.';

            $this->redirectAccounts();
        }

        if ($id === $currentUserId) {
            $_SESSION['account_error'] =
                'Bạn không thể tự xóa tài khoản của mình.';

            $this->redirectAccounts();
        }

        try {
            (new AccountModel())
                ->delete($id);

            $_SESSION['account_success'] =
                'Xóa tài khoản thành công.';
        } catch (Throwable $e) {
            $_SESSION['account_error'] =
                'Không thể xóa tài khoản vì đang có dữ liệu liên quan.';
        }

        $this->redirectAccounts();
    }

    private function redirectAccounts(): never
    {
        header(
            'Location: ' .
            BASE_URL .
            '?action=accounts'
        );

        exit;
    }
}