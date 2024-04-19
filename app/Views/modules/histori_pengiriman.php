<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Histori Pengiriman
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Pengiriman</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="container-fluid mt-4"> 
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Histori Pengiriman</h3>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th class="text-center">Nomer Sales Order</th>
                                <th class="text-center">Nama Pelanggan</th>
                                <th class="text-center">SO Dibuat</th>
                                <th class="text-center">Manifest Dicetak</th>
                                <th class="text-center">Surat Jalan Dicetak</th>
                                <th class="text-center">Sales Order Selesai</th>
                                <th class="text-center">Estimasi Pengiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           $d = 0;
                           foreach ($sales as $sale) {
                            $d++;
                            ?>
                            <tr>
                             <td><?= $sale->sale_number ?></td>
                             <td><?= $sale->contact_name ?></td>
                             <td><?= $sale->sale_create ?></td>
                             <td><?= $sale->manifest_create ?></td>
                             <td><?= $sale->delivery_create ?></td>
                             <td><?= $sale->sale_done ?></td>
                             <td class="text-center">
                                 <?php if ($sale->sale_done != NULL): ?>
                                     <?= $sale->total_minutes. ' Menit' ?>
                                 <?php else: ?>
                                     -
                                 <?php endif ?>
                             </td>
                         </tr>
                         <?php
                     }
                     ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>
</div> 

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>