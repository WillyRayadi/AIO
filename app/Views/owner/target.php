<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Target Penjualan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Target Penjualan</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("owner/target/save") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Target</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editID">
                    <b id="adminName"></b>
                    <br>
                    <small id="adminUsername"></small>
                    <hr>
                    <div class='form-group'>
                        <label>Target</label>
                        <input type='number' step='any' name='target' class='form-control' placeholder='Target' id='editTarget' required>
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
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Akun</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped" id='datatables-default'>
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Username</th>
                            <th class='text-center'>Nama</th>
                            <th class='text-center'>Telp / Hp</th>
                            <th class='text-center'>Role</th>
                            <th class='text-center'>Target</th>
                            <th class='text-center'></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $adminNo = 0; ?>
                        <?php foreach($admins as $admin): ?>
                        <?php $adminNo++; ?>
                        <tr>
                            <td class='text-center'><?= $adminNo ?></td>
                            <td><?= $admin->username ?></td>
                            <td><?= $admin->name ?></td>
                            <td><?= $admin->phone ?></td>
                            <td><?= config("App")->roles[$admin->role] ?></td>
                            <td class='text-right'>Rp. <?= number_format($admin->sale_target,0,",",".") ?></td>
                            <td class='text-center'>
                                <a href="javascript:void(0)" onclick="edit('<?= $admin->id ?>','<?= $admin->username ?>','<?= $admin->name ?>','<?= $admin->sale_target ?>')" class='btn btn-success btn-sm' data-toggle="modal" data-target="#modalEdit">
                                    <i class='fa fa-edit'></i>
                                </a>
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
function edit(id,username,name,target){
    $("#editID").val(id)
    $("#editTarget").val(target)
    $("#adminUsername").html(username)
    $("#adminName").html(name)
}
</script>

<?= $this->endSection() ?>