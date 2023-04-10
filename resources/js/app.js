import './bootstrap';
import 'flowbite';
import feather from 'feather-icons';

feather.replace();

$(document).ready(function()
{
    let targetUrl = location.protocol + '//' + location.host + location.pathname
    console.log({targetUrl});
    markActiveMenu(targetUrl);

    $(document).on('submit', 'form', function()
    {
        $(this).find('button[type="submit"]').prop('disabled', true);
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Diproses...');
    });

    $(document).on('focus', '.is-invalid', function()
    {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove();
        $(this).closest('.input-group').siblings('.invalid-feedback').remove();
    });
});

function markActiveMenu(targetUrl) {
    if ($(`a[href="${targetUrl}"]`)[0]) {
        $(`a[href="${targetUrl}"]`).closest('.menu-item').addClass('active')
    }
}
