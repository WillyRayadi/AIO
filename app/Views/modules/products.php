<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengelolaan Barang</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal Add -->
<form method="post" action="<?= base_url("products/add") ?>">
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false"  aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Barang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group" id="merk">
                                <label for="Brands">Merk</label>
                                <select name="brands" id="Brand" class="select2bs4-modalAdd" onchange="updateFields()">
                                    <option selected disabled>-- Pilih --</option>
                                    <?php $no = 0;
                                    foreach ($brands as $item) : $no++; ?>
                                        <option value="<?= $item->brand_code ?>|<?= $item->brand_name ?>"><?= $item->brand_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" id="categoryForm" style="display: none;">
                                <label for="exampleFormControlSelect1">Kategori</label>
                                <select class="form-control" id="category" name="category_id" onchange="loadSubCategories()" style="text-transform: uppercase;">
                                    <option selected disabled>-- Pilih --</option>
                                    <?php
                                    foreach ($categories as $category) {
                                        if ($category->name == "Tidak Berkategori") {
                                            $categSelected = "selected";
                                        } else {
                                            $categSelected = "";
                                        }
                                    ?>
                                        <option value="<?= $category->id ?>|<?= $category->name ?>" class="<?= $categSelected ?>"><?= $category->name ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div class="form-group" id="subForm" style="display: none;">
                                <label class='form-label' id="subKategoriLabel">Sub Kategori</label>
                                <select class="form-control" id="subKategoriSelect" name="code_id">
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : null ?>" style="text-transform: uppercase;" id="name" name="name" placeholder="nama" required>
                                <div class="invalid-feedback">
                                    <?= $validation->getError("name") ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Kapasitas/Ukuran</label>
                                <select class="form-control select2bs4-capacity" name="kapasitas" required>
                                    <option value="0">-</option>
                                    <?php
                                    foreach ($capacity as $kps) {
                                    echo "
                                        <option value='" . $kps->id . "'>" . $kps->kapasitas . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">Tipe</label>
                                <input type="text" class="form-control" id="tipe" name="tipe" placeholder="tipe" style="text-transform: uppercase;" required value="<?= old('tipe') ?>" />
                            </div>

                            <div class="form-group">
                                <label for="">Nomor SKU</label>
                                <input type="text" class="form-control <?= $validation->hasError('sku_number') ? 'is-invalid' : null ?>" id="sku_nomor" name="sku_number" placeholder="nomor sku" value="<?= old("sku_number") ?>" style="text-transform: uppercase;" required>
                                <div id="validation_message"></div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError("sku_number") ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="unit">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" placeholder="Satuan" value="<?= old('unit') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class='form-group'>
                                <label class='form-label'>Harga Utama (1)</label>
                                <input type='number' step='any' name='price' class='form-control' placeholder="Harga Utama (1)" value="<?= old('price') ?>" required>
                            </div>

                            <div class='form-group'>
                                <label class="form-label">Harga HYD Retail</label>
                                <input type="number" step="any" name="hyd_retail" class="form-control" placeholder="Abaikan jika tidak ada">
                            </div>

                            <div class='form-group'>
                                <label class="form-label">Harga HYD Online</label>
                                <input type="number" step="any" name="hyd_online" class="form-control" placeholder="Abaikan jika tidak ada">
                            </div>

                            <div class='form-group'>
                                <label class="form-label">Harga HYD Grosir</label>
                                <input type="number" name="hyd_grosir" class="form-control" placeholder="Abaikan jika tidak ada">
                            </div>

                            <div class='mb-2'>
                                <label class='form-label'>Rumus harga</label>
                                <select class='form-control' name='formula' required>
                                    <?php
                                    foreach ($prices as $price) {
                                        echo "
                                        <option value='" . $price->id . "'>" . $price->code . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="details">Detail</label>
                                <textarea class="form-control" name="details" id="details" rows="3" placeholder="detail" value="<?= old('details') ?>" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Add -->

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12 mb-3">

            <!-- <a href="<?= base_url('product/export') ?>" class="btn btn-primary float-right" style="margin-left: 20px">
    		<i class="fas fa-file-excel"></i>
    		Export Data
    	  </a>-->

            <?php
            $db = \Config\Database::connect();
            $session = \Config\Services::session(); 
            $admins = $db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
            $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

            if($roles->products_buat != NULL): ?>
            <button type="button" class="btn btn-primary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalAdd">
                <i class='fa fa-plus'></i>
                Tambah Barang
            </button>
            <?php endif ?>

            <!-- <button type="button" class="btn btn-secondary float-right" style="margin-left:20px;" data-toggle="modal" data-target="#modalPengelolaanStock">
                <i class="fa fa-cog"></i>
                Pengelolaan Stok
            </button> -->

        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm">
                            <h3 class="card-title">Data Barang</h3>
                        </div>
                        <div class="col-sm">
                            <select id="warehouseFilter" class="form-control select2bs4">
                                <option value="Pilih">Pilih Gudang</option>
                                <option value="3">Cirebon - ASS</option>
                                <option value="2">Cirebon - Kalijaga</option>
                                <option value="8">Cirebon - Premium</option>
                                <option value="4">Gudang Bandung</option>
                                <option value="1">Gudang Cirebon</option>
                                <option value="5">Gudang Tasikmalaya</option>
                                <option value="6">Inden</option>
                                <option value="7">Service Center Cirebon</option>
                                <option value="10">Service Center Tasik</option>
                                <option value="9">Tasikmalaya - Pasar Wetan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="row mb-3" style="display:none;">
                        <div class="col-sm w-25">
                            <div class="form-group">
                                <label for="locationSelect">Lokasi :</label>
                                <select id="locationSelect" class="form-control select2bs4">
                                    <option value="Pilih">Pilih Lokasi</option>
                                    <option value="Cirebon">Cirebon</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Tasik">Tasikmalaya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm w-25" id="warehouse">
                            <div class="form-group">
                                <label for="warehouseSelect">Gudang :</label>
                                <select id="warehouseSelect" class="form-control select2bs4">

                                </select>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped" id='example'>
                        <thead>
                            <tr>
                                <th class='text-center' rowspan='2'>No</th>
                                <th class='text-center' rowspan='2'>Nama Barang</th>
                                <th class='text-center' rowspan='2'>Kategori</th>
                                <th class='text-center' colspan='<?= count($warehouses) ?>'>Persediaan Gudang</th>
                                <!--<th class='text-center'rowspan='2'>Display</th>-->
                                <th class="text-center" rowspan='2'>Dipesan</th>
                                
                                <?php
                                    $db = \Config\Database::connect();
                                    $session = \Config\Services::session(); 
                                    $admins = $db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                    $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                                    if($roles->products_edit != NULL): ?>
                                        <th class='text-center' rowspan='2'></th>
                                <?php endif ?>
                            </tr>
                            <tr>
                                <?php
                                foreach ($warehouses as $warehouse) {
                                ?>
                                    <th class='text-center'><?= $warehouse->name ?></th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 0;
                            foreach ($getProducts as $item) : $no++ ?>
                                <tr>
                                    <td class="text-center"><?= $no ?></td>
                                    <td><?= $item["product_name"] ?></td>
                                    <td class="text-center"><?= $item["category_name"] ?></td>
                                    <?php foreach($warehouses as $gudang): ?>
                                        <td class="text-center"><?= $item["stocks_".$gudang->name] ?></td>
                                    <?php endforeach; ?>
                                    <td class="ajax-data text-center"></td>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $session = \Config\Services::session(); 
                                    $admins = $db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
                                    $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                                    if($roles->products_edit != NULL): ?>
                                    <td class='text-center'>
                                        <a href="<?= base_url('products/' . $item["product_id"] . '/manage') ?>" class='btn btn-sm btn-success' title="Edit">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                    </td>
                                    <?php endif ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        var BaseUrlSKU = "<?= base_url('products/ajaxGetSKU') ?>";
        var BaseUrlLoad = "<?= base_url('products/ajaxGetCategories') ?>";
    </script>

    <script src="<?= base_url("public/js/updateFields.js") ?>"></script>
    <script src="<?= base_url("public/js/loadSubCategories.js") ?>"></script>
    <script src="<?= base_url("public/js/checkSKU.js") ?>"></script>

    <script type="text/javascript">
        function edit(id, category_id, sku_number, code_id, name, unit, details) {
            $("#editIDGoods").val(id)
            $("#editCategoryIDGoods").val(category_id)
            $("#editSkuNumberGoods").val(sku_number)
            $("#editcode_idGoods").val(code_id)
            $("#editNameGoods").val(name)
            $("#editUnitGoods").val(unit)
            $("#editDetailsGoods").html(details)
        }
    </script>
    
    <script>
        $(document).ready(function() {
        
        // $('#capacitys').select2();
            
        var Table = $('#example').DataTable({
               columnDefs: [{
                   targets: [3,4,5,6,7,8,9],
                   visible: true
               }],
               orderTop: true
           });
           
           loadSalesQuantity();
           
           $('#warehouseFilter').on("change", function(){
               const selectedWarehouse = $(this).val();
               
               if(selectedWarehouse == "3"){
                   Table.columns([3]).visible(true, false);
                   Table.columns([4,5,6,7,8,9, 10, 11,12]).visible(false, false);
               }else if(selectedWarehouse == "2"){
                   Table.columns([4]).visible(true, false);
                   Table.columns([3,5,6,7,8,9,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "8"){
                   Table.columns([5]).visible(true, false);
                   Table.columns([3,4,6,7,8,9,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "4"){
                   Table.columns([6]).visible(true, false);
                   Table.columns([3,4,5,7,8,9,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "1"){
                   Table.columns([7]).visible(true, false);
                   Table.columns([3,4,5,6,8,9,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "5"){
                   Table.columns([8]).visible(true, false);
                   Table.columns([3,4,5,6,7,9,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "6"){
                   Table.columns([9]).visible(true, false);
                   Table.columns([3,4,5,6,7,8,10,11,12]).visible(false, false);
               }else if(selectedWarehouse == "7"){
                   Table.columns([10]).visible(true, false);
                   Table.columns([3,4,5,6,7,8,9,11,12]).visible(false, false);
               }else if(selectedWarehouse == "10"){
                   Table.columns([11]).visible(true, false);
                   Table.columns([3,4,5,6,7,8,9,10,12]).visible(false, false);
               }else if(selectedWarehouse == "9"){
                   Table.columns([12]).visible(true, false);
                   Table.columns([3,4,5,6,7,8,9,10,11]).visible(false, false);
               }else{
                   Table.columns([3,4,5,6,7,8,9,10,11,12]).visible(true, true);
               }
               
               loadSalesQuantity();
           });
        });
        
        
        
        function loadSalesQuantity()
        {
            const selectedWarehouse = $('#warehouseFilter').val();
            $.ajax({
               url: "<?= base_url('products/get/sales/quantity') ?>",
               type: "GET",
               dataType: "json",
               data: {
                   warehouse_id: selectedWarehouse
               },
               success: function(response){
                   const Table = $('#example').DataTable();
                   
                   console.log(response);
                   
                //   const SaleQuantity = response.map(function(item){
                //       return [item.sale_quantity];
                //   });
                   
                //   Table.column(13).data().each(function(value, index){
                //       Table.cell(index, 13).data(SaleQuantity[index]); 
                //   });
                   
                    var DeliveredArray = response.map(function(item) {
                        return parseInt(item.delivered) || 0;
                    });

                    var saleQuantityArray = response.map(function(item) {
                        return parseInt(item.sale_quantity) || 0;
                    });

                    Table.column(13).data().each(function(value, index) {
                        // if(saleQuantityArray[index] !== 0){
                            var newValue = (saleQuantityArray[index] || 0) - (DeliveredArray[index] || 0);
                            Table.cell(index, 13).data(newValue + " Unit");
                        // }else{
                        //     var newValue = (saleQuantityArray[index] || 0);
                        //     Table.cell(index, 13).data(newValue + " Unit");
                        // }
                    });
                   
                  Table.draw();
               },
               error: function(xhr, status, error){
                   console.error('Error:', error);
               }
            });
        }
    </script>

    <?= $this->endSection() ?>

    <?= $this->section("page_script") ?>
    <script type="text/javascript">
        $("#good_id").change(function() {
            console.log('#good_id');
            $.ajax({
                url: "<?= base_url('products/search-filter-stock') ?>",
                type: "post",
                data: {
                    good_id: $('#good_id').val(),
                },
                success: function(data) {
                    $("#data").html(data)
                }
            });
        });
    </script>
    <?= $this->endSection() ?>