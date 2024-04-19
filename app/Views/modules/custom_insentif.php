<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Custom Insentif
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Custom Insentif</li>
<?= $this->endSection() ?>
<?= $this->section("page_content") ?>
<div class="card">
    <div class="card-header bg-primary">
        <h5 class="card-title">Insentif Sales</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="datatables-default">
            <thead>
                <tr>
                    <th class="text-center">Nama Sales</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($insentiv as $key => $value) { ?>
                <tr> 
                    <td class="text-center"><a href="<?= base_url('custom/insentif/manage/'.$value->sales_id) ?>" class="nav-link"><?= $value->admin_name ?> (<?= $value->sale_number ?>)</a></td>
                    <td class="text-center"><?= $value->contact_name ?></td>
                    <td class="text-center"><?= $value->sale_date ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('page_script') ?>
    <script type="text/javascript">
        staff baru
    </script>
<?= $this->endSection() ?>