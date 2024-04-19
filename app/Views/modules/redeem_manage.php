    <?= $this->extend("general/template") ?>

    <?= $this->section("page_title") ?>
    <h1>Kelola Penukaran</h1>
    <?= $this->endSection() ?>

    <?= $this->section("page_breadcrumb") ?>
    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
    <li class="breadcrumb-item active">Kelola Penukaran</li>
    <?= $this->endSection() ?>

    <?= $this->section('page_content') ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
        <div class="modal-header bg-info">
            <h5 class="modal-title" id="addModalLabel">Redeem Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" action="<?= base_url('add/product/redeem')?>">
                <input type="hidden" name="id" value="<?= $datas->id ?>">
                <input type="hidden" name="contacts" value="<?= $datas->contact_id ?>">

                    <div class="form-group">
                        <label for="label-product">Nama Produk</label>
                        <select name="products" class="select2bs4" id='productSelect'>
                            <option value="">Pilih Produk</option>
                            <?php foreach($products as $data){ ?>
                                <option value="<?= $data->id ?>"><?= $data->product_name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class='label-warehouses'>Gudang</label>
                        <select name="warehouses" class="form-control" required id='warehouse'>
                            <option value=''>Pilih Gudang</option>
                            <?php foreach($warehouses as $warehouse){ ?>
                                <option value="<?= $warehouse->id ?>"><?= $warehouse->name ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-address">Alamat Penerima</label>
                        <textarea readonly="true" class="form-control"><?= $datas->address ?></textarea> 
                    </div>
            </div>
            <div class="modal-footer">
                <button class='btn btn-success'>
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
    </div>

    <div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pelanggan</h5>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <b>Nomer Redeem</b>
                    <p><?= $datas->number ?></p>
                </div>
                <div class="col-md-12">
                    <b>Nama User</b>
                    <p><?= $datas->contact_name ?></p>
                </div>
                <div class="col-md-12">
                    <b>Tanggal Redeem</b>
                    <p><?= $datas->dates ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">Barang Redeem</h3>
                <a href="#" data-toggle="modal" data-target="#addModal" class="float-right btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $key => $value) { ?>
                    <tr>
                        <td class="text-center"><?= $value->product_name ?></td>
                        <td class="text-center"><?= $value->redeem_qty ?> Unit</td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
    <?= $this->endSection() ?>
    <?= $this->section('page_script') ?>

    <script>
        $("#productSelect").change(function(){
            $.ajax({
                url: "<?= base_url('sales/ajax/sale/product/stocks') ?>",
                type: "post",
                data: {
                    product     : $(this).val(),
                }, 
                success: function(html) {
                myText = html.split("~");
                stocks = parseInt(myText[0])

                $("#productQtyInput").attr("min",1)
    
                if(stocks > 10){
                    stocks = "10+"
                }else{
                    stocks = stocks
                }

                $("#productStockPreview").html(stocks+" "+myText[1])

            }
        })

            load_warehouse($(this).val(),'');

            $.ajax({
                url: "<?= base_url('sales/ajax/sale/product/prices') ?>",
                type: "post",
                data: {
                    product     : $(this).val(),
                },
                success: function(html) {
                $("#productPriceSelect").html(html)
            }
        })

            $("#customPrice").attr("readonly",false)
            $("#customPrice").attr("placeholder","Silahkan tulis harga di sini")
        })

        $("#productPriceSelect").change(function(){    
            $.ajax({
                url: "<?= base_url('sales/ajax/sale/product/promos') ?>",
                type: "post",
                data: {
                    product     : $("#productSelect").val(), price_level : $(this).val()
                },
                success: function(html) {
                $("#productPromoSelect").html(html)
            }
        })

            $("#customPrice").attr("readonly",false)
            $("#customPrice").attr("placeholder","Silahkan tulis harga di sini")
        })

        function editQty(item, product, name, qty){
            $("#editItemID").val(item)
            $("#editItemProductID").val(product)
            $("#textEditItemName").html(name)
            $("#editItemQty").val(qty)
        }

        function load_warehouse(id_product,warehouse_id){
            $.ajax({
                url: "<?= base_url('sales/ajax/sale/product/all') ?>",
                type: "post",
                data: {
                    product     : id_product,
                    warehouse_id : warehouse_id,
                }, 
                success: function(html) {
                    $("#warehouse").html(html)
                }
            })
        }

    </script>
    <script>
        var nameInput = document.getElementById("name");

        nameInput.addEventListener("input", function() {
            // Mengubah nilai input menjadi huruf besar (uppercase)
            this.value = this.value.toUpperCase();
        });
    </script>

    <?= $this->endSection() ?>