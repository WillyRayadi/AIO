<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Perubahan Data
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Perubahan Data</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<!-- END MODAL ADD TRANSFERS ITEMS --> 

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">  
                <h4>Perubahan Data (PD)</h4>    
                <hr>  
                <b>Nomer PD</b>

                <br>
                <p><?= $alasan->buy_number ?></p>

                <b>Nama Admin</b>
                <br>
                <p><?= $alasan->admin_name ?></p>

                <b>Nama Pemasok</b>
                <br>
                <p><?= $alasan->contact_name ?></p>

                <b>Alasan Merubah Data</b>
                <br>
                <p><?= $alasan->alasan_perubahan ?></p> 

          </div> 
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">                                                           
            <div class="card-body">
                <h4>  
                    Daftar Barang Yang Memerlukan Persetujuan
                </h4> 
                <hr> 
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                           <th class="text-center">No</th>
                           <th class="text-center">Nama Produk</th>
                           <th class="text-center">Stok Akhir</th>
                           <th class="text-center">Perubahan</th>
                           <th class="text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        $no = 0;
                        foreach($products as $product){
                            $no++;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <td class="text-center"><?= $product->product_name ?></td>
                            <td class="text-center"><?= $product->stok_awal ?></td>
                            <td class="text-center"><?= $product->stok_sekarang ?></td>
                            <?php
                                $buy = $db->table('buys');
                                $buy->where('buys.id',$product->buy_id);
                                $buy->orderBy('buys.id','desc');
                                $buy = $buy->get();
                                $buy = $buy->getFirstRow();
                            ?>
                            <td class="text-center">
                               <a href="<?=base_url("owner/approve/".$product->id.'/perubahan_data/'.$alasan->item_id) ?>" onclick="return confirm('Yakin Kamu mau menyetujui.?')" class='btn btn-success btn-sm' title="Setujui">
                                        <i class='fa fa-check'></i>
                                </a>
                            </td>
                        </tr>
                          <?php
                        }
                        ?>
                    </tbody>
                </table>

                    <!-- End table data -->
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>