$(document).ready(function ()
{
    $(document).on('click', '.btn-delete', function ()
    {
        let url = $(this).data('url');
        showConfirmDialog('Apakah anda yakin ingin menghapus data ini?', function ()
        {
            let deleteForm = $('#form-delete');
            deleteForm.attr('action', url);
            deleteForm.submit();
        });
    });
});
