<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Aktifitas Pelanggan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports_'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Data Aktifitas Pelanggan</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>
<!-- <div class='text-center'>
    <b>
        <h2>
            Pergerakan Barang
            <br>
            <small>Per Tanggal : <?= date("d-m-Y", strtotime($tanggalawal)) ?> s/d <?= date("d-m-Y", strtotime($tanggalakhir)) ?></small>
        </h2>
    </b>
</div><br>
 -->

<div class="card">
<div class="card-header bg-primary">
    <h5 class="card-title">Data Transaksi Pelanggan</h5>
    <!--<div class="float-right">-->
    <!--    <a href="<?= base_url('export_data?tanggalawal='.$tanggalawal.'&tanggalakhir='.$tanggalakhir) ?>" class="btn btn-success"><i class="fas fa-print"></i> Export Data</a>-->
    <!--</div>-->
</div>
<div class="card-body">
<table class="table table-md table-striped" id="stok">
    
        <tbody>
            <?php 
                $currentcustomerName = "";
            ?>

            <?php foreach ($customers as $customer): ?>
                <?php if ($currentcustomerName != $customer->contact_name): ?>
                    <?php $currentcustomerName = $customer->contact_name; ?>
                    <tr>
                        <td colspan="4"><strong><?php echo $currentcustomerName; ?></strong></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>
                        <a href="<?= base_url('sales/'.$customer->sales_id.'/manage') ?>"><?php echo $customer->sale_number; ?></a>
                    </td>
                    <td>
                        <?php echo $customer->sale_date; ?>
                    </td>
                    <td>
                        <?php echo $customer->product_name; ?>
                    </td>

                    <td>
                       <?php echo $customer->sale_quantity; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</table>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>
<script src="<?= base_url('/public/adminlte')?>/plugins/datatables/jquery.dataTables.min.js"> </script>
<script src="<?= base_url('/public/adminlte')?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"> </script>
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
<?= $this->endSection() ?>
