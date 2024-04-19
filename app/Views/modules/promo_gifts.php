<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Promos
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/promo'); ?>">Promo</a></li>
<li class="breadcrumb-item active">Promo Detail</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Promo (Kode : <?= $promo->promo_code ?>)</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <b>Jenis</b>
                        <br>
                        <?= $promo->type_name ?>
                        <br><br>
                        <b>Nama Barang</b>
                        <br>
                        <?= $promo->product_name ?>
                        <br><br>
                        <?php if ($promo->percentage != NULL): ?>
                           <b>Promo Persenan</b>
                           <br>
                           <?= $promo->percentage ?>%
                        <?php elseif($promo->nominal != NULL): ?>
                           <b>Promo Nominal</b>
                           <br>
                           Rp.<?= number_format($promo->nominal ,0,",",".") ?>
                       <?php endif ?>
                    </div>
                    <div class="col-md-6">
                        <b>Tanggal Mulai</b>
                        <br>
                        <?= date("d-m-Y",strtotime($promo->promo_date_start)) ?>
                        <br><br>
                        <b>Tanggal Berakhir</b>
                        <br>
                        <?= date("d-m-Y",strtotime($promo->promo_date_end)) ?>
                        <br><br>
                        <b>Role Akun</b>
                        <br>
                        <?= config("App")->roles[$promo->promo_role] ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<script type="text/javascript">
    $("#productSelect").change(function(){
        $.ajax({
            url: "<?= base_url('AdminSub/ajax/sale/product/prices') ?>",
            type: "post",
            data: {
                product     : $(this).val(),
            },
            success: function(html) {
             // console.log(html);
                $("#productPriceSelect").html(html)
            }
        })
    })
</script>
<?= $this->endSection() ?>