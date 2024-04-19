<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Management Role
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active"> Pengelolaan Role</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<form action="<?= base_url('products/buys/add') ?>" method="post">
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-primary'>
                        <i class='fa fa-plus'></i> Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>



<!-- <div class='row mb-2'>
    <div class='col-md-12'>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalAdd">
            <i class='fa fa-plus'></i>
            Custom Role
        </button>
    </div>
</div>
 -->
<div class='row'>
    <div class="col-lg">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Management Role</h3>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered table-hover" id="datatables-default">
                    <thead>
                        <tr>
                            <th class="text-center">Role Akun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?= $role->role_name ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('role/manage/account/'.$role->id)?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>