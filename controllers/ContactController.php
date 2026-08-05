<?php

class ContactController
{
    public function index(): void
    {
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($name === '' || $email === '' || $message === '') {
                $error = 'Vui lòng nhập đầy đủ các thông tin bắt buộc.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không đúng định dạng.';
            } else {
                /*
                 * Hiện tại chỉ hiển thị thông báo thành công.
                 * Sau này có thể thêm lưu database hoặc gửi email.
                 */

                $success = 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!';

                $_POST = [];
            }
        }

        $title = 'Liên hệ';
        $view = 'contact/index';

        require PATH_VIEW_MAIN;
    }
}