<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= config("App")->name ?> | <?= config("Company")->name ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="<?= base_url('public/adminlte') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/dist/css/adminlte.min.css">
    <!-- Datatable -->
    <link href="<?= base_url('/public/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" type="text/css">

    <style type='text/css'>
    @page {
        size: auto;
    }
    </style>

    <script type='text/javascript'>
    window.print();
    </script>
</head>

<body>

    <table class='table table-bordered'>
        <tbody>
            <tr>
                <td class='text-center'>
                    <h2>SURAT JALAN</h2>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table class='table table-bordered'>
        <tbody>
            <tr>
                <td width="40%">
                    <b><?= strtoupper(config("App")->ptName) ?></b>
                    <br>
                    <?= config("App")->companyAddress ?>
                    <br>
                    <?= config("App")->companyPhone ?>
                </td>
                <td width="30%">
                    <b><?= $contact->name ?></b>
                    <br>
                    <?= $sale->invoice_address ?>
                    <br>
                    <?= $contact->phone ?>
                </td>
                <td>
                    <b>Jenis Transaksi</b>
                    <br>
                    <?= $sale->transaction_type ?>
                    <br>
                    <b>No. Transaksi (SO)</b>
                    <br>
                    <?= $sale->number ?>
                    <br>
                    <b>Tanggal Berangkat</b>
                    <br>
                    <?= date("d-m-Y", strtotime($delivery->sent_date)) ?>
                    <br>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class='text-center'>Barang</th>
                <th class='text-center'>Lokasi Barang</th>
                <th class='text-center'>Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            <?php            
            $sumPrice = 0;
            foreach($delivery_items as $item){
                $thisSaleItem = $db->table("sale_items");
                $thisSaleItem->where("id",$item->sale_item_id);
                $thisSaleItem = $thisSaleItem->get();
                $thisSaleItem = $thisSaleItem->getFirstRow();
                
                $thisWarehouse = $db->table('product_stocks');
                $thisWarehouse->select(['warehouses.name as warehouse_name','warehouses.initials as warehouse_inisial']);
                $thisWarehouse->join('warehouses','product_stocks.warehouse_id = warehouses.id','left');
                $thisWarehouse->where('product_stocks.sale_item_id',$item->sale_item_id);
                $thisWarehouse = $thisWarehouse->get();
                $thisWarehouse = $thisWarehouse->getFirstRow();

                $thisProduct = $db->table("products");
                $thisProduct->where("id",$thisSaleItem->product_id);
                $thisProduct = $thisProduct->get();
                $thisProduct = $thisProduct->getFirstRow();
                ?>
            <tr>
                <td><?= $thisProduct->name ?></td>
                <td class="text-center"><?= $thisWarehouse->warehouse_inisial ?></td>
                <td class='text-right'><?= $item->quantity ?> <?= $thisProduct->unit ?></td>                
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="60%">
                    <b>Catatan :</b>
                    <br>
                    <?= nl2br($delivery->warehouse_notes) ?>
                </td>
                <td class='text-center'>
                    &nbsp;
                    <br>
                    Penerima
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>(..............................................)</u>
                </td>
                <td class='text-center'>
                    &nbsp;
                    <br>
                    Sopir
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>(..............................................)</u>
                </td>
                <td class='text-center'>
                    <?= date("d-m-Y") ?>
                    <br>
                    Admin
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>(..............................................)</u>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>