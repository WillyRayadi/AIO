<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>

<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Purchase Order</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 
<div class="row">
    <div class="col-lg">        
        <div class="card">
            <div class="card-header bg-info">
             <h5 class="card-title">Data Purchase Order</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Nomer Purchase Order</th>
                        <th class="text-center">Nama Supplier</th>
                        <th class="text-center">Tanggal Purchase Order</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach($purchases as $purchase){
                        $no++;
                    ?>
                    <tr>
                       <td class="text-center"><?= $purchase->purchase_number ?></td> 
                       <td class="text-center"><?= $purchase->contact_name ?></td> 
                       <td class="text-center"><?= $purchase->date ?></td> 
                       <td class="text-center"><a href="<?= base_url('purchases/manages/'.$purchase->id) ?>" class="btn btn-sm btn-success"><i class="fas fa-cog"></i></a></td> 
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
</div>

<?= $this->endSection() ?> 