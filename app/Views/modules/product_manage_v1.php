<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products'); ?>">Barangs</a></li>
<li class="breadcrumb-item active"><?= $product->name ?></li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("products/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name='id' value="<?= $product->id ?>">
                    <div class='mb-2'>
                        <label class='form-label'>Kategori</label>
                        <select class='form-control' name='category_id'>
                            <?php
                            foreach ($categories as $category) {
                                if($category->id == $product->category_id) {
                                    $selectedCategory = "selected";
                                }else{
                                    $selectedCategory = "";
                                }
                                echo "
                                <option value='" . $category->id . "' $selectedCategory>" . $category->name . "</option>
                                ";
                            }
                            ?>
                        </select>
                    </div>
                    <div class='mb-2'>
                        <label class='form-label'>Kode</label>
                        <select class='form-control' name='code_id' required>
                            <?php
                            foreach ($codes as $code) {
                                if($code->id == $product->code_id) {
                                    $selectedCode = "selected";
                                }else{
                                    $selectedCode = "";
                                }
                                echo "
                                <option value='" . $code->id . "' $selectedCode>" . $code->name . "</option>
                                ";
                            }
                            ?>
                        </select>
                    </div>
                    <div class='mb-2'>
                        <label class='form-label'>Nomor SKU</label>
                        <input type='text' value="<?= $product->sku_number ?>" name='sku_number' class='form-control' placeholder="nomor sku" required>
                    </div>

                    <div class='mb-2'>
                        <label class='form-label'>Nama</label>
                        <input type='text' value="<?= $product->name ?>" name='name' class='form-control' placeholder="nama" required>
                    </div>
                    <div class='mb-2'>
                        <label class='form-label'>Satuan</label>
                        <input type='text' value="<?= $product->unit ?>" name='unit' class='form-control' placeholder="Unit" required>
                    </div>
                    <div class="form-group">
                        <label for="editDetailsGoods">Detail</label>
                        <textarea class="form-control" name="details" id="editDetailsGoods" rows="3" placeholder="detail" required><?= nl2br($product->details) ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-success'>
                        <i class='fa fa-save'></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Edit -->

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title float-left">Data Barang</h5>
                <a href="javascript:void(0)" title="Edit" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm float-right text-white">
                    <i class='fa fa-edit'></i>
                </a>
            </div>
            <div class="card-body">
                <b>Kode</b>
                <br>
                <?= $thisCode->name ?>
                <br><br>
                <b>Kategori</b>
                <br>
                <?= $thisCategory->name ?>
                <br><br>
                <b>SKU</b>
                <br>
                <?= $product->sku_number ?>
                <br><br>
                <b>Nama Barang</b>
                <br>
                <?= $product->name ?>
                <br><br>
                <b>Satuan</b>
                <br>
                <?= $product->unit ?>
                <br><br>
                <b>Keterangan / Catatan</b>
                <br>
                <?= nl2br($product->details) ?>
            </div>
            <div class="card-footer">
                <a href="<?= base_url('products') . '/' . $product->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus Barang : <?= $product->name ?> ?')" class='btn btn-danger text-white float-right'>
                    <i class='fa fa-trash'></i> Hapus
                </a>
            </div>
        </div>
    </div>    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Persediaan Barang</h5>
            </div>
            <div class="card-body"></div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Harga Barang</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="<?= base_url('product/save/price') ?>">
                                    <input type='hidden' name='id' value="<?= $product->id ?>">
                                    <div class="form-group">
                                        <label>Harga Utama</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp.</div>
                                            </div>
                                            <input type="number" class="form-control" name='price' value="<?= $product->price ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type='submit' class='btn btn-block btn-success'>
                                            <i class='fa fa-save'></i>
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <?php
                            for($l = 2; $l <= config("App")->productPriceLevel; $l++){
                                ?>
                                <?php
                                $rowPercentegeThisLevel = $db->table('product_prices');
                                $rowPercentegeThisLevel->where("product_id",$product->id);
                                $rowPercentegeThisLevel->where("level",$l);
                                $rowPercentegeThisLevel = $rowPercentegeThisLevel->get();
                                $rowPercentegeThisLevel = $rowPercentegeThisLevel->getFirstRow();

                                if($rowPercentegeThisLevel != NULL){
                                    $marginID = $rowPercentegeThisLevel->id;
                                    $percentageThisLevel = $rowPercentegeThisLevel->percentage;
                                    $statusApproveOwner = $rowPercentegeThisLevel->approve_owner_status;
                                    $statusApproveSpvRetail = $rowPercentegeThisLevel->approve_spv_retail_status;
                                    $statusApproveSpvGrosir = $rowPercentegeThisLevel->approve_spv_grosir_status;
                                }else{
                                    $marginID = 0;
                                    $percentageThisLevel = 0;
                                    $statusApproveOwner = 0;
                                    $statusApproveSpvRetail = 0;
                                    $statusApproveSpvGrosir = 0;
                                }
                                ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <b>Harga <?= $l ?></b>
                                            <br>
                                            <div class="clearfix"></div>
                                            <br>
                                            <form method="post" action="<?= base_url('product/save/margin') ?>">
                                                <input type='hidden' name='product' value="<?= $product->id ?>">
                                                <input type='hidden' name='id' value="<?= $marginID ?>">
                                                <input type='hidden' name='level' value="<?= $l ?>">
                                                <div class="form-group">
                                                    <div class="input-group mb-2 mr-sm-2">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Margin</div>
                                                        </div>
                                                        <input type="number" step='any' name='margin' value="<?= $percentageThisLevel ?>" class="form-control">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">%</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <button type='submit' class='btn btn-block btn-success'>
                                                        <i class='fa fa-save'></i>
                                                        Simpan Harga <?= $l ?>
                                                    </button>
                                                </div>
                                            </form>
                                            <br>
                                            <?php
                                            $priceThisLevel = $product->price + ($product->price * $percentageThisLevel / 100);
                                            $priceThisLevel = round(($priceThisLevel + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound;
                                            echo "Rp. ".number_format($priceThisLevel,2,",",".");
                                            ?>
                                            <br><br>
                                            <?php
                                            if($statusApproveOwner == 1){
                                                echo"<div class='badge badge-warning'>Approve Owner : ".config("App")->product_price_statuses[$statusApproveOwner]."</div>";
                                            }elseif($statusApproveOwner == 2){
                                                echo"<div class='badge badge-success'>Approve Owner : ".config("App")->product_price_statuses[$statusApproveOwner]."</div>";
                                            }elseif($statusApproveOwner == 3){
                                                echo"<div class='badge badge-danger'>Approve Owner : ".config("App")->product_price_statuses[$statusApproveOwner]."</div>";
                                            }else{
                                                echo"<div class='badge badge-info'>Approve Owner : -</div>";
                                            }
                                            echo"<br>";
                                            if($statusApproveSpvRetail == 1){
                                                echo"<div class='badge badge-warning'>Approve Spv Retail : ".config("App")->product_price_statuses[$statusApproveSpvRetail]."</div>";
                                            }elseif($statusApproveSpvRetail == 2){
                                                echo"<div class='badge badge-success'>Approve Spv Retail : ".config("App")->product_price_statuses[$statusApproveSpvRetail]."</div>";
                                            }elseif($statusApproveSpvRetail == 3){
                                                echo"<div class='badge badge-danger'>Approve Spv Retail : ".config("App")->product_price_statuses[$statusApproveSpvRetail]."</div>";
                                            }else{
                                                echo"<div class='badge badge-info'>Approve Spv Retail : -</div>";
                                            }
                                            if($l <= 2){                                                    
                                            }else{
                                                echo"<br>";
                                                if($statusApproveSpvGrosir == 1){
                                                    echo"<div class='badge badge-warning'>Approve Spv Grosir : ".config("App")->product_price_statuses[$statusApproveSpvGrosir]."</div>";
                                                }elseif($statusApproveSpvGrosir == 2){
                                                    echo"<div class='badge badge-success'>Approve Spv Grosir : ".config("App")->product_price_statuses[$statusApproveSpvGrosir]."</div>";
                                                }elseif($statusApproveSpvGrosir == 3){
                                                    echo"<div class='badge badge-danger'>Approve Spv Grosir : ".config("App")->product_price_statuses[$statusApproveSpvGrosir]."</div>";
                                                }else{
                                                    echo"<div class='badge badge-info'>Approve Spv Grosir : -</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>