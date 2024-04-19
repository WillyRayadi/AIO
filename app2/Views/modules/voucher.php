<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Voucher
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Voucher</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<button type="button" class="btn btn-primary mb-2" data-target="#modalAdd" data-toggle="modal"><i class="fas fa-plus-square"></i></button>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h4>Data Voucher</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Masa Berlaku</th>
                    <th>Nilai Voucher</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 0;
                foreach ($voucher as $item) : $no++; ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $item->product_name ?></td>
                        <td><?= $item->validity_period ?></td>
                        <td><?= "Rp. " . number_format($item->voucher_value, 0, ",", ".") ?></td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="<?= base_url("products/voucher/$item->id/edit") ?>"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-sm btn-danger" href="<?= base_url("products/voucher/" . $item->id . "/delete") ?>"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('products/voucher/add') ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Pilih Products</label>
                        <select name="product_id" id="productSelect" onchange="loadStocks()" class="form-control select2bs4-modalAdd" required>
                            <option value="">Pilih Barang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Pilih Gudang</label>
                        <select class="form-control select2bs4-modalAdd" name="warehouse_name" id="warehouses" required>
                            <option value="">Pilih Barang Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kuantitas</label>
                        <input type="text" name="quantity" class="form-control" placeholder="Kuantitas" required></input>
                    </div>
                    <div class="form-group">
                        <label for="">Nilai Voucher</label>
                        <input type="number" name="voucher_value" class="form-control" placeholder="Nilai Voucher" required>
                    </div>
                    <div class="form-group">
                        <label for="">Masa Berlaku Voucher</label>
                        <input type="date" name="validity_period" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Point Yang Dibutuhkan</label>
                        <input type="number" name="required_points" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div>
                        <label>Gambar Produk</label>
                        <div class="custom-file">
                            <input type="file" name="image" onchange="loadFileName()" class="custom-file-input" id="customFile" required>
                            <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadProducts();
    });

    function loadProducts() {
        $.ajax({
            url: "<?= base_url("products/get/products") ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                const data = response;
                const productSelect = document.getElementById("productSelect");
                if (data != null) {
                    data.forEach(function(item) {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.name;
                        productSelect.appendChild(option);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("ERROR_", error);
            }
        });
    }
    
    function loadStocks()
    {
        const id = document.getElementById("productSelect").value;
        
        $.ajax({
          url: "<?= base_url('products/ajax/get/stocks') ?>",
          type: "GET",
          dataType: "json",
          data: {
              product_id: id
          },
          success: function(response){
              const data = response;
              const warehouseSelect = document.getElementById("warehouses");
              
              warehouseSelect.innerHTML = "";
              
              if(data != null){
                  
                  const defaultSelect = document.createElement("option");
                  defaultSelect.value = "Pilih Gudang";
                  defaultSelect.textContent = "Pilih Gudang";
                  warehouseSelect.appendChild(defaultSelect);
                  
                  data.forEach(function(item){
                      for(let key in item){
                          if(item.hasOwnProperty(key)){
                              const option = document.createElement("option");
                              option.value = key;
                              option.textContent = key + " (" + item[key] + ")";
                              warehouseSelect.appendChild(option);
                          }
                      }
                  })
              }
          },
          error: function(error){
              console.error("Error:", error);
          }
        });
    }
</script>

<script>
    function loadFileName()
    {
        const inputFile = document.querySelector(".custom-file-input");
        const inputLabel = document.querySelector(".custom-file-label");
        
        inputLabel.textContent = inputFile.files[0].name;
    }
</script>

<script type="text/javascript">
    function edit(id, name) {
        $("#editIDcode").val(id)
        $("#editNamecode").val(name)
    }
</script>

</div><!-- /.container-fluid -->


<?= $this->endSection() ?>