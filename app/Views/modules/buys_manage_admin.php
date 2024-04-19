<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Pembelian (PD)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Pembelian (PD)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<style type="text/css">
.drop-container {
  position: relative;
  display: flex;
  gap: 10px;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 200px;
  padding: 20px;
  border-radius: 10px;
  border: 2px dashed #555;
  color: #444;
  cursor: pointer;
  transition: background .2s ease-in-out, border .2s ease-in-out;
}

.drop-container:hover {
  background: #eee;
  border-color: #111;
}

.drop-container:hover .drop-title {
  color: #222;
}

.drop-title {
  color: #444;
  font-size: 20px;
  font-weight: bold;
  text-align: center;
  transition: color .2s ease-in-out;
}

input[type=file] {
  width: 350px;
  max-width: 100%;
  color: #444;
  padding: 5px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid #555;
}

input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #007bff;
  padding: 10px 20px;
  border-radius: 10px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}

</style>


<form action="<?= base_url('product/purchase/add') ?>" method="post">
    <div class="modal fade" id="modalBuyItemAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pembelian Barang </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="good_buys_id" value="<?= $good_buys->id ?>">
                    <div class='mb-2'>
                        <label class='form-label'>Barang</label>
                        <select class='custom-select select2bs4-BuyItemAdd' name="good" required>
                            <?php foreach ($products as $good) : ?>
                                <?php

                                $qDrugBuyExist = $db->query("select id from buy_items where buy_id='" . $good_buys->id . "' and  product_id='" . $good->id . "'");
                                $rDrugBuyExist = $qDrugBuyExist->getFirstRow();
                                if ($rDrugBuyExist) {
                                } else {
                                ?>
                                    <option value="<?= $good->id ?>"><?= $good->name ?></option>
                                <?php
                                }
                                ?>

                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class='form-label'>Kuantitas</label>
                        <input type='number' name='qty' class='form-control' placeholder="Kuantitas Barang" required>
                    </div>
                    <input type="hidden" value="0" class='form-control' placeholder="Harga per barang" name='price' required>
                    <!-- <div class='mb-2'>
                        <label class='form-label'>Haraga</label>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-primary'>
                        <i class='fa fa-plus'></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


<form method="post" action="<?= base_url("admin/comment/add") ?>">
    <input type="hidden" name="buy_id" value="<?= $good_buys->id ?>">
    <input type="hidden" name="contact_id" value="<?= $good_buys->supplier_id ?>">
    <div class="modal fade" id="modalAddContact" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Perubahan Data</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="number">Nomer PD</label>
                        <select class="form-control" name="buys_id" id="buysSelect" disabled="true">
                            <?php
                            foreach($buyNumber   as $goods){
                                if($goods->id == $good_buys->id){
                                    $selectedBuy = "selected";
                                }else{
                                    $selectedBuy = "";
                                }
                                echo"<option value='".$goods->id."' $selectedBuy>".$goods->number."</option>";
                          }
                          ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Nama Pemasok</label>
                        <input type="text" name="contact_id" value="<?= $good_buys->contact_name ?>" disabled class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Nama Produk</label>
                        <select class="form-control" id="productSelect" name="product_id">
                          <option>-- Pilih Barang --</option>
                          <?php
                          foreach($buy_items as $buy_item){
                            echo "<option value='".$buy_item->product_id."'>".$buy_item->product_name."</option>";
                          }
                          ?>
                        </select>
                    </div> 

                     <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recordedQty">Stok Awal</label>
                                <input type="text" name="stok_awal" class="form-control" readonly id="recordedQty">
                            </div>
                            <div class="col-md-6">
                                <label for="currentQty">Stok Sekarang</label>
                                <input type="number" name="stok_sekarang" class="form-control">
                            </div>
                        </div>           
                    </div>

                    <div class="form-group">
                        <label for="alasan_status">Alasan</label>
                        <input type="text" class="form-control" name="alasan_status" placeholder="Alasan Perubahan" required>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>

            </div>
        </div>
    </div>
