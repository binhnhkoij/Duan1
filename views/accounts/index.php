<?php
$users = $users ?? [];
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
$success = $success ?? '';
$error = $error ?? '';
?>

<link
    rel="stylesheet"
    href="<?= BASE_URL ?>assets/css/accounts.css"
>

<section class="account-page">

    <div class="account-box">

        <h2 class="account-title">
            <i class="fa-solid fa-users-gear me-2"></i>
            Quản lý tài khoản người dùng
        </h2>

        <?php if ($success !== ''): ?>
            <div class="account-alert success">
                <?= htmlspecialchars(
                    $success,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="account-alert error">
                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </div>
        <?php endif; ?>

        <div class="table-responsive">

            <table class="table table-hover account-table">

                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($users)): ?>

                    <?php foreach ($users as $user): ?>

                        <?php
                        $userId = (int) (
                            $user['User_id'] ?? 0
                        );

                        $name =
                            $user['name'] ?? '';

                        $email =
                            $user['email'] ?? '';

                        $phoneNumber =
                            $user['phone_number'] ?? '';

                        $role =
                            $user['role'] ?? 'user';
                        ?>

                        <tr>

                            <td>
                                <?= $userId ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $name,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $email,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $phoneNumber !== ''
                                        ? $phoneNumber
                                        : 'Chưa có',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <td>
                                <?php if ($role === 'admin'): ?>

                                    <span class="role-admin">
                                        Admin
                                    </span>

                                <?php else: ?>

                                    <span class="role-user">
                                        User
                                    </span>

                                <?php endif; ?>
                            </td>

                            <td>

                                <div
                                    class="d-flex flex-wrap justify-content-center gap-1"
                                >

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-account btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-id="<?= $userId ?>"
                                        data-name="<?= htmlspecialchars(
                                            $name,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        data-email="<?= htmlspecialchars(
                                            $email,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        data-phone="<?= htmlspecialchars(
                                            $phoneNumber,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        data-role="<?= htmlspecialchars(
                                            $role,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                        Sửa
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-account btn-reset"
                                        data-bs-toggle="modal"
                                        data-bs-target="#resetModal"
                                        data-id="<?= $userId ?>"
                                        data-name="<?= htmlspecialchars(
                                            $name,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >
                                        <i class="fa-solid fa-key"></i>
                                        Đặt lại MK
                                    </button>

                                    <?php if (
                                        $userId !==
                                        (int) (
                                            $_SESSION['user_id'] ?? 0
                                        )
                                    ): ?>

                                        <a
                                            href="<?= BASE_URL ?>?action=account-delete&id=<?= $userId ?>"
                                            class="btn btn-sm btn-account btn-delete"
                                            onclick="return confirm(
                                                'Bạn có chắc muốn xóa tài khoản này?'
                                            )"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                            Xóa
                                        </a>

                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td
                            colspan="6"
                            class="text-center py-5 text-muted"
                        >
                            Chưa có tài khoản nào.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

        <?php if ($totalPages > 1): ?>

            <nav class="mt-4">

                <ul class="pagination justify-content-center">

                    <?php for (
                        $i = 1;
                        $i <= $totalPages;
                        $i++
                    ): ?>

                        <li
                            class="page-item <?= $i === (int) $page
                                ? 'active'
                                : ''
                            ?>"
                        >
                            <a
                                class="page-link"
                                href="<?= BASE_URL ?>?action=accounts&page=<?= $i ?>"
                            >
                                <?= $i ?>
                            </a>
                        </li>

                    <?php endfor; ?>

                </ul>

            </nav>

        <?php endif; ?>

        <div class="text-center mt-4">

            <a
                href="<?= BASE_URL ?>?action=admin"
                class="btn btn-outline-secondary"
            >
                <i class="fa-solid fa-arrow-left me-1"></i>
                Quay lại trang admin
            </a>

        </div>

    </div>

</section>

<!-- Modal sửa tài khoản -->
<div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="fa-solid fa-user-pen me-1"></i>
                    Sửa thông tin tài khoản
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                method="POST"
                action="<?= BASE_URL ?>?action=account-update"
            >

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="user_id"
                        id="edit-id"
                    >

                    <div class="mb-3">

                        <label
                            for="edit-name"
                            class="form-label"
                        >
                            Họ và tên
                        </label>

                        <input
                            type="text"
                            name="name"
                            id="edit-name"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="edit-email"
                            class="form-label"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="edit-email"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="edit-phone"
                            class="form-label"
                        >
                            Số điện thoại
                        </label>

                        <input
                            type="text"
                            name="phone_number"
                            id="edit-phone"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="edit-role"
                            class="form-label"
                        >
                            Vai trò
                        </label>

                        <select
                            name="role"
                            id="edit-role"
                            class="form-select"
                        >
                            <option value="user">
                                User
                            </option>

                            <option value="admin">
                                Admin
                            </option>
                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Hủy
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Lưu thay đổi
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

<!-- Modal đặt lại mật khẩu -->
<div
    class="modal fade"
    id="resetModal"
    tabindex="-1"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="fa-solid fa-key me-1"></i>
                    Đặt lại mật khẩu
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <form
                method="POST"
                action="<?= BASE_URL ?>?action=account-reset-password"
            >

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="user_id"
                        id="reset-id"
                    >

                    <p>
                        Đặt lại mật khẩu cho:
                        <strong id="reset-name"></strong>
                    </p>

                    <div class="mb-3">

                        <label
                            for="new-password"
                            class="form-label"
                        >
                            Mật khẩu mới
                        </label>

                        <input
                            type="password"
                            name="new_password"
                            id="new-password"
                            class="form-control"
                            minlength="5"
                            required
                        >

                        <small class="text-muted">
                            Mật khẩu tối thiểu 5 ký tự.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Hủy
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Lưu mật khẩu
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

<script src="<?= BASE_URL ?>assets/js/accounts.js"></script>