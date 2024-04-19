<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= config("App")->name ?> | <?= config("Company")->name ?></title>

   <!-- Theme style -->
   <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/dist/css/adminlte.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
   <link href="<?= base_url('/public/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"> 
   
    <style type='text/css'>
    @page {
        size: auto;
    }
    .dataTables{
       height: 20px;
    }
    .dataTables_filter {
		display: none;
    }   
    </style>

    <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
</head>
<body>
<div class='text-center'>
    <b>
        <h2>
            LAPORAN UMUR STOK
            <br>
            <small>Per Tanggal : <?= date("d-m-Y", strtotime($date)) ?></small>
        </h2>
    </b>
</div>
    <table id="stok" class="table table-bordered table-hovered table-striped">
        <thead>
            <tr>
                <th class='text-center'>No</th>
                <th class='text-center'>Produk</th>
                <th class='text-center'>1 Bulan</th>
                <th class='text-center'>2 Bulan</th>
                <th class='text-center'>3 Bulan</th>
                <th class='text-center'>6 Bulan</th>
                <th class='text-center'>1 Tahun</th>
                <th class='text-center'>2 Tahun</th>
                <th class='text-center'>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $productNo = 0; ?>
            <?php foreach($products as $product): ?>
            <?php $productNo++; ?>
                <tr>
                    <td class='text-center'><?= $productNo ?></td>
                    <td><?= $product["product_name"]; ?></td>
                    <td class='text-right'><?= $product["thirtyDays"]["quantity"]; ?></td>
                    <td class='text-right'><?= $product["sixtyDays"]["quantity"]; ?></td>
                    <td class='text-right'><?= $product["ninetyDays"]["quantity"]; ?></td>
                    <td class='text-right'><?= $product["sixMonth"]["quantity"] ?> </td>
                    <td class='text-right'><?= $product["oneYear"]["quantity"] ?> </td>
                    <td class='text-right'><?= $product["twoYear"]["quantity"] ?> </td>
                    <td class='text-right'><?= $product["total"] ?> </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script src="<?= base_url('/public/adminlte') ?>/plugins/datatables/jquery.dataTables.min.js"> </script>
    <script src="<?= base_url('/public/adminlte') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    &nbsp;
    &nbsp;
      
    <script>
        $(document).ready(function() {
        $('#stok').DataTable( {
            dom: 'Bfrtip',
          	"bPaginate": false,
            "bInfo": false,
          
            buttons: [
                'csv', 'excel', 'print'
            ]
        } );
    } );
    </script>
    
    </body>
    </html>