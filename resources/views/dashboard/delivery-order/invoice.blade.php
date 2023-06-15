<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Jalan</title>
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
                    <b>SURAT JALAN</b>
                    <br>
                    <small style="color:  rgb(234 88 12)!important;">{{ $delivery_order->invoice_number }}</small>
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
                        Pengirim
                    </td>
                    <td>
                        : <strong>CV. Nur Rahma</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="10%" style="text-wrap:nowrap">
                        Nomor PO
                    </td>
                    <td>
                        : <strong>{{ $delivery_order->purchaseOrder->invoice_number }}</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td colspan="2">
                        &nbsp;
                    </td>
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
                        Penerima
                    </td>
                    <td width="2%" style="vertical-align: top;">
                        :
                    </td>
                    <td style="vertical-align: top; text-wrap: nowrap">
                        <strong>{{ $delivery_order->receiver_name ?? '' }}</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="30%" style="vertical-align: top;">
                        No. Telp Penerima
                    </td>
                    <td width="2%" style="vertical-align: top;">
                        :
                    </td>
                    <td style="vertical-align: top; text-wrap: nowrap">
                        <strong>{{ $delivery_order->receiver_phone_number ?? '' }}</strong>
                    </td>
                </tr>
                <tr style="font-size: 12px;">
                    <td width="30%" style="vertical-align: top;">
                        Alamat Penerima
                    </td>
                    <td width="2%" style="vertical-align: top;">
                        :
                    </td>
                    <td style="vertical-align: top; width: 32ch">
                        <strong>{{ $delivery_order->receiver_address ?? '' }}</strong>
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
                <td width="10%" align="center">
                    <strong>JUMLAH</strong>
                </td>
                <td style="text-align: center">
                    <strong>Keterangan</strong>
                </td>
            </tr>
            <tr>
                <td height="1" style="border-bottom: 2px solid black;" colspan="4"></td>
            </tr>
            @foreach ($delivery_order->deliveryOrderItems as $deliveryOrderItem)
                <tr style="font-size: 12px;">
                    <td width="50%" style="padding: 10px;">
                        <strong style="color:  rgb(234 88 12)!important; font-size: 14px;">{{ $deliveryOrderItem->product->name }} / {{ $deliveryOrderItem->product->unit }}</strong>
                    </td>
                    <td width="10%" align="center">
                        {{ $deliveryOrderItem->qty }} {{  $deliveryOrderItem->product->unit }}
                    </td>
                    <td></td>
                </tr>
            @endforeach
            <tr>
                <td height="1" style="border-bottom: 0.5px solid gray;" colspan="3"></td>
            </tr>
            <tr>
                <td height="20px" colspan="3"></td>
            </tr>
            <tr style="font-size: 12px;">
                <td colspan="2" style="vertical-align: top">
                    <small>
                        Catatan :
                        <ul>
                            <li>Barang - barang tersebut, diatas telah diterima dalam keadaan baik</li>
                            <li>Barang yang sudah diterima tidak dapat dikembalikan atau ditukar</li>
                            <li>Tanpa Invoice Asli, Surat Jalan ini tidak berlaku untuk penagihan.</li>
                        </ul>
                    </small>
                    <div style="text-align:center; display: inline-flex">
                        <div style="padding: 5px; border: 1px solid black; ">
                            <h4 style="margin: 0">Tanggal</h4>
                            <h4 style="margin: 0">Jam</h4>
                            <p style="margin: 16px 0 0 0; font-size: 12px">Diterima dengan baik</p>
                        </div>
                        <div style="border: 1px solid black; width: 128px"></div>
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <div style="width: 60%; margin-left: auto">
                        <div style="text-align:center; display:flex; flex-direction: column; justify-content: between">
                            <div>
                                <p style="text-align:left;">Balikpapan, </p>
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

