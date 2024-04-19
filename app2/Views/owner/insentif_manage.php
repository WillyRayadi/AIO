<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Manage Insentif Karyawan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/owner/insentif'); ?>">Insentif</a></li>
<li class="breadcrumb-item active">Manage</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-header bg-info">
                <h5 class="card-title">Insentif Karyawan</h5>
            </div>
            <div class="card-body">
            <!-- Content goes here -->
            <form action="<?= base_url('/owner/insentif/save') ?>" method="POST">
                <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>" class="hidden-input">
                <input type="hidden" name="id" value="<?= $insentif->id ?>" class="hidden-input">
                <input type="hidden" name="price_id" value="<?= $insentif->price_id ?>" class="hidden-input">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bonus Insentif</label>
                            <input type='text' name='nama' class='form-control' required value='<?= $insentif->nama ?>' disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rumus Harga</label>
                                <input type="text" class="form-control" value="<?= $insentif->code ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if ($insentif->price_id != 11){ ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 2</label>
                                <input type='number' id='percent' min="0" max="100" step="any" class='form-control' name="level_2" value="<?= $insentif->level_2 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 3</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_3" value="<?= $insentif->level_3 ?>"> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 4</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_4" value="<?= $insentif->level_4 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 5</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_5" value="<?= $insentif->level_5 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 6</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_6" value="<?= $insentif->level_6 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 7</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_7" value="<?= $insentif->level_7 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 8</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_8" value="<?= $insentif->level_8 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 9</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_9" value="<?= $insentif->level_9 ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Level Harga Ke 10</label>
                                <input type='number' min="0" max="100" step="any" class='form-control' name="level_10" value="<?= $insentif->level_10 ?>">
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="col-md-4">
                            <label>Custom Insentif</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="custom_price" value="<?= $insentif->custom_price ?>">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        </div>
                    <?php } ?>
                </div>
            
            <!-- End -->
            </div>
            <div class="card-footer">
                <button type='submit' class='btn btn-success'>
                    <i class='fa fa-save'></i>
                    Simpan
                </button>
            </div>
            </form> 
        </div>
    </div>
</div>

<style>
    .hidden-input{
        display: none;
    }
</style>


<?= $this->endSection() ?>