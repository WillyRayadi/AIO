<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Kelola Rumus Harga Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products/prices'); ?>">Rumus Harga</a></li>
<li class="breadcrumb-item active">Kelola Rumus Harga Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class='col-md-12'>
        <div class="card">
            <div class="card-body" style='font-size:20;font-weight:bold'>
                Kode Rumus : <?= $price->code ?>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">Variable Rumus</div>
            <div class="card-body">
                <form method="post" action="<?= base_url('products/prices/variables/add') ?>">
                    <input type='hidden' name='price' value="<?= $price->id ?>">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nama Variable</label>
                                <input type='text' name='name' class='form-control' placeholder='Nama Variable' required>
                            </div>
                            <div class="col-md-6">
                                <label>Nilai Variable</label>
                                <input type='number' step='any' name='value' class='form-control' placeholder='Nilai Variable' required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type='submit' class='btn btn-info btn-block'>
                            <i class='fa fa-plus'></i>
                            Tambah Variable
                        </button>
                    </div>
                </form>
                <hr>
                <?php foreach($variables as $var) : ?>
                <?= $var->define ?> = <?= $var->value ?> <br>
                <?php endforeach ?>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">Rumus Harga</div>
            <div class="card-body">
                <form method="post" action="<?= base_url('products/prices/formulas/add') ?>">
                    <input type='hidden' name='price' value="<?= $price->id ?>">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Level Harga</label>
                                <select name='level' class='form-control'>
                                    <?php
                                    for($l=2;$l <= 10;$l++){
                                        echo"<option value='$l'>Harga ke-$l</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Rumus</label>
                                <input type='text' name='formula' class='form-control' placeholder='Rumus' required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type='submit' class='btn btn-info btn-block'>
                            <i class='fa fa-plus'></i>
                            Tambah Rumus
                        </button>
                    </div>
                </form>
                <hr>
                <?php foreach($formulas as $formula) : ?>
                Harga ke-<?= $formula->level ?> = <?= $formula->formula ?> <br>
                <?php endforeach ?>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                Simulasi Harga
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Harga Utama</label>
                    <input type='number' step='any' id="thisPrice" class='form-control' value="1250000">
                </div>
                <!-- <hr>
                <select id="selectPrice" class='form-control'></select> -->
                <hr>
                <div id="simulationContainer"></div>
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
    harga = $("#thisPrice").val();
    harga = parseFloat(harga)
    outputHarga = addCommas(harga)

    $("#simulationContainer").html(`
    Harga Utama = Rp. `+outputHarga+`
    <hr>
    `)

    // $("#selectPrice").html(`
    // <option value='`+harga+`'>(1) Rp. `+outputHarga+`</option>
    // `)

    

    <?php foreach($variables as $var) : ?>
    <?= $var->define ?> = <?= $var->value ?>;
    <?= $var->define ?> = parseFloat(<?= $var->define ?>);
    console.log(<?= $var->define ?>);
    <?php endforeach ?>
    
    <?php foreach($formulas as $formula) : ?>
    harga_<?= $formula->level ?> = <?= $formula->formula ?>;
    harga_<?= $formula->level ?> = parseFloat(harga_<?= $formula->level ?>);
    harga_<?= $formula->level ?> = Math.round(harga_<?= $formula->level ?>/5000)*5000;
    output_harga_<?= $formula->level ?> = addCommas(harga_<?= $formula->level ?>);
    console.log(output_harga_<?= $formula->level ?>);
    $("#simulationContainer").append(`
    Harga ke-<?= $formula->level ?> = Rp. `+output_harga_<?= $formula->level ?>+`
    <br>
    `)
    // $("#selectPrice").append(`
    // <option value='`+harga_<?= $formula->level ?>+`'>(<?= $formula->level ?>) Rp. `+output_harga_<?= $formula->level ?>+`</option>
    // `)
    <?php endforeach ?>
}

$(document).ready(function(){
    simulation()
})

$("#thisPrice").keyup(function(){
    simulation()
})

</script>

<?= $this->endSection() ?>