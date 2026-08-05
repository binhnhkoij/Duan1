<?php

class SizeController
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

        $model = new SizeModel();
        $sizes = $model->getAll();

        $error = '';
        $editSize = null;

        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];

            foreach ($sizes as $size) {
                if ((int) $size['Size_id'] === $editId) {
                    $editSize = $size;
                    break;
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['size_name'] ?? '');
            $id = (int) ($_POST['size_id'] ?? 0);

            if ($name === '') {
                $error = 'Vui lòng nhập kích thước.';
            } else {
                if ($id > 0) {
                    $model->update($id, $name);
                } else {
                    $model->create($name);
                }

                header('Location: ' . BASE_URL . '?action=sizes');
                exit;
            }
        }

        require PATH_VIEW . 'sizes/index.php';
    }

    public function delete(): void
    {
        $this->checkAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            try {
                (new SizeModel())->delete($id);
            } catch (Throwable $e) {
                // Kích thước đang được biến thể sử dụng thì có thể không xóa được.
            }
        }

        header('Location: ' . BASE_URL . '?action=sizes');
        exit;
    }
}