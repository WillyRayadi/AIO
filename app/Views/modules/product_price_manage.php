<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Rumus Harga Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products/prices'); ?>">Rumus Harga</a></li>
<li class="breadcrumb-item active">Kelola Rumus Harga <?= $price->code ?></li>
<?= $this->endSection() ?>

<?php
$margins = ([
    0, // 0
    $price->plus_one, // margin ke-1
    $price->plus_two, // margin ke-2
    $price->plus_three, // margin ke-3
    $price->plus_four, // margin ke-4
    $price->plus_five, // margin ke-5
    $price->plus_six, // margin ke-6
    $price->plus_seven, // margin ke-7
    $price->plus_eight, // margin ke-8
    $price->plus_nine, // margin ke-9
    $price->plus_ten, // margin ke-10
]);
?>

<?= $this->section("page_content") ?>

<div class='row'>
    <div class="col-md-6">
        <form method='post' action="<?= base_url('products/prices/save') ?>">        
        <input type='hidden' name='id' value="<?= $price->id ?>">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Rumus</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Kode Rumus</label>
                    <input type='text' name='code' class='form-control' placeholder='Kode Rumus' required value='<?= $price->code ?>'>
                </div>
                <hr>                
                <div class="row">
                    <?php for($p = 1; $p <= 9; $p++) : ?>
                        <?php $pPlus = $p + 1; ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Margin Harga Ke-<?= $pPlus ?></label>
                                <input type='number' step='any' class='form-control' name='prices[]' value="<?= $margins[$pPlus] ?>" placeholder='Margin Harga ke-<?= $pPlus ?>'>
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
            <div class="card-footer">
                <button type='submit' class='btn btn-success'>
                    <i class='fa fa-save'></i>
                    Simpan
                </button>
            </div>
        </div>
        </form>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Simulasi</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Harga Utama (Harga 1)</label>
                    <input type='number' step='any' value="1250000" id="xPrice" class='form-control'>
                </div>
                <hr>
                <div id="containerXPrice"></div>
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
    formula = <?= $price->id ?>;
    price = $("#xPrice").val();

    $("#containerXPrice").html("Harga Utama (1) : Rp. "+addCommas(price))

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

$("#xPrice").keyup(function(){
    simulation()
})

</script>

<?= $this->endSection() ?>