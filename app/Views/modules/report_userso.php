<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Sales
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report Sales</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Penjualan Per Sales</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('sales/export_id') ?>" method="get" target="_blank">
                <div class="row">
                    
                    <div class="col form-group">
                        <label class="font-weight-bold">Pilih Role</label>
                        <select name="role" id="role" onchange="getUser()" class="form-control select2bs4">
                            <option value="Pilih Role">Pilih Role</option>
                            <option value="2">Sales Retail</option>
                            <option value="3">Sales Grosir</option>
                        </select>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold">Nama Sales</label>
                        <select name="adminname" id="adminname" class="form-control select2bs4">  
                            <option value="Pilih Role">Pilih Role Terlebih Dahulu</option>
                        </select>
                    </div>

                     <div class="col form-group">
                        <label class="font-weight-bold">Mulai Tanggal</label>
                        <input class="form-control" name="tanggalawal" type="date" required></input>
                    </div>

                    <div class="col form-group">
                        <label class="font-weight-bold font-weight-italic">Sampai Tanggal</label>
                        <input class="form-control" name="tanggalakhir" type="date" required=""></input>
                    </div>

                        <button class="col btn btn-success" onclick="<?= base_url('sales/reports') ?>" style="width: 50%; height: 50%; margin-top: 32px;">
                            <i class="fas fa-print"></i>&nbsp; Cetak Laporan
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
    
<script>
    document.getElementById("role").addEventListener("change", getUser);

    function getUser() {
        var role = document.getElementById("role").value;
        var BaseUrl = "<?= base_url("sales/ajaxGetUser") ?>";
        var adminSelect = document.getElementById("adminname");
        adminSelect.innerHTML = "";
        $.ajax({
            url: BaseUrl,
            type: "POST",
            data: {
                role: role
            },
            dataType: "json",
            success: function(response) {
                var Name = response;

                if(Name.length > 0)
                {
                    var chooseOption = document.createElement("option");
                    chooseOption.value = "Pilih Sales";
                    chooseOption.textContent = "Pilih Sales";
                    adminSelect.insertBefore(chooseOption, adminSelect.firstChild);
                
                    Name.forEach(function(name) {
                        var option = document.createElement("option");
                        option.value = name;
                        option.textContent = name;
                        adminSelect.appendChild(option);
                    });
                }else{
                    var notFound = document.createElement("option");
                    notFound.value = "";
                    notFound.textContent = "Pilih Role Terlebih Dahulu";
                    notFound.selected = true;
                    adminSelect.appendChild(notFound);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
</script>

    <?= $this->endSection() ?>

    <?= $this->Section("page_script") ?>

    <?= $this->endSection() ?>