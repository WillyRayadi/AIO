<?= $this->extend("general/template") ?>
<?= $this->section("page_title") ?>
Kelola Perubahan Status
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Kelola Perubahan Status</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?> 

<div class="row">
    <div class='col-md-4'>
        <div class='card'>
            <div class="card-body">  
                <h4>Perubahan Status (SO)</h4>    
                <hr>  
                <b>Nomer SO</b>
                <br> 
                <p><?= $datas->sale_number ?></p>

                <b>Nama Sales</b>
                <br>
                <p><?= $datas->admin_name ?></p>

                <b>Nama Pelanggan</b>
                <br>
                <p><?= $datas->contact_name ?></p>

                <b>Alamat Pelanggan</b>
                <br>
                <p><?= $datas->addresses ?></p>

                <b>Alasan Merubah Data</b>
                <br>
                <p><?= $datas->alasan ?></p> 

          </div> 
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">                                                           
            <div class="card-body">
                <h4>  
                   Data Perubahan
                </h4> 
                <hr> 
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                           <th class="text-center">No</th>
                           <th class="text-center">Nama Produk</th>
                           <th class="text-center">Qty Awal</th>
                           <th class="text-center">Perubahan</th>
                           <th class="text-center">Harga Awal</th>
                           <th class="text-center">Perubahan</th>
                           <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                            foreach ($alasan as $alas) {
                            $no++;
                        ?>
                        <tr>
                            <td class="text-center"><?= $no; ?></td>
                            <?php
                            $items = $db->table('sale_items');
                            $items->select(['sale_items.id as sale_id','products.name as product_name','sale_items.quantity','sale_items.price']);
                            $items->where('sale_items.sale_id',$alas->sale_id);
                            $items->where('sale_items.product_id', $alas->product_id);
                            $items->join('products','sale_items.product_id = products.id','left');
                            $items = $items->get();
                            $items = $items->getFirstRow();
                            
                            $products = $db->table('products');
                            $products->select('products.name as product_name');
                            $products->where('products.id', $alas->product_id);
                            $products = $products->get();
                            $products = $products->getFirstRow();
                            ?>
                            <td class="text-center"><?= $products->product_name ?></td>
                            <td class="text-center"><?= $items->quantity ?> unit</td>
                            <td class="text-center">
                                <?php if ($alas->qty_edit == 0): ?>
                                    -
                                <?php else: ?>
                                    <?= $alas->qty_edit ?> unit
                                <?php endif ?>
                            </td>
                            <td class="text-center"><?= number_format($items->price) ?></td>
                            <td class="text-center">
                                <?php if ($alas->harga_edit == 0): ?>
                                    -
                                <?php else: ?>
                                    <?= number_format($alas->harga_edit) ?>
                                <?php endif ?>
                            </td>
                          
                            <?php
                                $sale = $db->table('sales');
                                $sale->where('sales.id',$alas->sale_id);
                                $sale->orderBy('sales.id','desc');
                                $sale = $sale->get();
                                $sale = $sale->getFirstRow();
                            ?>
                            <td class="text-center">
                                <a href="<?=base_url("owner/approve/".$sale->id.'/perubahan') ?>" onclick="return confirm('Yakin Kamu mau menyetujui.?')" class='btn btn-success btn-sm' title="Setujui">
                                    <i class='fa fa-check'></i>
                                </a>
                                    
                                <a href="<?= base_url("owner/unapprove/".$sale->id.'/perubahan') ?>" onclick="return confirm('Yakin kamu mau tidak menyetujui ini.?')" class='btn btn-danger btn-sm' title="Tidak Disetujui">
                                    <i class='fa fa-times'></i>
                                </a>
                            </td>
                        </tr>
                          <?php
                        }
                        ?>
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>
<?= $this->endSection() ?>