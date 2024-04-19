<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Akun Pengelola
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Akun Pengelola</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>


<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="<?= base_url('account/view_add_account'); ?>">
                <button type="button" class="btn btn-primary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalAdd">
                    <i class='fa fa-plus'></i>
                    Tambah Akun
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Akun</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $d = 0;
                            foreach ($accounts as $account) {
                                $d++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= $d ?></td>
                                    <td><?= $account->name ?></td>
                                    <td><?= $account->phone ?></td>
                                    <td><?= $account->email ?></td>
                                    <td><?= $account->address ?></td>
                                    <td><?= config("App")->roles[$account->role] ?></td>
                                    <td class='text-center'>
                                        <a href="<?= base_url('account/view_edit_account') . '/' . $account->id; ?>" class='btn btn-sm btn-secondary text-white'>
                                            <i class="fa fa-cog"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection() ?>