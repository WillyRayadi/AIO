<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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
    
    <h1 class="text-center">Manifest SO</h1><br>

<div class="row" style="margin-top: 5px;">

    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>
                        Nomer SO : <?= $sales1->number ?><br>  
                        Tgl Transaksi :  <?= $sales1->transaction_date ?><br>  
                        Nama Pelanggan : <?= $sales1->contact_name ?><br>    
                        Alamat Pelanggan : <?= $sales1->address ?>
                    </td>
                </tr>
            </thead>
        </table>
        <table class="table table-bordered" style="margin-top: -19px;">
            <thead>
                <tr>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Lokasi</th>
                    <th class="text-center">Jumlah Barang</th>
                </tr>
            </thead>
            <tbody> 
                <?php foreach ($datas1 as $data):
                    $warehouses = $db->table('warehouses');
                    $warehouses->select('warehouses.name');
                    $warehouses->where('warehouses.id', $data->warehouse_id);
                    $warehouses = $warehouses->get();
                    $warehouses = $warehouses->getFirstRow();
                ?>
                <tr>
                    <td><?= $data->product_name ?></td>
                    <td><?= $warehouses->name ?></td>
                    <td><?= $data->quantity ?> Unit</td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <table class="table table-bordered" style="margin-top: -19px;">
            <tbody>
                <tr>
                    <td width="40%">
                        <b>Catatan:</b>
                        <br>    
                        <?php if ($sales1->sales_notes == NULL): ?>
                            Tidak ada catatan dari sales.
                        <?php else: ?>
                            <?= $sales1->sales_notes ?>
                        <?php endif ?>
                    </td>

                    <td class="text-center" width="30%">
                        <b>Yang Menyiapkan</b> <br> 
                        Cirebon, <?= date('d-m-Y')?>
                        <br> 
                        <br>    
                        <br>    
                        <br>    
                        <br> 

                    </td>
                    
                    <td class="text-center" width="30%">
                        <b>Nama Supir</b> <br> 
                        <br> 
                        <br>    
                        <br>    
                        <br>    
                        <br> 

                    </td>
                </tr>
            </tbody>
        </table>
    </div>      

    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>
                        Nomer SO : <?= $sales2->number ?> <br>  
                        Tgl Transaksi : <?= $sales2->transaction_date ?> <br>  
                        Nama Pelanggan : <?= $sales2->contact_name ?> <br>    
                        Alamat Pelanggan : <?= $sales2->address ?>
                    </td>
                </tr>
            </thead>
        </table>
        <table class="table table-bordered" style="margin-top: -19px;">
            <thead>
                <tr>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Lokasi</th>
                    <th class="text-center">Jumlah Barang</th>
                </tr>
            </thead>
            <tbody> 
                <?php foreach ($datas2 as $data): 
                    $warehouses = $db->table('warehouses');
                    $warehouses->select('warehouses.name');
                    $warehouses->where('warehouses.id', $data->warehouse_id);
                    $warehouses = $warehouses->get();
                    $warehouses = $warehouses->getFirstRow();
                ?>
                <tr>
                    <td><?= $data->product_name ?></td>
                    <td><?= $warehouses->name ?></td>
                    <td><?= $data->quantity ?> Unit</td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <table class="table table-bordered" style="margin-top: -19px;">
            <tbody>
                <tr>
                    <td width="40%">
                        <b>Catatan:</b>
                        <br>    
                        <?php if ($sales2->sales_notes == NULL): ?>
                            Tidak ada catatan dari sales.
                        <?php else: ?>
                            <?= $sales2->sales_notes ?>
                        <?php endif ?>
                    </td>

                    <td class="text-center" width="30%">
                        <b>Yang Menyiapkan</b> <br> 
                        Cirebon, <?= date('d-m-Y')?>
                        <br> 
                        <br>    
                        <br>    
                        <br>    
                        <br> 

                    </td>
                    
                    <td class="text-center" width="30%">
                        <b>Nama Supir</b> <br> 
                        <br> 
                        <br>    
                        <br>    
                        <br>    
                        <br> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>  


</div>

</body>

</html>