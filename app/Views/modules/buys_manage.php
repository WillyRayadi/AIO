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


<!-- //////////////////////////////////////////////////// MODAL EDIT GOOD BUYS ///////////////////////////////////////////////// -->
<form action="<?= base_url('products/buys/edit') ?>" method="post">
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Purchase</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label class='form-label'>No. Transaksi</label>
                                <input type='text' readonly name='invoice_number' value="<?= $good_buys->number ?>" class='form-control' placeholder="No. Transaksi" required>
                            </div>
                            <div class='mb-2'>
                                <input type="hidden" name="good_buys_id" value="<?= $good_buys->id ?>">
                                <label class='form-label'>Pemasok</label>
                                <select class='custom-select select2bs4-modalEdit' name="supplier" id="pemasok-Edit" required>
                                    <?php foreach ($suppliers as $supplier) : ?>
                                        <option <?= ($supplier->id == $good_buys->supplier_id) ? "selected='selected'" : '' ?> value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>                            
                            <div class='mb-2'>
                                <label class='form-label'>Tanggal</label>
                                <input type="date" class='form-control' value="<?= $good_buys->date ?>" name='date' required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class='form-label'>Gudang</label>
                                <input type='text' readonly value="<?= $good_buys->warehouse_name ?>" class='form-control' placeholder="Gudang" required>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Catatan</label>
                                <textarea name="notes" class="form-control" placeholder="Catatan"><?= $good_buys->notes ?></textarea>
                            </div>
                        </div>
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
<!-- //////////////////////////////////////////////////// END MODAL EDIT GOOD BUYS ///////////////////////////////////////////////// -->



<!-- //////////////////////////////////////////////////// MODAL ADD GOOD BUYS ITEMS///////////////////////////////////////////////// -->
<form action="<?= base_url('products/purchase/add') ?>" method="post">
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
<!-- //////////////////////////////////////////////////// END MODAL ADD GOOD BUYS ITEMS///////////////////////////////////////////////// -->

<!----------------------------- Modal Buy Item Edit -------------------->

<form action="<?= base_url('products/purchase/edit') ?>" method="post">
    <div class="modal fade" id="modalBuyItemEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pembelian Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="good_buys_id" value="<?= $good_buys->id ?>">
                    <input type="hidden" id="goodBuysId" name="good_buys_item_id">
                    <div class='mb-2'>
                        <label class='form-label'><b>Barang</b></label>
                        <br>
                        <div id="good-detail"></div>
                    </div>
                    <div class="mb-2">
                        <label class='form-label'><b>Kuantitas</b></label>
                        <input type='number' id="qtyEdit" name='qty' class='form-control' placeholder="Kuantitas Barang" required>
                    </div>
                    <input type="hidden" id="priceEdit" class='form-control' placeholder="Harga per barang" name='price' required>
                    <!-- <div class='mb-2'>
                        <label class='form-label'><b>Harga</b></label>
                    </div> -->
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

<!------------------------------------- End Of Modal Buy Item Edit --------------------------------------->

<!-- Modal Add Contact -->
<form method="post" action="<?= base_url("contacts/add/direct_buy_manage") ?>">
    <div class="modal fade" id="modalAddContact" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Kontak</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='hidden' name='buy' value="<?= $good_buys->id ?>">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="nama" required>
                    </div>
                    <div class='form-group mt-4'>
                        <label>Tipe</label>
                        <br>
                        <label class="mx-2">
                            <input type='radio' name='type' value="1" checked>
                            Pemasok
                        </label>
                        <label class="mx-2">
                            <input type='radio' name='type' value="2">
                            Pelanggan
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="phone">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" required>
                    </div> -->
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="alamat" required></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="phone">No. Referensi</label>
                        <input type="text" class="form-control" id="reference" name="reference" placeholder="No. Referensi" required>
                    </div> -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Add Contact -->


<div class='row mb-2'>
    <div class='col-md-12'>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAddContact">
            <i class='fa fa-plus'></i>
            Tambah Pemasok
        </button>
    </div>
</div>

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">
                <h4>
                    Data Pembelian (PD)
                    <a href="<?= base_url('product/buys/delete/' . $good_buys->id) ?>" onclick="return confirm('Sure delete purchases with invoice number <?= $good_buys->number ?>.?')" class="btn btn-danger btn-sm float-right" title="Hapus Pembelian">
                        <i class='fa fa-trash'></i>
                    </a>
                    <span class='float-right'>&nbsp;</span>
                    <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modalEdit">
                        <i class='fa fa-edit'></i>
                    </button>
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
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalBuyItemAdd">
                        <i class='fa fa-plus'></i> Tambah Data
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
                                <!-- <th class='text-center'>Harga</th>
                                <th class='text-center'>Total</th> -->
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($buy_items as $good_buy_item) : ?>
                                <tr>
                                    <td class='text-center'><?= $i++; ?></td>
                                    <td><?= $good_buy_item->name ?></td>
                                    <td><?= $good_buy_item->quantity ?></td>
                                    <!-- <td><?= $good_buy_item->price ?></td> -->
                                    <?php
                                    (int)$qty_good = $good_buy_item->quantity;
                                    (int)$price_good = $good_buy_item->price;
                                    $count = $qty_good * $price_good;
                                    ?>
                                    <!-- <td>Rp. <?= number_format($count, 0, ",", ".") ?></td> -->
                                    <td class="text-center">
                                        <button onclick="goodBuyItemEdit('<?= $good_buy_item->id ?>','<?= $good_buy_item->name ?>', <?= $good_buy_item->quantity ?>, <?= $good_buy_item->price ?>)" title="Edit" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalBuyItemEdit">
                                            <i class='fa fa-edit'></i>
                                        </button>
                                        <a href="<?= base_url('products/purchase/deletes/' . $good_buys->id . '/' .  $good_buy_item->id) ?>" onclick="return confirm('Yakin ingin menghapus <?= $good_buy_item->name ?>.?')" class="btn btn-danger text-white btn-sm" title="Delete Purchase">
                                            <i class='fa fa-trash'></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th class="text-center" colspan="2">Total</th>
                                <th class="text-end">Rp. <?= number_format($sumBuyTable, 0, ",", ".") ?></th>
                                <th class="text-center"></th>
                            </tr>
                        </tfoot> -->
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
<?= $this->endSection() ?>