<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengelolaan Data Barang
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('/products'); ?>">Barang</a></li>
<li class="breadcrumb-item active"><?= $product->name ?></li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<!-- Modal Edit -->
<form method="post" action="<?= base_url("products/edit") ?>">
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button style="color: white;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name='id' value="<?= $product->id ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class='mb-2'>
                                <label class='form-label'>Kategori</label>
                                <select class='form-control' name='category_id' id="category" onchange="loadSubCategory()" required>
                                    <option value="" selected>Pilih Kategori</option>
                                    <?php
                                    foreach ($categories as $category) {
                                        if ($category->id == $product->category_id) {
                                            $selectedCategory = "Selected";
                                        } else {
                                            $selectedCategory = "";
                                        }
                                        echo "
                                        <option style='text-transform:uppercase;' value='" . $category->id . "' $selectedCategory>" . $category->name . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--<div class='mb-2'>-->
                            <!--    <label class='form-label' id="subKategoriLabel">Sub Kategori</label>-->
                            <!--    <select class="form-control" id="subKategoriSelect" name="code_id" required>-->
                            <!--        <option>Pilih Kategori Terlebih Dahulu</option>-->
                            <!--    </select>-->
                            <!--</div>-->

                            <div class='mb-2'>
                                <label class='form-label'>Kode</label>
                                <select class='form-control' name='code_id' required>
                                    <?php
                                    foreach ($codes as $code) {
                                        if ($code->id == $product->code_id) {
                                            $selectedCode = "selected";
                                        } else {
                                            $selectedCode = "";
                                        }
                                        echo "
                                        <option value='" . $code->id . "' $selectedCode>" . $code->name . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!--<div class='mb-2'>-->
                            <!--    <label class='form-label' id="Kapasitas">Kapasitas/Ukuran</label>-->
                            <!--    <select class="form-control" name="kapasitas" required>-->
                            <!--        <option value="0">-</option>-->
                            <?php
                            // foreach ($capacity as $kps) {
                            // echo "
                            //     <option value='" . $kps->id . "'>" . $kps->kapasitas ? $kps->kapasitas : "-" . "</option>
                            //     ";
                            // }
                            ?>
                            <!--    </select>-->
                            <!--</div>-->

                            <div class='mb-2'>
                                <label class='form-label'>Nomor SKU</label>
                                <input type='text' value="<?= $product->sku_number ?>" name='sku_number' class='form-control' placeholder="nomor sku" required>
                            </div>

                            <div class='mb-2'>
                                <label class='form-label'>Nama</label>
                                <input type='text' value="<?= $product->name ?>" name='name' class='form-control' placeholder="nama" required>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Satuan</label>
                                <input type='text' value="<?= $product->unit ?>" name='unit' class='form-control' placeholder="Unit" required>
                            </div>
                            <div class='mb-2'>
                                <label class="form-label">Lebar Produk</label>
                                <div class="input-group">
                                    <input class="form-control" placeholder="Lebar Produk" name='width_product' type="number" style="-moz-appearance: textfield;">
                                    <div class="input-group-append">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Panjang Produk</label>
                                <div class='input-group'>
                                    <input class='form-control' placeholder='Panjang Produk' name='length_product' type="number" style="-moz-appearance: textfield; -webkit-appearance: none;">
                                    <div class="input-group-append">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <label class='form-label'>Tinggi Produk</label>
                                <div class='input-group'>
                                    <input class='form-control' placeholder='Tinggi Produk' name='height_product' type="number" style="-moz-appearance: textfield;">
                                    <div class="input-group-append">
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class='mb-2'>
                                <label class='form-label'>Harga Utama (1)</label>
                                <input type='number' step='any' value="<?= $product->price ?>" name='price' class='form-control' placeholder="Harga Utama (1)" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Harga HYD Retail</label>
                                <input type="number" name="hyd_retail" value="<?= $product->price_hyd_retail ?>" class='form-control' placeholder="Harga HYD Retail">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Harga HYD Online</label>
                                <input type="number" name="hyd_online" value="<?= $product->price_hyd_online ?>" class="form-control" placeholder="Harga HYD Online">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Harga HYD Grosir</label>
                                <input type="number" name="hyd_grosir" value="<?= $product->price_hyd_grosir ?>" class="form-control" placeholder="Harga HYD Grosir">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Harga Cuci Gudang</label>
                                <input type="number" name="price_cg" value="<?= $product->price_cg ?>" class="form-control" placeholder="Harga Cuci Gudang">
                            </div>

                            <div class='mb-2'>
                                <label class='form-label'>Rumus harga</label>
                                <select class='form-control' name='formula' required>
                                    <?php
                                    foreach ($prices as $price) {
                                        if ($price->id == $product->price_id) {
                                            $selectedPrice = "selected";
                                        } else {
                                            $selectedPrice = "";
                                        }
                                        echo "
                                        <option value='" . $price->id . "' $selectedPrice>" . $price->code . "</option>
                                        ";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="editDetailsGoods">Detail</label>
                                <textarea class="form-control" name="details" id="editDetailsGoods" rows="3" placeholder="detail" required><?= nl2br($product->details) ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type='submit' class='btn btn-success'>
                        <i class='fa fa-save'></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- End Of Modal Edit -->

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title float-left">Data Barang</h5>
                <?php if ($session->login_id == 61 || $session->login_id == 135 || $session->login_id == 70 || $session->login_id == 15 || $session->login_id == 9 || $session->login_id == 12) : ?>
                    <a href="javascript:void(0)" title="Edit" data-toggle="modal" data-target="#modalEdit" class="btn btn-success btn-sm float-right text-white">
                        <i class='fa fa-edit'></i>
                        Edit Product
                    </a>
                <?php endif ?>

                <?php
                $db = \Config\Database::connect();
                $session = \Config\Services::session();
                $admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
                $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

                if ($roles->products_hapus != NULL) : ?>
                    <a href="<?= base_url('products') . '/' . $product->id . '/delete' ?>" title="Hapus" onclick="return confirm('Yakin hapus Barang : <?= $product->name ?> ?')" style="margin-right: 5px;" class='float-right btn btn-danger btn-sm text-white float-right'>
                        <i class='fa fa-trash'></i> Hapus
                    </a>
                <?php endif ?>
            </div>
            <div class="card-body">
                <b>SKU</b>
                <br>
                <?= $product->sku_number ?>
                <br><br>
                <b>Nama Barang</b>
                <br>
                <?= $product->name ?>
                <br><br>
                <b>Kapasitas</b>
                <br>
                <?php
                $capacity = $db->table('capacity');
                $capacity->where('id', $product->capacity_id);
                $capacity = $capacity->get();
                $capacity = $capacity->getFirstRow();

                if ($product->capacity_id != 0) {
                    if ($capacity) {
                        echo $capacity->kapasitas;
                    } else {
                        echo "-";
                    }
                } else {
                    echo "-";
                }

                ?>
                <br><br>
                <b>Kategori</b>
                <br>
                <?= $thisCategory->name ?>
                <br><br>

                <b>Panjang Produk</b>
                <br>
                <?php
                if ($product->item_length != NULL) {
                    echo $product->item_length . ' cm' . '<sup>2</sup>';
                } else {
                    echo "Belum Di Ketahui";
                }
                ?>
                <br><br>

                <b>Tinggi Produk</b>
                <br>
                <?php
                if ($product->item_height != NULL) {
                    echo $product->item_height . ' cm' . '<sup>2</sup>';
                } else {
                    echo "Belum Di Ketahui";
                }
                ?>
                <br><br>

                <b>Lebar Produk</b>
                <br>
                <?php
                if ($product->item_width != NULL) {
                    echo $product->item_width . ' cm' . '<sup>2</sup>';
                } else {
                    echo "Belum Di Ketahui";
                }
                ?>

                <br><br>
                <b>Deskripsi Produk</b>
                <br>
                <?= $product->details ?>
                <br><br>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Harga Barang</h5>
            </div>
            <div class="card-body">
                <b>Harga Utama (1) : Rp. <?= number_format($product->price, 0, ",", ".") ?></b>
                <hr>
                <i><?= $thisFormula->code ?></i>
                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>HYD Grosir</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>HYD Retail</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>HYD Online</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: -10px;">
                            <span>Rp. <?= number_format($product->price_hyd_grosir, 0, ",", ".") ?></span>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: -10px;">
                            <span>Rp. <?= number_format($product->price_hyd_retail, 0, ",", ".") ?></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group" style="margin-top: -10px;">
                            <span>Rp. <?= number_format($product->price_hyd_online, 0, ",", ".") ?></span>
                        </div>
                    </div>

                    <?php for ($p = 1; $p <= 9; $p++) : ?>
                        <?php $pPlus = $p + 1; ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>
                                    Harga Ke-<?= $pPlus ?>
                                    <br>
                                    <small>(Harga <?= $p ?> + Margin Harga <?= $pPlus ?>)</small>
                                </label>
                                <br>
                                <div id="priceShowContainer<?= $pPlus ?>"></div>
                            </div>
                        </div>
                        <?php if ($p % 3 == 0) : ?>
                </div>
                <div class='row'>
                <?php else : ?>
                <?php endif ?>
            <?php endfor ?>
                </div>
            </div>
            <div class="card-footer">

                <label>Diperbaharui Oleh (<?php
                                            $admins = $db->table('administrators');
                                            $admins->where('id', $product->last_admin);
                                            $admins = $admins->get();
                                            $admins = $admins->getFirstRow();

                                            if ($product->last_admin != NULL) {
                                                echo $admins->name;
                                            } else {
                                                echo "-";
                                            }
                                            ?>):</label><br>
                <span>Tanggal: <?= $product->last_update ?? "-" ?> <p class="float-right">Harga: <?= $product->last_price ? number_format($product->last_price, 0, ',', '.') : "-"; ?></p></span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Gambar Produk</h5>
            </div>
            <div class="card-body">
                <?php if ($product->files != NULL) : ?>
                    <!-- Display when there is an existing file -->
                    <div class="form-group row" style="display: flex; flex-direction: column;">
                        <label for="td-label">Tampak Depan</label><br>
                        <div style="display: flex; flex-direction: row;">
                            <a href="<?= base_url('public/product_image/' . $product->files) ?>" target="_blank" class='btn btn-success'>
                                <i class='fa fa-file'></i> Lihat Gambar
                            </a>&nbsp;
                            <a href="<?= base_url('delete/image/product/' . $product->id) ?>" onclick="return confirm('Yakin ingin menghapus gambar tampak depan produk : <?= $product->name ?> ?')" class='btn btn-danger'>
                                <i class='fa fa-trash'></i> Hapus Tampak Depan
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <!-- Form action for uploading file -->
                    <form action="<?= base_url('upload/file/image') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <div class="form-group row">
                            <label for='for-label'>Tampak Depan</label>
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control" accept=".png, .jpg, .jpeg, .gif, .pdf">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-upload"></i> Upload Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>


                <?php if ($product->files1) : ?>
                    <!-- Button tampak belakang -->
                    <div class="form-group row" style="display: flex; flex-direction: column;">
                        <label for="tb-label">Tampak Belakang</label>
                        <div style="display: flex; flex-direction: row;">
                            <a href="<?= base_url('public/product_image/' . $product->files1) ?>" target="_blank" class='btn btn-success'>
                                <i class="fa fa-file"></i> Lihat Gambar Belakang
                            </a>&nbsp;
                            <a href="<?= base_url('delete/file/behind/products/' . $product->id) ?>" onclick="return confirm('Yakin ingin menghapus gambar produk belakang produk : <?= $product->name ?> ?')" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Hapus Gambar Belakang
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <form action="<?= base_url('upload/files/behind/images') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <div class="form-group row">
                            <label for='for-label'>Tampak Belakang</label>
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control" accept=".png, .jpg, .jpeg, .gif, .pdf">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-upload"></i> Upload Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if ($product->files2) : ?>
                    <!-- Button tampak belakang -->
                    <div class="form-group row" style="display: flex; flex-direction: column;">
                        <label for="tb-label">Tampak Kiri</label>
                        <div class="form-group row">
                            <a href="<?= base_url('public/product_image/' . $product->files2) ?>" target="_blank" class='btn btn-success'>
                                <i class="fa fa-file"></i> Lihat Gambar Kiri
                            </a>&nbsp;
                            <a href="<?= base_url('delete/file/left/products/' . $product->id) ?>" onclick="return confirm('Yakin ingin menghapus gambar produk belakang produk : <?= $product->name ?> ?')" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Hapus Gambar Kiri
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <form action="<?= base_url('upload/files/left/images') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <div class="form-group row">
                            <label for='for-label'>Tampak Kiri</label>
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control" accept=".png, .jpg, .jpeg, .gif, .pdf">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-upload"></i> Upload Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if ($product->files3) : ?>
                    <!-- Button tampak belakang -->
                    <div class="form-group row" style="display: flex; flex-direction: column;">
                        <label for="tb-label">Tampak Kanan</label><br>
                        <div class="form-group row">
                            <a href="<?= base_url('public/product_image/' . $product->files3) ?>" target="_blank" class='btn btn-success'>
                                <i class="fa fa-file"></i> Lihat Gambar Kanan
                            </a>&nbsp;
                            <a href="<?= base_url('delete/file/right/products/' . $product->id) ?>" onclick="return confirm('Yakin ingin menghapus gambar produk belakang produk : <?= $product->name ?> ?')" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Hapus Gambar Kanan
                            </a>
                        </div>
                    </div>
                <?php else : ?>
                    <form action="<?= base_url('upload/files/right/images') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $product->id ?>">
                        <div class="form-group row">
                            <label for='for-label'>Tampak Kanan</label>
                            <div class="input-group">
                                <input type="file" name="file" id="file" class="form-control" accept=".png, .jpg, .jpeg, .gif, .pdf">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="fas fa-upload"></i> Upload Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Pembelian</h5>
            </div>
            <div class="card-body">
                <?php
                $buys = $db->table("buy_items");
                $buys->select("buy_items.quantity as buy_quantity");
                $buys->select("buys.date as buy_date");
                $buys->select("buys.number as buy_number");
                $buys->select("buys.id as buy_id");
                $buys->select("contacts.name as contact_name");
                $buys->select("warehouses.name as warehouse_name");
                $buys->join("buys", "buy_items.buy_id=buys.id", "left");
                $buys->join("contacts", "buys.supplier_id=contacts.id", "left");
                $buys->join("warehouses", "buys.warehouse_id = warehouses.id", "left");
                $buys->where("buy_items.product_id", $product->id);
                $buys->orderBy("buys.date", "desc");
                $buys->orderBy("buys.id", "desc");

                $buys = $buys->get();
                $buys = $buys->getResultObject();
                ?>
                <div class="table-responsive">
                    <table class="table table-md" id="datatables-default2">
                        <thead>
                            <tr>
                                <th class='text-center'>Tanggal Masuk</th>
                                <th class='text-center'>Nomer Pembelian</th>
                                <th class="text-center">Pemasok</th>
                                <th class="text-center">Lokasi</th>
                                <th class='text-center'>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $bno = 0;
                            foreach ($buys as $buy) {
                                $bno++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= date("d-m-Y", strtotime($buy->buy_date)) ?></td>
                                    <td class='text-center'>
                                        <?php
                                        $session = \config\Services::session();
                                        if ($session->login_id == 38 || $session->login_id == 68 || $session->login_id == 121 || $session->login_id == 14 || $session->login_id == 26 || $session->login_id == 48 || $session->login_id == 55 || $session->login_id == 61 || $session->login_id == 83 || $session->login_id == 70 || $session->login_id == 71 || $session->login_id == 84 || $session->login_id == 85 || $session->login_id == 96 || $session->login_id == 97 || $session->login_id == 106 || $session->login_id == 112 || $session->login_id == 113 || $session->login_id == 114 || $session->login_id == 115) : ?>
                                            <a href="<?= base_url('products/buy/manage') . '/' . $buy->buy_id ?>"><?= $buy->buy_number ?></a>
                                        <?php else : ?>
                                            <a href="<?= base_url('products/buys/manage') . '/' . $buy->buy_id ?>"><?= $buy->buy_number ?></a>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <?= $buy->contact_name ?>
                                    </td>
                                    <td class='text-center'><?= $buy->warehouse_name ?></td>
                                    <td class='text-center'>+ <?= $buy->buy_quantity ?> <?= $product->unit ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Penjualan</h5>
            </div>
            <div class="card-body">
                <?php
                $sales = $db->table('product_stocks');
                $sales->select([
                    'product_stocks.inden_warehouse_id',
                    'warehouses.name as warehouse_name',
                    'sales.number as sale_number',
                    'sale_items.sale_id',
                    'product_stocks.sale_item_id',
                    'contacts.name as contact_name',
                    'sale_items.quantity as sale_quantity',
                    'sales.transaction_date as sale_date',
                ]);
                $sales->join('sale_items', 'product_stocks.sale_item_id = sale_items.id', 'left');
                $sales->join('sales', 'sale_items.sale_id = sales.id', 'left');
                $sales->join('contacts', 'sales.contact_id = contacts.id', 'left');
                $sales->join('warehouses', 'product_stocks.warehouse_id = warehouses.id', 'left');
                $sales->where('sale_items.product_id', $product->id);
                $sales->where('sale_item_id !=', NULL);
                $sales->orderBy('sales.transaction_date', 'desc');
                $sales = $sales->get();
                $sales = $sales->getResultObject();

                ?>
                <div class="table-responsive">
                    <table class="table table-md" id="datatables-default1">
                        <thead>
                            <tr>
                                <th class='text-center'>Tanggal Transaksi</th>
                                <th class='text-center'>Nomer Transaksi</th>
                                <th class='text-center'>Konsumen</th>
                                <th class='text-center'>Lokasi</th>
                                <th class='text-center'>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 0;
                            foreach ($sales as $sale) {

                                $inden = $db->table('product_stocks');
                                $inden->select([
                                    'warehouses.name as warehouse_names',
                                ]);
                                $inden->join('warehouses', 'product_stocks.inden_warehouse_id = warehouses.id', 'left');
                                $inden->where('product_id', $product->id);
                                $inden->where('sale_item_id', $sale->sale_item_id);
                                $inden = $inden->get();
                                $inden = $inden->getFirstRow();

                                $sno++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= date("d-m-Y", strtotime($sale->sale_date)) ?></td>
                                    <td class='text-center'><a href="<?= base_url('sales/' . $sale->sale_id . '/manage') ?>"><?= $sale->sale_number ?></a></td>

                                    <td class="text-center">
                                        <?= $sale->contact_name ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php
                                        if ($sale->inden_warehouse_id != NULL || $sale->inden_warehouse_id != 0) {
                                            echo $sale->warehouse_name . ' ' . $inden->warehouse_names;
                                        } else {
                                            echo $sale->warehouse_name;
                                        }

                                        ?>
                                    </td>
                                    <td class='text-center'>- <?= $sale->sale_quantity ?> <?= $product->unit ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Retur Ke AIO</h5>
            </div>
            <div class="card-body">
                <?php
                $returs = $db->table("return_item");
                $returs->select("return_sales.id as retur_id");
                $returs->select("return_sales.date as retur_date");
                $returs->select("return_sales.number as retur_number");
                $returs->select("return_item.quantity as retur_quantity");
                $returs->select("warehouses.name as warehouse_name");
                $returs->select("administrators.name as admin_name");
                $returs->join("return_sales", "return_item.retur_id = return_sales.id", 'left');
                $returs->join("administrators", "return_sales.admin_id = administrators.id", 'left');
                $returs->join("warehouses", 'return_item.warehouse_id = warehouses.id', 'left');
                $returs->where("return_item.product_id", $product->id);
                $returs->orderBy("return_sales.date", "desc");
                $returs = $returs->get();
                $returs = $returs->getResultObject();
                ?>
                <div class="table-responsive">
                    <table class="table table-md" id="datatables-default1">
                        <thead>
                            <tr>
                                <th class='text-center'>Tanggal Retur</th>
                                <th class='text-center'>Nomer Retur</th>
                                <th class='text-center'>Nama Admin</th>
                                <th class='text-center'>Lokasi</th>
                                <th class='text-center'>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sno = 0;
                            foreach ($returs as $retur) {
                                $sno++;
                            ?>
                                <tr>
                                    <td class='text-center'><?= date("d-m-Y", strtotime($retur->retur_date)) ?></td>
                                    <td class='text-center'><a href="<?= base_url('sales/sale/retur/manage') . '/' . $retur->retur_id ?>"><?= $retur->retur_number ?></a></td>
                                    <td class="text-center">
                                        <?= $retur->admin_name ?>
                                    </td>
                                    <td class='text-center'><?= $retur->warehouse_name ?></td>
                                    <td class='text-center'>- <?= $retur->retur_quantity ?> <?= $product->unit ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Transfer</h5>
            </div>
            <div class="card-body">
                <?php
                $transfers = $db->table('warehouse_transfers');
                $transfers->select([
                    'products.sku_number',
                    'warehouse_transfers.id',
                    'products.name as product_name',
                    'administrators.name as admin_name',
                    'warehouse_transfers.date as transfer_date',
                    'warehouse_transfers.number as transfer_number',
                    'warehouse_transfers_items.quantity as item_qty',
                ]);
                $transfers->join('administrators', 'warehouse_transfers.admin_id = administrators.id', 'left');
                $transfers->join('warehouse_transfers_items', 'warehouse_transfers.id = warehouse_transfers_items.warehouse_transfers_id', 'left');
                $transfers->join('products', 'warehouse_transfers_items.product_id = products.id', 'left');
                $transfers->where('warehouse_transfers_items.product_id', $product->id);
                $transfers->orderBy('warehouse_transfers.id', 'desc');
                $transfers->orderBy('warehouse_transfers.date', 'desc');
                $transfers = $transfers->get();
                $transfers = $transfers->getResultObject();
                ?>
                <div class="table-responsive">
                    <table class="table table-md table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal Transfer</th>
                                <th class="text-center">Nomer Dokumen</th>
                                <th class="text-center">Nama Admin</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transfers as $transfer) { ?>
                                <tr>
                                    <td><?= $transfer->transfer_date ?></td>
                                    <td><a href="<?= base_url('products/transfers/manage') . '/' . $transfer->id ?>"><?= $transfer->transfer_number ?></a></td>
                                    <td><?= $transfer->admin_name ?></td>
                                    <td><?= $transfer->product_name ?></td>
                                    <td><?= $transfer->item_qty ?> Unit</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Data Retur Ke Pemasok</h5>
            </div>
            <div class="card-body">
                <?php
                $principals = $db->table('product_returns');
                $principals->select([
                    "product_returns.id as return_id",
                    "product_returns.number",
                    "product_returns.date",
                    "warehouses.name as warehouse_name",
                    "administrators.name as admin_name",
                    "product_returns_item.quantity"
                ]);
                $principals->join('product_returns_item', 'product_returns.id = product_returns_item.return_pemasok_id', 'left');
                $principals->join('warehouses', 'product_returns.warehouse_id = warehouses.id', 'left');
                $principals->join('administrators', 'product_returns.admin_id = administrators.id', 'left');
                $principals->where('product_returns_item.product_id', $product->id);
                $principals->orderBy('product_returns.date', 'desc');
                $principals = $principals->get();
                $principals = $principals->getResultObject();
                ?>
                <div class="table-responsive">
                    <table class="table table-md table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal Retur</th>
                                <th class="text-center">Nomor Retur</th>
                                <th class="text-center">Nama Admin</th>
                                <th class="text-center">Lokasi</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($principals as $principal) : ?>
                                <tr>
                                    <td class="text-center"><?= $principal->date ?></td>
                                    <td class="text-center"><a href="<?= base_url('return/pemasok/manage/' . $principal->return_id) ?>"><?= $principal->number ?></a></td>
                                    <td class="text-center"><?= $principal->admin_name ?></td>
                                    <td class="text-center"><?= $principal->warehouse_name ?></td>
                                    <td class="text-center">- <?= $principal->quantity ?> Unit</td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('page_script') ?>
<script type="text/javascript">
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }

    function simulation() {
        formula = <?= $product->price_id ?>;
        price = <?= $product->price ?>;

        $.ajax({
            url: "<?= base_url('products/prices/ajax/simulation') ?>",
            type: "POST",
            data: {
                formula: formula,
                price: price
            },
            success: function(response) {
                response = JSON.parse(response)

                for (p = 2; p <= 10; p++) {
                    $("#priceShowContainer" + p).html("Rp. " + addCommas(response[p]))
                }
            },
        })
    }

    $(document).ready(function() {
        simulation()
    })
</script>

<style type='text/css'>
    .dataTables {
        height: 20px;
    }

    .dataTables_filter {
        display: none;
    }
</style>

<script>
    function loadSubCategory() {
        var selectedOption = document.getElementById("category").value;
        var categoryId = selectedOption.split('|')[0];

        $.ajax({
            url: '<?= base_url("products/ajaxGetCategories") ?>',
            type: 'POST',
            data: {
                category_id: categoryId
            },
            dataType: 'json',
            success: function(response) {
                console.log('Received Response:', response);

                var subSelect = document.getElementById("subKategoriSelect");
                subSelect.innerHTML = "";
                var subCategories = response[categoryId];

                var defaultOption = document.createElement("option");
                defaultOption.value = "Pilih Sub Kategori";
                defaultOption.textContent = "Pilih Sub Kategori";
                subSelect.appendChild(defaultOption);

                for (var i = 0; i < subCategories.length; i++) {
                    console.log('Sub Category:', subCategories[i]);
                    var subCategory = subCategories[i];

                    var option = document.createElement("option");
                    option.value = subCategory.code;
                    option.textContent = subCategory.name;
                    subSelect.appendChild(option);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
</script>

<style type='text/css'>
    .dataTables {
        height: 20px;
    }

    .dataTables_filter {
        display: none;
    }
</style>
<?= $this->endSection() ?>