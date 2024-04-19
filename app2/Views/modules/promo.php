<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Promo
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Promo</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Add -->
<form method="post" action="<?= base_url("promo/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Promo</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">    
                        <label>Jenis Promo</label>
                        <select name='type' class='form-control'>
                            <?php foreach($types as $type): ?>
                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barang Yang Promo</label>
                        <select name='product' class='form-control select2bs4'>
                            <?php foreach($products as $product) : ?>
                                <option value="<?= $product->id ?>"><?= $product->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Promo</label>
                        <input type='text' name='code' class='form-control' required placeholder="Kode Promo">
                    </div> 

                    <div class="form-group">
                        <label>Role User</label>
                        <select class="select2bs4" name="roles">
                            <option>--Pilih Role Akun--</option>
                            <option value="2">Sales Retail</option>
                            <option value="3">Sales Grosir</option>
                        </select>
                    </div>

                    <div class="row">

                        <div class="col">
                            <div class="form-group">
                                <label>Persenan</label>
                                <div class="input-group">
                                    <input type="number" name="percentage" class="form-control"  placeholder="-">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <input class="form-control" name="nominal" type="number" placeholder="-">
                                    <div class="input-group-append">
                                        <span class="input-group-text">IDR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Aktif</label>
                                <input type='date' name='date_start' class='form-control' required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Berhenti</label>
                                <input type='date' name='date_end' class='form-control' required>
                            </div>
                        </div>

                    </div>  
                    <div class="form-group">
                        <label>Penjelasan / Keterangan</label>
                        <textarea name='details' class='form-control' placeholder="Tulis Penjelasan / Keterangan Promo Di Sini"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class='fa fa-plus'></i>
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Add -->

<!-- Modal Edit -->
<form method="post" action="<?= base_url("promo/save") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">Edit Promo</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='hidden' name='id' id="editID">
                    <div class="form-group">
                        <label>Jenis Promo</label>
                        <select name='type' id="editType" class='form-control'>
                            <?php foreach($types as $type) : ?>
                            <option value="<?= $type->id ?>"><?= $type->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Barang Yang Promo</label>
                        <select name='product' id='editProduct' class='form-control'>
                            <?php foreach($products as $product) : ?>
                            <option value="<?= $product->id ?>"><?= $product->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kode Promo</label>
                        <input type='text' name='code' id='editCode' class='form-control' required placeholder="Kode Promo">
                    </div>           
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Persenan</label>
                                <div class="input-group">
                                    <input type="text" name="percentage" class="form-control" placeholder="Masukkan Diskon Menggunakan Persenan">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <input class="form-control" name="nominal" type="text" placeholder="Masukkan Diskon Menggunakan Nominal">
                                    <div class="input-group-append">
                                        <span class="input-group-text">IDR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type='date' name='date_start'class='form-control' required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Berhenti</label>
                                <input type='date' name='date_end' class='form-control' required>
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label>Penjelasan / Keterangan</label>
                        <textarea name='details' class='form-control' id='editDetails' placeholder="Tulis Penjelasan / Keterangan Promo Di Sini"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class='fa fa-save'></i>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Edit -->

<div class="row">
    <div class="col-md-12">
        <buttoh type='button' class='btn btn-primary float-right' data-toggle='modal' data-target='#modalAdd'>
            <i class='fa fa-plus'></i>
            Tambah
        </buttoh>
        <div class="clearfix"></div>
        <div class="card mt-2">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Promo</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover table-striped" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Jenis Promo</th>
                            <th class='text-center'>Role Akun</th>
                            <th class='text-center'>Tanggal Mulai</th>
                            <th class='text-center'>Tanggal Berhenti</th>
                            <th class='text-center'>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pno = 0;
                        foreach($promos as $promo){
                            $pno++;
                            ?>
                            <tr>
                                <td class='text-center'><?= $pno ?></td>
                                <td>Promo
                                    <?php if ($promo->percentage != NULL): ?>
                                        Persen
                                    <?php elseif($promo->nominal != NULL): ?>
                                        Nominal
                                    <?php elseif ($promo->gifts != NULL): ?>
                                        Hadiah
                                    <?php endif ?>
                                </td>
                                <td><?= config("App")->roles[$promo->promo_role] ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($promo->promo_date_start)) ?></td>
                                <td class='text-right'><?= date("d-m-Y",strtotime($promo->promo_date_end)) ?></td>
                                <td class='text-center'>
                                    <a href="<?= base_url('promo/'.$promo->promo_id.'/delete') ?>" style="margin-top: 4px;" onclick="return confirm('Yakin hapus promo dengan kode <?= $promo->promo_code ?>.?')" class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </a><br>
                                    <a href="<?= base_url('promo/'.$promo->promo_id.'/gifts') ?>" style="margin-top: 4px;" class='btn btn-sm btn-success' title="Produk Bundling / Gift">
                                        <i class='fa fa-cog'></i>
                                    </a><br>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<script type="text/javascript">
function edit(id){
    $.ajax({
        url: "<?= base_url('promo/ajax/edit') ?>",
        type: "post",
        data: {
            id     : id,
        },
        success: function(response) {
            response = JSON.parse(response)

            $("#editID").val(id)
            $("#editType").val(response.type_id).change()
            $("#editProduct").val(response.product_id).change()
            $("#editPriceLevel").val(response.price_level).change()
            $("#editCode").val(response.code)
            $("#editStart").val(response.date_start)
            $("#editEnd").val(response.date_end)
            $("#editDetails").html(response.details)

        }
    })
}
</script>

<?= $this->endSection() ?>