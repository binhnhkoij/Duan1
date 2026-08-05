<?php

class ColorController
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

        $model = new ColorModel();
        $colors = $model->getAll();

        $error = '';
        $editColor = null;

        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];

            foreach ($colors as $color) {
                if ((int) $color['Color_id'] === $editId) {
                    $editColor = $color;
                    break;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['color_name'] ?? '');
            $id = (int) ($_POST['color_id'] ?? 0);

            if ($name === '') {
                $error = 'Vui lòng nhập tên màu.';
            } else {
                if ($id > 0) {
                    $model->update($id, $name);
                } else {
                    $model->create($name);
                }

                header('Location: ' . BASE_URL . '?action=colors');
                exit;
            }
        }

        require PATH_VIEW . 'colors/index.php';
    }

    public function delete(): void
    {
        $this->checkAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            try {
                (new ColorModel())->delete($id);
            } catch (Throwable $e) {
                // Màu đang được biến thể sử dụng thì có thể không xóa được.
            }
        }

        header('Location: ' . BASE_URL . '?action=colors');
        exit;
    }
}