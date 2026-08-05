<?php

class ProductController
{
    private function checkAdmin(): void
    {
        if (
            empty($_SESSION['user_id']) ||
            ($_SESSION['role'] ?? '') !== 'admin'
        ) {
            header('Location: ' . BASE_URL . '?action=login');
            exit;
        }
    }

    public function index(): void
    {
        $model = new ProductModel();

        $categoryId = (int) ($_GET['category'] ?? 0);

        if ($categoryId > 0) {
            $products = $model->getByCategory($categoryId);
        } else {
            $products = $model->getAll();
        }

        $title = 'Sản phẩm';
        $view = 'products/shop-index';

        require PATH_VIEW_MAIN;
    }

    public function adminIndex(): void
    {
        $this->checkAdmin();

        $model = new ProductModel();

        $categoryId = (int) ($_GET['category'] ?? 0);

        if ($categoryId > 0) {
            $products = $model->getByCategory($categoryId);
        } else {
            $products = $model->getAll();
        }

        $title = 'Quản lý sản phẩm';
        $view = 'products/admin-index';

        require PATH_VIEW_MAIN;
    }

    public function detail(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            http_response_code(404);

            $title = 'Không tìm thấy sản phẩm';
            $view = 'products/not-found';

            require PATH_VIEW_MAIN;
            return;
        }

        $variants = $model->variants($id);

        $related = $model->related(
            (int) $product['Category_id'],
            $id
        );

        $title = $product['Product_name'];
        $view = 'products/detail';

