const baseUrl = $('meta[name="base-url"]').attr('content');
const csrfToken = $('meta[name="csrf-token"]').attr('content');

function markActiveMenu(targetUrl)
{
    if ($(`a[href="${targetUrl}"]`)[0])
    {
        $(`a[href="${targetUrl}"]`).closest('.menu-item').addClass('active')
    }
}

function initDatatable(selector, options = {})
{
    if ($(selector)[0]) {
        return $(selector).DataTable({
            autoWidth: false,
            language:
            {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
            },
            ...options
        });

    }
}

$(document).ready(function()
{
    $(document).on('submit', 'form', function()
    {
        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i><span>Diproses...</span>');
    });

    $(document).on('focus', '.is-invalid', function()
    {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
        $(this).closest('.input-group').siblings('.invalid-feedback').remove();
    });
});
