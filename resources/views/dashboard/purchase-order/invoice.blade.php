<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Purchase Order </title>
<meta name="robots" content="noindex,nofollow" />
<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
<style type="text/css">
  @import url(https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900);

  * {
    font-family: 'Inter', sans-serif;
  }

  body {
    background: rgb(204, 204, 204);
  }

  page {
    background: white;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
  }

  page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
  }

  page[size="A4"][layout="portrait"] {
    width: 29.7cm;
    height: 21cm;
  }

  @media print {

    body,
    page {
      margin: 0;
      box-shadow: 0;
    }
  }
</style>

<page size="A4">
    <div style="padding: 5px;">
        <table width="100%">
            <tr>
                <td>
                    <strong style="font-size: 24px; color:  rgb(234 88 12)!important;">CV. Nur Rahma</strong>
                    <br>
                    &nbsp;
                </td>
                <td align="right">
                    <b>PURCHASE ORDER</b>
                    <br>
                    <small style="color:  rgb(234 88 12)!important;">{{ $purchase_order->invoice_number }}</small>
                </td>
            </tr>
        </table>
        <div style="display: flex">
            <table style="flex-grow: 1">
                <tr style="font-size: 14px;">
                    <td colspan="2">
                        <strong>DITERBITKAN ATAS NAMA</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="10%">
                        Penjual
                    </td>
                    <td>
                        : <strong>CV. Nur Rahma</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" height="100%"></td>
                </tr>
            </table>
            <table>
                <tr style="font-size: 14px;">
                    <td colspan="3">
                        <strong>UNTUK</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="30%" style="vertical-align: top;">
                        Pemesan
                    </td>
                    <td width="2%" style="vertical-align: top;">
                        :
                    </td>
                    <td style="vertical-align: top;">
                        <strong>{{ $purchase_order->customer->name ?? '' }}</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="30%" style="vertical-align: top; text-wrap: nowrap">
                        Tanggal PO
                    </td>
                    <td width="2%" style="vertical-align: top;">
                        :
                    </td>
                    <td style="vertical-align: top;">
                        <strong>{{ $purchase_order->date->isoFormat('D MMMM Y'); }}</strong>
                    </td>
                </tr>
            </table>
        </div>
        <table width="100%" style="margin-top: 20px;">
            <tr>
                <td height="1" style="border-top: 2px solid black;" colspan="4"></td>
            </tr>
            <tr style="font-size: 12px;">
                <td width="50%" style="padding: 10px;">
                    <strong>INFO PRODUK</strong>
                </td>
                <td width="10%" align="right">
                    <strong>JUMLAH</strong>
                </td>
                <td width="20%" align="right">
                    <strong>HARGA SATUAN</strong>
                </td>
                <td width="20%" align="right">
                    <strong>TOTAL HARGA</strong>
                </td>
            </tr>
            <tr>
                <td height="1" style="border-bottom: 2px solid black;" colspan="4"></td>
            </tr>
            @foreach ($purchase_order->purchaseOrderItems as $purchaseOrderItem)
                <tr style="font-size: 12px;">
                    <td width="50%" style="padding: 10px;">
                        <strong style="color:  rgb(234 88 12)!important; font-size: 14px;">{{ $purchaseOrderItem->product->name }} / {{ $purchaseOrderItem->product->unit }}</strong>
                    </td>
                    <td width="10%" align="right">
                        {{ $purchaseOrderItem->qty }}
                    </td>
                    <td width="20%" align="right">
                        Rp{{ number_format($purchaseOrderItem->selling_price, 0, ',', '.') }}
                    </td>
                    <td width="20%" align="right">
                        Rp{{ number_format($purchaseOrderItem->selling_price_total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td height="1" style="border-bottom: 0.5px solid gray;" colspan="4"></td>
            </tr>
            <tr>
                <td height="15" colspan="4"></td>
            </tr>
            <tr style="font-size: 12px;">
                <td width="50%" height="10"></td>
                <td width="20%" colspan="2" align="left">
                    <strong>TOTAL HARGA ({{ $purchase_order->purchaseOrderItems->sum('qty') }} BARANG)</strong>
                </td>
                <td width="20%" align="right">
                    Rp{{ number_format($purchase_order->total, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td height="10" style="border-bottom: 0.5px solid gray;" colspan="4"></td>
            </tr>
            <tr style="font-size: 12px;">
                <td colspan="2"></td>
                <td style="vertical-align: top;" colspan="2">
                    <div style="width: 60%; margin-left: auto">
                        <div style="text-align:center; display:flex; flex-direction: column; justify-content: between">
                            <div>
                                <p style="text-align:left">Balikpapan, </p>
                                <p style="margin-bottom: 60px;">Hormat Kami,</p>
                            </div>
                            <div>
                                <p>(....................................)</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</page>

<script>
    function printPage()
    {
        window.print();
    }
    window.onload = function ()
    {
        printPage();
    }
</script>