</form> 

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">
                <h4>
                    Data Pembelian (PD)
                </h4>
                <hr>
                <b>No. Transaksi</b>
                <br>
                <?= $good_buys->number ?>
                <br>
                <br>

                <b>Pemasok</b>
                <br>
                <?= $good_buys->contact_name ?>
                <br>
                <br>

                <b>Gudang</b>
                <br>
                <?= $good_buys->warehouse_name ?>
                <br>
                <br>

                <b>Tanggal</b>
                <br>
                <?= date("d-m-Y",strtotime($good_buys->date)) ?>
                <br>
                <br>

                <b>Catatan</b>
                <br>
                <?= $good_buys->notes ?>
                <!-- <br>
                <hr>
                <table class="table" cellpadding="3" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td class="text-right">Rp. <?= number_format($count_price, 0, ",", ".") ?></td>
                        </tr>
                        <tr>
                            <td>Pajak(<?= $good_buys->tax ?>%)</td>
                            <td>:</td>
                            <td class="text-right">Rp. <?= number_format($tax, 0, ",", ".") ?> </td>
                        </tr>
                        <tr>
                            <td>Diskon(<?= $good_buys->discount ?>%)</td>
                            <td>:</td>
                            <td class="text-right">Rp. <?= number_format($discount, 0, ",", ".") ?> </td>
                        </tr>
                        <tr class="fw-bold">
                            <td>Total Akhir</td>
                            <td>:</td>
                            <?php
                            $sumLast = $count_price + $tax - $discount;
                            ?>
                            <td class="text-right">Rp. <?= number_format($sumLast, 0, ",", ".") ?></td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Upload Berkas</h5>
            </div>
            <div class="card-body">
                <?php if ($good_buys->file): ?>
                    <a href="<?= base_url('public/purchase_receipts/' . $good_buys->file) ?>" target="_blank" class='btn btn-sm btn-success'>
                        <i class='fa fa-file'></i> Lihat Berkas
                    </a>
                    <a href="<?= base_url('purchase/'.$good_buys->id.'/delete/shipping_receipt') ?>" onclick="return confirm('Yakin ingin menghapus <?= $good_buys->file ?>.?')" class="btn btn-sm btn-danger">
                        <i class='fas fa-trash'></i> Hapus Berkas
                    </a>
                <?php else: ?>
                    <form action="<?= base_url('purchase/shipping/receipts') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $good_buys->id ?>">
                        <div class="form-group">
                            <label for="label">Upload Berkas</label>
                            <div class="form-group">
                                <input type="file" name="file" id="file" accept=".png, .jpg, .jpeg, .gif, .pdf">
                            </div>
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                <?php endif ?>
            </div>
        </div>
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4>
                    Daftar Barang
                    
                    <button style="margin-left: 5px;" type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalBuyItemAdd">
                        <i class='fa fa-plus'></i> Tambah Data
                    </button>
                    
                    <button style="margin-left: 3px; text-decoration: none;" type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#modalAddContact" data-backdrop="static" data-keyboard="false" tabindex="-1"aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <i class="fa fa-edit"></i> Ubah Data
                    </button>
                </h4>

                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class='text-center'>No</th>
                                <th class='text-center'>Nama Barang</th>
                                <th class='text-center'>Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($buy_items as $good_buy_item) : ?>
                                <tr>
                                    <td class='text-center'><?= $i++; ?></td>
                                    <td><?= $good_buy_item->product_name ?></td>
                                    <td><?= $good_buy_item->quantity ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<script type="text/javascript">
    function goodBuyItemEdit(idGoodBuyItem, name, qty, price) {
        $('#goodBuysId').val(idGoodBuyItem)
        $('#good-detail').html(name)
        $('#qtyEdit').val(qty)
        $('#priceEdit').val(price)
    }
</script>
<script type="text/javascript">
    $(function () {
        $('.select2bs4-BuyItemAdd').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modalBuyItemAdd'),
        })
    })
</script>

<script type="text/javascript">
    $("#productSelect").change(function(){
        $.ajax({
            url: "<?= base_url('products/buys/item/ajax') ?>",
            type: "post",
            data: {
                buys        : $("#buysSelect").val(),
                product     : $("#productSelect").val(),
            },

        success: function(html) {

            html = parseInt(html)
            $("#recordedQty").val(html)
            $("#realQty").val("0")
          }

        })
        })

    $("#buysSelect").change(function(){
        $.ajax({
            url: "<?= base_url('products/buys/item/ajax') ?>",
            type: "post",
            data: {
                  buys        : $("#buysSelect").val(),
                  product     : $("#productSelect").val(),
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