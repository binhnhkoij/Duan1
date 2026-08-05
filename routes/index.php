<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/' => (new HomeController())->index(),

    // Sản phẩm cho khách
    'products' => (new ProductController())->index(),
    'product-detail' => (new ProductController())->detail(),

    // Sản phẩm cho admin
    'admin-products' => (new ProductController())->adminIndex(),
    'product-create' => (new ProductController())->create(),
    'product-edit' => (new ProductController())->edit(),
    'product-delete' => (new ProductController())->delete(),

    // Đăng nhập
    'login' => (new AuthController())->form(),
    'register' => (new AuthController())->form(),
    'logout' => (new AuthController())->logout(),

    // Trang admin
    'admin' => (new AdminController())->index(),

    // Danh mục
    'categories' => (new CategoryController())->index(),
    'category-delete' => (new CategoryController())->delete(),

    // Màu sắc
    'colors' => (new ColorController())->index(),
    'color-delete' => (new ColorController())->delete(),

    // Kích thước
    'sizes' => (new SizeController())->index(),
    'size-delete' => (new SizeController())->delete(),

    // Liên hệ
    'contact' => (new ContactController())->index(),

    // Tài khoản
    'accounts' => (new AccountController())->index(),
    'account-update' => (new AccountController())->update(),
    'account-reset-password' => (new AccountController())->resetPassword(),
    'account-delete' => (new AccountController())->delete(),

    default => die('404 - Không tìm thấy trang'),
};