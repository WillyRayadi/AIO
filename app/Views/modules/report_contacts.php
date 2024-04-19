<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Kontak
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
    <li class="breadcrumb-item"><a href="<?= base_url('reportss_'); ?>">Reports</a></li>
    <li class="breadcrumb-item active">Report Kontak</li>
<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>
<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Contacts</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('export/contacts') ?>" method="get" target="_blank">
                <div class="row">
                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Contact Type</label>
                        <select name="type_contacts" class="form-control">
                            <option>-- Type Contact --</option>
                            <option value="1">Supplier</option>
                            <option value="2">Customer</option>
                        </select>
                    </div>
                    
                    <button class="col-sm-5 btn btn-success" style="width: 50%; height: 50%; margin-top: 32px;">
                        <i class="fas fa-file"></i>&nbsp; Export Data
                    </button>
                </div>
            </form>
        </div>
    </div>

 <br>
</div>

<script>
        $(document).ready(function() {
            $('#datatables-default').DataTable( {
                dom: 'Bfrtip',
                "bPaginate": false,
                "bInfo": false,
            } );
        } );
</script>

<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<?= $this->endSection() ?>