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
                    <h2>Form Perpindahan Barang</h2>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    <table class='table table-bordered'>
        <tbody>
            <tr>
                <td width="25%">
                    <b>Nomer Dokumen</b>
                    <br>
                    <?= $data_transfers->number ?>
                </td>

                <td width="25%">
                    <b>Asal Gudang</b>
                    <br>
                    <?= $from->name; ?>
                </td>


                <td width="25%">
                    <b>Tujuan Gudang</b>
                    <br>
                    <?= $to->name; ?>
                </td>

                <td width="25">
                   <b>Tanggal</b>
                   <br>
                   Cirebon, <?= $data_transfers->date ?>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class='text-center'>Nama Produk</th>
                <th class='text-center'>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($items as $item){
                $products = $db->table("products");
                $products->where("id",$item->product_id);
                $products = $products->get();
                $products = $products->getFirstRow();
            ?>
            <tr>
                <td><?= $products->name?></td>
                <td class='text-right'><?= $item->quantity ?></td>                
            </tr>
      
            <?php
        }
        ?>
        </tbody>
    </table>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td class="text-center" width="30%">
                    <br>
                    <b>Requester</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $admin->name ?>
                </td>
                <td class='text-center' width="35%">
                    <br>
                    <b>Menyiapkan</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </td>
              
                <td class='text-center' width="35%">
                    <br>
                    <b>Menerima</b> 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                  
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>