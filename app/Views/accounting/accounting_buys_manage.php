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

<!-- //////////////////////////////////////////////////// END MODAL EDIT GOOD BUYS ///////////////////////////////////////////////// -->



<!-- //////////////////////////////////////////////////// MODAL ADD GOOD BUYS ITEMS///////////////////////////////////////////////// -->

<!-- //////////////////////////////////////////////////// END MODAL ADD GOOD BUYS ITEMS///////////////////////////////////////////////// -->

<!----------------------------- Modal Buy Item Edit -------------------->


<!------------------------------------- End Of Modal Buy Item Edit --------------------------------------->

<!-- Modal Add Contact -->


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
        
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h4>
                    Daftar Barang
                   
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
                                <!-- <th class="text-center">Aksi</th> -->
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
                                    <!-- <td class="text-center">
                                        <button onclick="goodBuyItemEdit('<?= $good_buy_item->id ?>','<?= $good_buy_item->name ?>', <?= $good_buy_item->quantity ?>, <?= $good_buy_item->price ?>)" title="Edit" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalBuyItemEdit">
                                            <i class='fa fa-edit'></i>
                                        </button>
                                        <a href="<?= base_url('products/purchase/delete/' . $good_buys->id . '/' .  $good_buy_item->id) ?>" onclick="return confirm('Yakin ingin menghapus <?= $good_buy_item->name ?>.?')" class="btn btn-danger text-white btn-sm" title="Delete Purchase">
                                            <i class='fa fa-trash'></i>
                                        </a>
                                    </td> -->
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