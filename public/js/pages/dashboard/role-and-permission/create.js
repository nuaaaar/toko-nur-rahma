$(document).ready(function ()
{
    let targetUrl = baseUrl + '/dashboard/role-and-permission';
    markActiveMenu(targetUrl);

    $(document).on('change', '.permission-checkbox', function ()
    {
        console.log('permission-checkbox changed');
        let permissionCheckboxesChecked = $('.permission-checkbox:checked');
        if (permissionCheckboxesChecked.length > 0) {
            $('#btn-create').removeAttr('disabled');
        } else {
            $('#btn-create').attr('disabled', 'disabled');
        }
    });
});
