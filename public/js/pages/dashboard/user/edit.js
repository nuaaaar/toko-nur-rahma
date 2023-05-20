$(document).ready(function ()
{
    let targetUrl = baseUrl + '/dashboard/user';
    markActiveMenu(targetUrl);

    $(document).on('change', 'input[name=password]', function()
    {
        let password = $(this).val();

        if (password.length > 0)
        {
            $('input[name=password_confirmation]').attr('required', 'required');
        }
    });
});
