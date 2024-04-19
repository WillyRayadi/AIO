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
                    <h2>Form Retur Barang</h2>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    <table class='table table-bordered'>
        <tbody>
            <tr>
                <td width="15%">
                    <b>Nomer Retur</b>
                    <br>
                    <?= $data_returs->retur_number ?>
                </td>

                <td width="15%">
                    <b>Nomer Invoice</b>
                    <br>
                    <?= $data_returs->sale_number ?>
                </td>

                <td width="30%">
                    <b>Data Pelanggan</b>
                    <br>
                    <?php 
                    $contacts = $db->table('contacts');
                    $contacts->where('contacts.id',$data_returs->contact_id);
                    $contacts = $contacts->get();
                    $contacts = $contacts->getFirstRow();

                    echo "Nama: ";
                    echo $contacts->name; 
                    echo "<br> Alamat: ";
                    echo $contacts->address;
                    ?>
                </td>

                <td width="20%">
                   <b>Tanggal Retur</b>
                   <br>
                   Cirebon, <?= $data_returs->date?>
                </td>

                <td width="20%">
                    <b>Alasan</b><br>
                    <?= $data_returs->alasan ?>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class='text-center'>Nama Barang</th>
                <th class='text-center'>Lokasi Retur</th>
                <th class='text-center'>Jumlah</th>
            </tr>
        </thead>
        <tbody> 
            <?php 
                $no = 0;
                foreach ($item_returs as $retur): 
                $no++;  
            ?>
            <tr>
                <td class="text-left"><?= $retur->product_name ?></td>
                <td class='text-center'><?= $retur->warehouse_name ?></td>
                <td class='text-right'><?= $retur->quantity?> unit</td>                
            </tr>
            <?php endforeach ?>
      </tbody>
    </table>

    <table class="table table-bordered">
        <tbody> 
            <tr> 
                <td class='text-center' width="25%">
                    <br>
                    <b>Diberikan Oleh</b>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?= $contacts->name ?>
                </td>
              
                <td class='text-center' width="25%">
                    <br>
                    <b>Diterima Driver</b> 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </td>

                <td class='text-center' width="25%">
                    <br>
                    <b>Diterima Staff gudang</b> 
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    (..............................................)
                </td>

                <td class='text-center' width="25%">
                    <br>
                    <b>Mengetahui SPV Gudang</b> 
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