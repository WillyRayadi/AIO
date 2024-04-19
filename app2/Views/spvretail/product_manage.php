<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/spv/retail/products'); ?>">Barang</a></li>
<li class="breadcrumb-item active"><?= $product->name ?></li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title float-left">Data Barang</h5>
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
            </div>
        </div>
    </div>    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Harga Barang</h5>
            </div>
            <div class="card-body">
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
                                    <?php
                                    if($rowPercentegeThisLevel == NULL){
                                        echo"((Belum Ada)) <br><br> <a href='javascript:void(0)' class='btn btn-info btn-sm'>---</a>";
                                    }else{
                                        ?>                                        
                                        <?php
                                        $priceThisLevel = $product->price + ($product->price * $percentageThisLevel / 100);
                                        $priceThisLevel = round(($priceThisLevel + config("App")->priceRound / 2) / config("App")->priceRound) * config("App")->priceRound;
                                        echo "Rp. ".number_format($priceThisLevel,2,",",".");
                                        ?>
                                        <br><br>
                                        <?php
                                        if($statusApproveSpvRetail == 1){
                                            ?>
                                            <a href="<?= base_url('spv/retail/price/'.$rowPercentegeThisLevel->id.'/product/'.$product->id.'/status/2/set') ?>" onclick="return confirm('Yakin setujui harga <?= $l ?>.?')" class='btn btn-success btn-sm' title="Setujui">
                                                <i class='fa fa-check'></i>
                                            </a>
                                            <a href="<?= base_url('spv/retail/price/'.$rowPercentegeThisLevel->id.'/product/'.$product->id.'/status/3/set') ?>" onclick="return confirm('Yakin tidak setujui harga <?= $l ?>.?')" class='btn btn-danger btn-sm' title="Tidak Setujui">
                                                <i class='fa fa-times'></i>
                                            </a>
                                            <?php
                                        }else{
                                            if($statusApproveSpvRetail == 2){
                                                echo"<div class='badge badge-success'>".config("App")->product_price_statuses[$statusApproveSpvRetail]."</div>";
                                            }elseif($statusApproveSpvRetail == 3){
                                                echo"<div class='badge badge-danger'>".config("App")->product_price_statuses[$statusApproveSpvRetail]."</div>";
                                            }else{

                                            }
                                        }
                                        ?>                                        
                                    <?php
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
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>