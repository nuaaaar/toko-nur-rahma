$(document).ready(function()
{
    let targetUrl = baseUrl + location.pathname
    markActiveMenu(targetUrl);

    initDatatable('.datatable');
});
