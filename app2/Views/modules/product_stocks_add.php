<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Tambah Penyesuaian Persedian Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('products/stocks') ?>">Penyesuaian Persedian Barang</a></li>
<li class="breadcrumb-item active" aria-current="page">Tambah</li>
<?= $this->endSection() ?>

<?= $this->section("page_content"); ?>

<div class="row">
    <div class="col-md-12">
        <form action="<?= base_url('products/stocks/insert') ?>" method="post">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="card-title">Tambah Penyesuaian Persedian Barang</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Gudang</label>
                                <select name='warehouse' class='form-control' id="warehouseSelect">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jumlah Tercatat</label>
                                <input type='number' readonly id="recordedQty" value='0' name='qty_recorded' class='form-control' required placeholder="Jumlah Tercatat">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jumlah Sebenarnya</label>
                                <input type='number' name='qty_real' id="realQty" value='0' class='form-control' required placeholder="Jumlah Sebenarnya">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jumlah Penyesuaian</label>
                                <input type='number' readonly name='qty_custom' id="customQty" value='0' class='form-control' required placeholder="Jumlah Penyesuaian">
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
                    <a href="<?= base_url('products/stocks') ?>" class="btn btn-danger float-left">
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
            $("#realQty").val(html)
            $("#customQty").val("0")
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
            $("#realQty").val(html)
            $("#customQty").val("0")
        }
    })
})

$("#realQty").change(function(){
    recorded = $("#recordedQty").val()
    real = $("#realQty").val()

    recorded = parseInt(recorded)
    real = parseInt(real)

    if(recorded > real){
        custom = real - recorded;
    }else if(recorded == real){
        custom = recorded - real;
    }else if(recorded < real){
        custom = real - recorded;
    }else{
        custom = 0;
    }

    $("#customQty").val(custom)
})

</script>

<?= $this->endSection() ?>