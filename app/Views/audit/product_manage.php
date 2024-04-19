<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products'); ?>">Barang</a></li>
<li class="breadcrumb-item active"><?= $product->name ?></li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title float-left">Data Barang</h5>
            </div>
            <div class="card-body"> 
                <b>SKU</b>
                <br>
                <?= $product->sku_number ?>
                <br><br>
                <b>Nama Barang</b>
                <br>
                <?= $product->name ?>
                <br><br>
                <b>Stok Tersedia</b>
                <br>
                <?php
                $location = $db->table("product_stocks");
                $location->selectSum("quantity");
                $location->where("product_id",$product->id);
                $location = $location->get();
                $location = $location->getFirstRow();
                echo $location->quantity." ".$product->unit;
                ?>
                <br><br>
                <b>Kategori</b>
                <br>
                <?= $thisCategory->name ?>
                <br><br>
                <b>Satuan</b>
                <br>
                <?= $product->unit ?>
               <br>&nbsp;
            </div>
            <div class="card-footer"></div>
        </div>
    </div>    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Harga Barang</h5>
            </div>
            <div class="card-body">
                <b>Harga Utama (1) : Rp. <?= number_format($product->price,0,",",".") ?></b>
                <hr>
                <i><?= $thisFormula->code ?></i>
                <hr>
                <div class="row">
                    <?php for($p = 1; $p <= 9; $p++) : ?>
                        <?php $pPlus = $p + 1; ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Harga Ke-<?= $pPlus ?>
                                    <br>
                                    <small>(Harga <?= $p ?> + Margin Harga <?= $pPlus ?>)</small>
                                </label>
                                <br>
                                <div id="priceShowContainer<?= $pPlus ?>"></div>
                            </div>
                        </div>
                        <?php if($p % 3 == 0) : ?>
                        </div>
                        <div class='row'>
                        <?php else : ?>
                        <?php endif ?>
                    <?php endfor ?>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pembelian</h5>
            </div>
            <div class="card-body">
                <?php
                $buys = $db->table("buy_items");
                $buys->select("buy_items.quantity as buy_quantity");
                $buys->select("buys.date as buy_date");
                $buys->select("buys.number as buy_number");
                $buys->select("buys.id as buy_id");
                $buys->select("contacts.name as contact_name");
                $buys->join("buys","buy_items.buy_id=buys.id","left");
                $buys->join("contacts","buys.supplier_id=contacts.id","left");
                $buys->where("buy_items.product_id",$product->id);
                $buys->orderBy("buys.date","desc");
                $buys->orderBy("buys.id","desc");

                $buys = $buys->get();
                $buys = $buys->getResultObject();
                ?>
              <div class="table-responsive">
                <table class="table table-md" id="datatables-default2">
                    <thead>
                        <tr>
                            <th class='text-center'>Tanggal Masuk</th>
                            <th class='text-center'>Nomer Pembelian</th>
                            <th class="text-center">Pemasok</th>
                            <th class='text-center'>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bno = 0;
                        foreach($buys as $buy){
                            $bno++;
                            ?>
                            <tr>
                                <td class='text-center'><?= date("d-m-Y",strtotime($buy->buy_date)) ?></td>
                                <td class='text-center'><a href="<?= base_url('audit/product_buys_manage') . '/' . $buy->buy_id ?>"><?= $buy->buy_number ?></a></td>
                                <td class="text-center">
                                    <?= $buy->contact_name ?>
                                </td>
                                <td class='text-center'>+ <?= $buy->buy_quantity ?> <?= $product->unit ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body">
                <?php
                $sales = $db->table("sale_items");
                $sales->select("sale_items.quantity as sale_quantity");
                $sales->select("sales.transaction_date as sale_date");
                $sales->select("sales.number as sale_number");
                $sales->select("sales.id as sale_id");
                $sales->select("sales.status as status");
                $sales->select("contacts.name as contact_name");
                $sales->join("sales","sale_items.sale_id=sales.id","left");
                $sales->join("contacts","sales.contact_id=contacts.id","left");
                $sales->where("sale_items.product_id",$product->id);
                $sales->orderBy("sales.transaction_date","desc");
                $sales->orderBy("sales.id","desc"); 
                $sales = $sales->get();
                $sales = $sales->getResultObject();
                ?>
              <div class="table-responsive">
                <table class="table table-md" id="datatables-default1">
                    <thead>
                        <tr>
                            <th class='text-center'>Tanggal Transaksi</th>
                            <th class='text-center'>Nomer Transaksi</th>
                            <th class="text-center">Konsumen</th>
                            <th class='text-center'>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sno = 0;
                        foreach($sales as $sale){
                            $sno++;
                            ?>
                            <tr>
                                <td class='text-center'><?= date("d-m-Y",strtotime($sale->sale_date)) ?></td>
                                <td class='text-center'><a href="<?= base_url('sales/'.$sale->sale_id.'/manage') ?>"><?= $sale->sale_number ?></a></td>
                                <td class="text-center">
                                    <?= $sale->contact_name ?>
                                </td>
                                <td class='text-center'>-   <?= $sale->sale_quantity ?> <?= $product->unit ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function simulation(){
        formula = <?= $product->price_id ?>;
        price = <?= $product->price ?>;

        $.ajax({
            url : "<?= base_url('products/prices/ajax/simulation') ?>",
            type : "POST",
            data : { formula : formula, price : price},
            success : function(response){
                response = JSON.parse(response)

                for(p = 2; p <= 10; p++){
                    $("#priceShowContainer"+p).html("Rp. "+addCommas(response[p]))
                }
            },
        })
    }

    $(document).ready(function(){
        simulation()
    })

</script>

<style type='text/css'>
    .dataTables{
        height: 20px;
    }
    .dataTables_filter {
      display: none;
  }
</style>

<?= $this->endSection() ?>