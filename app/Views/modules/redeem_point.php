<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
<h1>Kelola Penukaran</h1>
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"></li>
<li class="breadcrumb-item active">Kelola Penukaran</li>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title" id="addModalLabel">Redeem Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <div class="modal-body">
        <form method="post" action="<?= base_url('add/product/redeem')?>">
            <input type="hidden" name="contacts" value="<?= $header->contact_id ?>">
            
            <div class="form-group">
                <label for="label-product">Nama Produk</label>
                <select name="products" class="select2bs4" id='productSelect'>
                    <option value="">Pilih Produk</option>
                    <?php
                        foreach ($products as $product) {
                            echo"<option value='$product->product_id'>".$product->product_name."</option>";                        
                        }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class='label-warehouses'>Gudang</label>
                <select class="form-control" id='warehouseSelect'>
                    <option value=''>Pilih Gudang</option>
                    <?php 
                        foreach($warehouses as $warehouse){
                            echo"<option value='$warehouse->id'>".$warehouse->name."</option>";      
                        }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Stok Tersedia</label>
                <input type='number' readonly id="recordedQty" value='0' name='qty_recorded' class='form-control' required>
            </div>

            <div class="form-group">
                <label class="label-address">Alamat Penerima</label>
                <textarea class="form-control"><?= $header->member_address ?></textarea> 
            </div>
        </div>
        <div class="modal-footer">
            <button class='btn btn-success'>
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <b>Nama Pelanggan</b>
                    <p><?= $header->contact_name ?></p>
                </div>
                <div class="col-md-12">
                    <b>Alamat Pelanggan</b>
                    <p><?= $header->member_address ?></p>
                </div>
                <div class="col-md-12">
                    <b>Tanggal Claim</b>
                    <p><?= $header->exchange_date ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">Barang</h3>
                <a href="#" data-toggle="modal" data-target="#addModal" class="float-right btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Point</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection()?>
<?= $this->section('page_script') ?>

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