<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Tambah Transfer Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('products/stocks') ?>">Transfer Barang</a></li>
<li class="breadcrumb-item active" aria-current="page">Tambah</li>
<?= $this->endSection() ?>

<?= $this->section("page_content"); ?>

<div class="row">
    <div class="col-md-12">
        <form action="<?= base_url('products/transfers/insert') ?>" method="post">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="card-title">Tambah Transfer Barang</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dari Gudang</label>
                                <select name='from_warehouse' class='form-control' id="warehouseSelect">
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ke Gudang</label>
                                <select name='to_warehouse' class='form-control' id="warehouseSelect">
                                    <?php
                                    foreach($warehouses as $warehouse){
                                        echo"<option value='".$warehouse->id."'>".$warehouse->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Barang</label>
                                <select id="productSelect" name='product' class='form-control' required>
                                    <option value="">--Pilih Barang--</option>
                                    <?php
                                    foreach($products as $product){
                                        echo "<option value='".$product->id."'>".$product->name."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='form-group'>
                                <label>Tanggal</label>
                                <input type='date' class='form-control' name='date' required value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah Di Dalam Gudang</label>
                                <input type='number' readonly id="recordedQty" value='0' name='qty_recorded' class='form-control' required placeholder="Jumlah Di Dalam Gudang">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah Yang Ditransfer</label>
                                <input type='number' name='quantity' id="realQty" value='0' class='form-control' required placeholder="Jumlah Yang Ditransfer">
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Catatan / Keterangan</label>
                                <textarea class='form-control' name='details' placeholder="Tulis Catatan / Keterangan Di Sini" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('products/transfers') ?>" class="btn btn-danger float-left">
                        Kembali
                    </a>
                    <button type='submit' class='btn btn-primary float-right'>
                        <i class='fa fa-plus'></i>
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">

$("#productSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },
        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }
    })
})
$("#warehouseSelect").change(function(){
    $.ajax({
        url: "<?= base_url('products/stocks/add/ajax/qty_recorded') ?>",
        type: "post",
        data: {
            product     : $("#productSelect").val(),
            warehouse   : $("#warehouseSelect").val(),
        },
        success: function(html) {
            // console.log(html);
            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
        }
    })
})

</script>

<?= $this->endSection() ?>