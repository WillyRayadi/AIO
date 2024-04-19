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
                <table class="table table-striped table-bordered" width="100%" id="datatables-default">
                    <thead>
                        <tr>
                            <!--<th class='text-center'>No</th>-->
                           <!-- <th class='text-center'>No. Penjualan (SO)</th> -->
                            <th class='text-center'>Nomer SO</th>
                            <th class='text-center'>Sales</th>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Tanggal Transaksi</th>
                            <!--<th class='text-center'></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $itemNo = 0; ?>
                        <?php foreach($items as $item) : ?>
                        <?php
                        $dateNow = new DateTime(date("Y-m-d"));
                        $dateTransaction = new DateTime($item->sale_date);
                        $dateDiff = $dateNow->diff($dateTransaction);
                        $dateDayDiff = $dateDiff->d;
                        ?>

                        <?php
                        if($dateDayDiff > 3){
                            $deleteItem = $db->table("sale_items");
                            $deleteItem->where("id",$item->sale_item_id);
                            $deleteItem->delete();
                          
                          if ($deleteItem){
                                $deleteStok = $db->table("product_stock");
                                $deleteStok->where("sale_item_id",$item->sale_item_id);
                                $deleteStok->delete();
                            }
                        }else{
                            ?>
                            <?php $itemNo++; ?>
                            <tr>
                                <td class='text-center'> <a href="<?= base_url('owner/sales/'.$item->sale_id.'/manage') ?>"><?= $item->sale_number ?></a></td>
                                <td class="text-center"><?= $item->admin_name ?></td>
                                <td class="text-center"><?= $item->contact_name?></td>
                                <td class="text-center">
                                    <?= date("d-m-Y",strtotime($item->sale_date)) ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
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

<?= $this->endSection() ?>