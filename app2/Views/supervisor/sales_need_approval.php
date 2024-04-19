<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Item Penjualan (SO) Perlu Persetujuan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Item Penjualan (SO) Perlu Persetujuan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Item Penjualan (SO) Perlu Persetujuan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <!-- <th class='text-center'>No</th> -->
                            <th class='text-center'>Nomer SO</th>
                            <th class='text-center'>Sales</th>
                            <th class='text-center'>Pelanggan</th>
                            <!-- <th class='text-center'>Nama Produk</th> -->
                            <th class='text-center'>Tanggal</th>
                            <!-- <th class='text-center'></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $itemNo = 0; ?>
                        <?php foreach($items as $item) : ?>
                                <?php $itemNo++; ?>
                                <tr>
                                    <!-- <td class='text-center'><?= $itemNo ?></td> -->
                                    <td class='text-center'><a href="<?= base_url('supervisor/sales/'.$item->sale_id.'/manage') ?>"><?= $item->sale_number ?></a></td>
                                    <td><?= $item->admin_name ?></td>
                                    
                                    <td><?= $item->contact_name?></td>
                                    <!-- <td class='text-right'>
                                        (<?= $item->item_price_level ?>)
                                        Rp. <?= number_format($item->item_price,0,",",".") ?>
                                    </td> -->
                                    <td class='text-right'><?= date("d-m-Y",strtotime($item->sale_date)) ?></td>
                                   <!--  <td class='text-center'>
                                        <a href="<?= base_url('supervisor/sales/'.$item->sale_id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
                                            <i class='fa fa-cog'></i>
                                        </a>
                                    </td> -->
                                </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>s