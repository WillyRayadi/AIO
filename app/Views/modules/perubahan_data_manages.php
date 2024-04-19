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
                <p><?= $headers->buy_number ?></p>

                <b>Nama Admin</b>
                <br>
                <p><?= $headers->admin_name ?></p>

                <b>Nama Pemasok</b>
                <br>
                <p><?= $headers->contact_name ?></p>

                <b>Alasan Merubah Data</b>
                <br>
                <p><?= $headers->alasan_perubahan ?></p> 

          </div> 
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">                                                           
            <div class="card-body">
                <h4>  
                    Daftar Barang
                </h4> 
                <hr> 
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Stok Awal</th>
                                <th class="text-center">Stok Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no= 0; 
                            foreach ($products as $product) 
                            $no++; 
                            { 
                            ?>
                            <tr>
                                <td><?= $product->product_name ?></td>
                                <td><?= $product->stok_awal ?></td>
                                <td><?= $product->stok_sekarang ?></td>
                            </tr>
                            <?php } ?>
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