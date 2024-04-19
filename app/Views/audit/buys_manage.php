<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Pembelian (PD)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('products/buys') ?>">Pembelian Barang</a></li>
<li class="breadcrumb-item active">Kelola Pembelian (PD)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">
                <h4>Data Pembelian (PD)</h4>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            ?>
                            <?php foreach ($buy_items as $good_buy_item) : ?>
                                <tr>
                                    <td class="text-center"><?= $i++; ?></td>
                                    <td class="text-center"><?= $good_buy_item->name ?></td>
                                    <td class="text-center"><?= $good_buy_item->quantity ?></td>
                    
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
<?= $this->endSection() ?>