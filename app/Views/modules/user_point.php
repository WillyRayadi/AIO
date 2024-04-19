<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
<h1>Point Anggota</h1>
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Point Anggota</li>
<?= $this->endSection() ?>

<?= $this->section('page_content') ?>
<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Point User</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="datatables-default">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Poin Tersedia</th>
                    <!--<th class="text-center">Aksi</th>-->
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = 0;
                    foreach($user as $key => $value){ 
                    $no++;    
                ?>
                <tr>
                    <td class="text-center">
                        <?= $no; ?>
                    </td>
                    <td class="text-center"><?= $value->contact_name ?></td>
                    <td class="text-center"><?= $value->points ?> Point</td>
                    <!--<td class="text-center">-->
                    <!--    <a class="btn btn-sm btn-success" href="<?= base_url('redeem/manage/'.$value->id.'/user'.'/'.$value->contact_id) ?>">-->
                    <!--        <i class="fas fa-cog"></i>-->
                    <!--    </a>-->
                    <!--    <a class="btn btn-sm btn-danger" href="<?= base_url('delete/redeem/point/'.$value->id) ?>">-->
                    <!--        <i class="fas fa-trash"></i>-->
                    <!--    </a>-->
                    <!--</td>-->
                </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection()?>