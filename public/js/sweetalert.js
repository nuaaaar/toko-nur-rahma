function showSuccessDialog(message) {
    Swal.fire({
        title: 'Berhasil!',
        text: message,
        icon: 'success',
        customClass: {
            confirmButton: 'btn btn-primary',
        },
        buttonsStyling: false
    });
}

function showErrorDialog(message) {
    Swal.fire({
        title: 'Gagal!',
        text: message,
        icon: 'error',
        customClass: {
            confirmButton: 'btn btn-primary',
        },
        buttonsStyling: false
    });
}

function showConfirmDialog(message, confirmCallback) {
    return Swal.fire({
        title: 'Apakah anda yakin?',
        text: message,
        icon: 'warning',
        customClass: {
            confirmButton: 'btn btn-primary',
        },
        showCancelButton: true,
        confirmButtonText: 'Ya, saya yakin',
        cancelButtonText: 'Batalkan',
    }).then((result) => {
        if (result.isConfirmed) {
            confirmCallback();
            return true;
        }
        return false;
    })
}

function showFormDialog(title, html, confirmCallback) {
    Swal.fire({
        title: title,
        html,
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-secondary'
        },
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batalkan',
        willOpen: (dom) => {
        },
        preConfirm: () => {
            return confirmCallback();
        }
    })
}
