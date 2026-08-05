<?php

class CategoryController
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
        $this->checkAdmin();

        $model = new CategoryModel();
        $categories = $model->getAll();

        $error = '';
        $editCategory = null;

        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];

            foreach ($categories as $category) {
                if ((int) $category['Category_id'] === $editId) {
                    $editCategory = $category;
                    break;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['category_name'] ?? '');
            $id = (int) ($_POST['category_id'] ?? 0);

            if ($name === '') {
                $error = 'Vui lòng nhập tên danh mục.';
            } else {
                if ($id > 0) {
                    $model->update($id, $name);
                } else {
                    $model->create($name);
                }

                header('Location: ' . BASE_URL . '?action=categories');
                exit;
            }
        }

        require PATH_VIEW . 'categories/index.php';
    }

    public function delete(): void
    {
        $this->checkAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            try {
                (new CategoryModel())->delete($id);
            } catch (Throwable $e) {
                // Danh mục đang có sản phẩm thì database có thể không cho xóa.
            }
        }

        header('Location: ' . BASE_URL . '?action=categories');
        exit;
    }
}