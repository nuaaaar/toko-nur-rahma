$(document).ready(function() {

    $(document).on('click', '.toggle-submenu', function()
    {
        $(this).parent().siblings('.has-submenu').removeClass('active');
        $(this).parent().siblings('.has-submenu').find('.submenu').slideUp('fast');
        $(this).parent().siblings('.has-submenu').find('.submenu-toggle-icon .fa-angle-down').removeClass('fa-angle-down').addClass('fa-angle-right');

        $(this).parent().toggleClass('active');
        $(this).parent().find('.submenu').slideToggle('fast');

        if($(this).parent().hasClass('active')) {
            $(this).find('.submenu-toggle-icon i').removeClass('fa-angle-right').addClass('fa-angle-down');
        }else{
            $(this).find('.submenu-toggle-icon i').removeClass('fa-angle-down').addClass('fa-angle-right');
        }

    });
});

function initSubmenu()
{
   if($('.has-submenu').length > 0) {
       $('.has-submenu').each(function() {
            if($(this).find('.submenu-toggle-icon').length == 0) {
               $(this).find('.toggle-submenu').append('<span class="submenu-toggle-icon"><i class="fal fa-angle-right"></i></span>');
            }
            if($(this).find('.submenu-icon').length == 0) {
                $(this).find('.submenu-item').find('a').prepend('<div class="submenu-icon">&#x2022;</div>');
            }
            if ($(this).hasClass('active')) {
                $(this).find('.submenu').slideDown('fast');
                $(this).find('.submenu-toggle-icon i').removeClass('fa-angle-right').addClass('fa-angle-down');
            }else{
                $(this).find('.submenu').hide();
                $(this).find('.submenu-toggle-icon i').removeClass('fa-angle-down').addClass('fa-angle-right');
            }
       });
   }
}

function markActiveMenu(targetUrl)
{
    if ($(`a[href="${targetUrl}"]`)[0])
    {
        $(`a[href="${targetUrl}"]`).closest('.menu-item').addClass('active');
        $(`a[href="${targetUrl}"]`).closest('.submenu-item').addClass('active');
    }

    initSubmenu();
}
