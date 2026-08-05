const editModal = document.getElementById('editModal');
editModal?.addEventListener(
    'show.bs.modal',
    event => {
        const button = event.relatedTarget;

        document.getElementById('edit-id').value =
            button.dataset.id;

        document.getElementById('edit-name').value =
            button.dataset.name;

        document.getElementById('edit-email').value =
            button.dataset.email;

        document.getElementById('edit-phone').value =
            button.dataset.phone;

        document.getElementById('edit-role').value =
            button.dataset.role;
    }
);
const resetModal =
    document.getElementById('resetModal');
    resetModal?.addEventListener(
    'show.bs.modal',
    event => {
        const button = event.relatedTarget;

        document.getElementById('reset-id').value =
            button.dataset.id;

        document.getElementById('reset-name').textContent =
            button.dataset.name;

        document.getElementById('new-password').value = '';
    }
);