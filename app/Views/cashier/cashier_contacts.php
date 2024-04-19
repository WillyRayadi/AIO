<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Kontak
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Kontak</li>
<?= $this->endSection() ?>
<?= $this->section("page_content") ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Pemasok</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped dataTable dtr-inline" id="datatables-default">
                        <thead>
                            <tr>
                                <th>Tipe</th>
                                <th>Nama</th>
                                <th>Nomer Telpon</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contacts as $contact) {?>
                            <tr>
                                <td>
                                    <?php
                                        if ($contact->type == 1) {
                                            echo 'Pemasok';
                                        } else {
                                            echo  'Pelanggan';
                                        }
                                    ?>
                                </td>
                                <td class="text-uppercase"><?= $contact->name ?></td>
                                <td><?= $contact->phone ?></td>
                                <td><?= $contact->address ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container-fluid -->
<?= $this->endSection() ?>