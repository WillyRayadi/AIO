<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Laporan Penjualan
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('reports'); ?>">Reports</a></li>
<li class="breadcrumb-item active">Report SO</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>


<div class="card">
    <div class="card-header bg-info">
        <h5 class="card-title">Report Data Penjualan Per Barang</h5>
    </div>
    <div class="card-body">
        <div class="container align-items-center">
            <form action="<?= base_url('sales/export_per_products') ?>" method="get" target="_blank">
                <div class="row">

                    <div class="col form-group">
                        <label class="font-weight-bold">Pilih Produk</label>
                        <select name="products" id="products" class="form-control select2bs4" required>
                            <option value="Pilih Barang">Pilih Barang</option>
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
                        <i class="fas fa-file"></i>&nbsp; Cetak Laporan
                    </button>

                </div>
            </form>
        </div>
    </div>

    <br>
</div>




<?= $this->endSection() ?>

<?= $this->Section("page_script") ?>

<script>
    document.addEventListener("DOMContentLoaded", function(){
        loadProducts();
    });
    
    function loadProducts(){
        $.ajax({
           url: "<?= base_url('products/get/products') ?>",
           type: "GET",
           dataType: "json",
           success: function(response){
               var ProductOpt = document.getElementById("products");
               var data = response;
               
               data.forEach(function(dataItem){
                  var option = document.createElement("option");
                  option.value = dataItem.id;
                  option.textContent = dataItem.name;
                  ProductOpt.appendChild(option);
               });
           },
           error: function(xhr, status, error){
               console.error("Error:", error);
           }
        });
    }
</script>

<?= $this->endSection() ?>