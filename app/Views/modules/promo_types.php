<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Data Jenis Promo
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Data Jenis Promo</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("promo/types/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Jenis Promo</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editID">
                    <div class="form-group">
                        <label>Jenis Promo</label>
                        <input type='text' name='name' class='form-control' id="editName" required placeholder='Jenis Promo'>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Edit -->

<div class="row">
    <div class="col-md-4">
        <form method="post" action="<?= base_url('promo/types/add') ?>">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="card-title">Tambah Jenis Promo</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Jenis Promo</label>
                        <input type='text' name='name' class='form-control' required placeholder='Jenis Promo'>
                    </div>
                </div>
                <div class="card-footer">
                    <button type='submit' class='btn btn-primary'>
                        <i class='fa fa-plus'></i>
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Jenis Promo</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped table-hover" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>Jenis Promo</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($types as $type) : ?>
                        <tr>
                            <td><?= $type->name ?></td>
                            <td class='text-center'>
                                <?php if($type->name === config("App")->uncategorized) : ?>

                                <?php else : ?>
                                <a href="javascript:void(0)" data-target="#modalEdit" data-toggle="modal" onclick="edit('<?= $type->id ?>','<?= $type->name ?>')" class='btn btn-sm btn-success'>
                                    <i class='fa fa-edit'></i>
                                </a>
                                <a href="<?= base_url('promo/types/'.$type->id.'/delete') ?>" class='btn btn-sm btn-danger' onclick="return confirm('Yakin hapus jenis promo <?= $type->name ?>.?')">
                                    <i class='fa fa-trash'></i>
                                </a>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
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

function edit(id,name){
    $("#editID").val(id)
    $("#editName").val(name)
}

</script>

<?= $this->endSection() ?>