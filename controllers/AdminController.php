<?php

class AdminController
{
    public function index(): void
    {
        if (
            empty($_SESSION['user_id']) ||
            ($_SESSION['role'] ?? '') !== 'admin'
        ) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }

        $model = new AdminModel();

        $stats = [
            'users'      => $model->countTable('users'),
            'products'   => $model->countTable('products'),
            'orders'     => $model->countTable('orders'),
            'categories' => $model->countTable('categories'),
            'colors'     => $model->countTable('colors'),
            'sizes'      => $model->countTable('sizes')
        ];

        $adminName = $_SESSION['name'] ?? 'Quản trị viên';

        require PATH_VIEW . 'admin/dashboard.php';
    }
}