        require PATH_VIEW_MAIN;
    }

    public function create(): void
    {
        $this->checkAdmin();

        $model = new ProductModel();

        $categories = $model->getCategories();
        $sizes = $model->getSizes();
        $colors = $model->getColors();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productName = trim($_POST['product_name'] ?? '');
            $categoryId = (int) ($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $status = (int) ($_POST['status'] ?? 1);

            $sizeIds = $_POST['size_id'] ?? [];
            $colorIds = $_POST['color_id'] ?? [];
            $prices = $_POST['price'] ?? [];
            $stocks = $_POST['stock'] ?? [];

            if ($productName === '' || $categoryId <= 0) {
                $error = 'Vui lòng nhập đầy đủ thông tin sản phẩm.';
            } elseif (empty($sizeIds)) {
                $error = 'Vui lòng thêm ít nhất một biến thể.';
            } elseif (
                empty($_FILES['base_image']['name']) ||
                ($_FILES['base_image']['error'] ?? UPLOAD_ERR_NO_FILE)
                    !== UPLOAD_ERR_OK
            ) {
                $error = 'Vui lòng chọn ảnh sản phẩm.';
            } else {
                $extension = strtolower(
                    pathinfo(
                        $_FILES['base_image']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $allowedExtensions = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ];

                if (!in_array($extension, $allowedExtensions, true)) {
                    $error = 'Ảnh phải có định dạng JPG, PNG hoặc WEBP.';
                } else {
                    $imageName =
                        time() . '_' . uniqid() . '.' . $extension;

                    $uploadSuccess = move_uploaded_file(
                        $_FILES['base_image']['tmp_name'],
                        PATH_ASSETS_UPLOADS . $imageName
                    );

                    if (!$uploadSuccess) {
                        $error = 'Không thể tải ảnh sản phẩm lên.';
                    } else {
                        $variants = [];

                        foreach ($sizeIds as $index => $sizeId) {
                            $variants[] = [
                                'size_id' => (int) $sizeId,
                                'color_id' => (int) (
                                    $colorIds[$index] ?? 0
                                ),
                                'price' => (float) (
                                    $prices[$index] ?? 0
                                ),
                                'stock' => (int) (
                                    $stocks[$index] ?? 0
                                )
                            ];
                        }

                        try {
                            $model->createWithVariants(
                                [
                                    'product_name' => $productName,
                                    'category_id' => $categoryId,
                                    'description' => $description,
                                    'base_image' => $imageName,
                                    'status' => $status
                                ],
                                $variants
                            );

                            header(
                                'Location: ' .
                                BASE_URL .
                                '?action=admin-products'
                            );
                            exit;
                        } catch (Throwable $e) {
                            $imagePath =
                                PATH_ASSETS_UPLOADS . $imageName;

                            if (is_file($imagePath)) {
                                unlink($imagePath);
                            }

                            $error = 'Không thể thêm sản phẩm.';
                        }
                    }
                }
            }
        }

        require PATH_VIEW . 'products/create.php';
    }

    public function edit(): void
    {
        $this->checkAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $model = new ProductModel();
        $product = $model->find($id);

        if (!$product) {
            header(
                'Location: ' .
                BASE_URL .
                '?action=admin-products'
            );
            exit;
        }

        $variants = $model->variants($id);
        $categories = $model->getCategories();
        $sizes = $model->getSizes();
        $colors = $model->getColors();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productName = trim($_POST['product_name'] ?? '');
            $categoryId = (int) ($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $status = (int) ($_POST['status'] ?? 1);

            $sizeIds = $_POST['size_id'] ?? [];
            $colorIds = $_POST['color_id'] ?? [];
            $prices = $_POST['price'] ?? [];
            $stocks = $_POST['stock'] ?? [];

            $imageName = $product['Base_image'] ?? '';
            $oldImageName = $imageName;
            $newImageUploaded = false;

            if (!empty($_FILES['base_image']['name'])) {
                $extension = strtolower(
                    pathinfo(
                        $_FILES['base_image']['name'],
                        PATHINFO_EXTENSION
                    )
                );

                $allowedExtensions = [
                    'jpg',
                    'jpeg',
                    'png',
                    'webp'
                ];

                if (!in_array($extension, $allowedExtensions, true)) {
                    $error = 'Ảnh phải có định dạng JPG, PNG hoặc WEBP.';
                } else {
                    $imageName =
                        time() . '_' . uniqid() . '.' . $extension;

                    $newImageUploaded = move_uploaded_file(
                        $_FILES['base_image']['tmp_name'],
                        PATH_ASSETS_UPLOADS . $imageName
                    );

                    if (!$newImageUploaded) {
                        $error = 'Không thể tải ảnh mới lên.';
                    }
                }
            }

            if ($error === '') {
                if ($productName === '' || $categoryId <= 0) {
                    $error = 'Vui lòng nhập đầy đủ thông tin.';
                } elseif (empty($sizeIds)) {
                    $error = 'Sản phẩm phải có ít nhất một biến thể.';
                } else {
                    $newVariants = [];

                    foreach ($sizeIds as $index => $sizeId) {
                        $newVariants[] = [
                            'size_id' => (int) $sizeId,
                            'color_id' => (int) (
                                $colorIds[$index] ?? 0
                            ),
                            'price' => (float) (
                                $prices[$index] ?? 0
                            ),
                            'stock' => (int) (
                                $stocks[$index] ?? 0
                            )
                        ];
                    }

                    try {
                        $model->updateWithVariants(
                            $id,
                            [
                                'product_name' => $productName,
                                'category_id' => $categoryId,
                                'description' => $description,
                                'base_image' => $imageName,
                                'status' => $status
                            ],
                            $newVariants
                        );

                        if (
                            $newImageUploaded &&
                            $oldImageName !== '' &&
                            $oldImageName !== $imageName
                        ) {
                            $oldImagePath =
                                PATH_ASSETS_UPLOADS . $oldImageName;

                            if (is_file($oldImagePath)) {
                                unlink($oldImagePath);
                            }
                        }

                        header(
                            'Location: ' .
                            BASE_URL .
                            '?action=admin-products'
                        );
                        exit;
                    } catch (Throwable $e) {
                        if ($newImageUploaded) {
                            $newImagePath =
                                PATH_ASSETS_UPLOADS . $imageName;

                            if (is_file($newImagePath)) {
                                unlink($newImagePath);
                            }
                        }

                        $error = 'Không thể cập nhật sản phẩm.';
                    }
                }
            }
        }

        require PATH_VIEW . 'products/edit.php';
    }

    public function delete(): void
    {
        $this->checkAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            header(
                'Location: ' .
                BASE_URL .
                '?action=admin-products'
            );
            exit;
        }

        $model = new ProductModel();
        $product = $model->find($id);

        if ($product) {
            try {
                $model->deleteProduct($id);

                $imageName = $product['Base_image'] ?? '';
                $imagePath = PATH_ASSETS_UPLOADS . $imageName;

                if ($imageName !== '' && is_file($imagePath)) {
                    unlink($imagePath);
                }
            } catch (Throwable $e) {
                // Có thể bổ sung thông báo lỗi bằng session sau.
            }
        }

        header(
            'Location: ' .
            BASE_URL .
            '?action=admin-products'
        );
        exit;
    }
}