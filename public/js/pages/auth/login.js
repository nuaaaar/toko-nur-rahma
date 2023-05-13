$(document).ready(function()
{
    $('.toggle-password').click(function()
    {
        $(this).find('i').toggleClass('hidden');
        var input = $($(this).data('toggle'));
        if (input.attr('type') == 'password')
        {
            input.attr('type', 'text');
        }
        else
        {
            input.attr('type', 'password');
        }
    });
});
