const baseUrl = $('meta[name="base-url"]').attr('content');
const csrfToken = $('meta[name="csrf-token"]').attr('content');


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

function initInputmask()
{
    $(".currency").each(function() {

        let min = $(this).attr('min');
        let max = $(this).attr('max');
        let currencyOptions = {
            alias: "numeric",
            removeMaskOnSubmit: !0,
            rightAlign: 0,
            nullable: 0,
            digits: 0,
            prefix: "",
            placeholder: "",
            groupSeparator: "."
        }

        if(min) {
            currencyOptions.min = min;
        }

        if(max) {
            currencyOptions.max = max;
        }

        $(this).inputmask(currencyOptions);
    });

    $(".numeric").each(function() {

        let min = $(this).attr('min');
        let max = $(this).attr('max');
        let numericOptions = {
            "mask": "9{*}"
        }

        if(min) {
            numericOptions.min = min;
        }

        if(max) {
            numericOptions.max = max;
        }

        $(this).inputmask(numericOptions);
    });
}

function initSelect2(selector = '.init-select2')
{
    if ($(selector)[0]) {
        $(selector).each(function() {
            $(this).select2({
                placeholder: $(this).attr('placeholder'),
                allowClear: $(this).attr('allow-clear') == 'true' ? true : false,
                dropdownAutoWidth: true,
                width: '100%',
            });
        });
    }
}

function number_format (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function formatRupiah(angka)
{
    return number_format(angka, 0, ',', '.');
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

    initInputmask();
    initSelect2();
});
