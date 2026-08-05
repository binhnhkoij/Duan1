<?php

class HomeController
{
    public function index(): void
    {
        $products = (new ProductModel())->latest();
        $title = 'Trang chủ';
        $view = 'home';
        require PATH_VIEW_MAIN;
    }
}
