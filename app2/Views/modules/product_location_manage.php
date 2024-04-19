<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Lokasi Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products'); ?>">Barang</a></li>
<li class="breadcrumb-item active">Kelola  Lokasi <?= $product->name ?></li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Kelola Lokasi Persediaan Barang</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <b>Kode Barang</b>
                        <br>
                        <?= $code->name ?>
                        <br><br>
                        <b>Nama Barang</b>
                        <br>
                        <?= $product->name ?>
                        <br><br>
                        <b>Kategori</b>
                        <br>
                        <?= $category->name ?>
                    </div>
                    <div class="col-md-">
                        <b>Persediaan Aktif</b>
                        <br>
                        <?= $stock ?> <?= $product->unit ?>
                        <hr>
                        <form method="post" action="<?= base_url('product/location/save') ?>">
                            <input type='hidden' name='product' value='<?= $product->id ?>'> 
                            <?php
                            foreach($warehouses as $warehouse){
                                ?>
                            <input type='hidden' name='warehouse[]' value='<?= $warehouse->id ?>'> 
                                <?php
                                $location = $db->table('product_locations');
                                $location->where("warehouse_id",$warehouse->id);
                                $location->where("product_id",$product->id);
                                $location = $location->get();
                                $location = $location->getFirstRow();

                                if($location == NULL){
                                    $thisQty = 0;
                                }else{
                                    $thisQty = $location->quantity;
                                }
                                ?>
                            <div class="form-group">
                                <label><?= $warehouse->name ?></label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <input type="number" name='qty[]' value="<?= $thisQty ?>" class="form-control">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?= $product->unit ?></div>
                                    </div>
                                </div>
                            </div>
                                <?php
                            }
                            ?>
                            <div class="form-group">
                                <button type='submit' class='btn btn-success'>
                                    <i class='fa fa-save'></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>