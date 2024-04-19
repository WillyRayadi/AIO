<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengiriman (DO)
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengiriman (DO)</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h5 class="card-title">SO Perlu Persetujuan</h5>
            </div>
            <div class="card-body table-responsive" id="datatables-default4">
                <?php
                $itemNeeds = $db->table("sales");
                $itemNeeds->select('sales.id as sale_id');
                $itemNeeds->select('sales.number as sale_number');
                $itemNeeds->select('sales.admin_id as sale_admin');
                $itemNeeds->select('sales.payment_id as sale_payments');
                $itemNeeds->select('sales.promo_id as sale_promo');
                $itemNeeds->select('sales.location_id as sale_location');
                $itemNeeds->select('sales.warehouse_id as sale_warehouse');
                $itemNeeds->select('sales.transaction_date as sale_transaction');
                $itemNeeds->select('sales.expired_date as sale_expired');
                $itemNeeds->select('sales.tags as sale_tags');
                $itemNeeds->select('sales.status as status');
                $itemNeeds->select("administrators.name as admin_name");
                $itemNeeds->select("contacts.name as contact_name");
                $itemNeeds->select("sale_items.price_level as item_price_level");
                $itemNeeds->select("sale_items.price as item_price");
                $itemNeeds->select("sale_items.need_approve as sale_need_approved");
                $itemNeeds->select("products.name as product_name");
                $itemNeeds->join("administrators","sales.admin_id=administrators.id","left");
                $itemNeeds->join('sale_items','sales.id=sale_items.sale_id','left');
                $itemNeeds->join("products","sale_items.product_id=products.id","left");
                $itemNeeds->join('contacts','sales.contact_id=contacts.id','left');
                $itemNeeds->where("sales.status",1);    
                $itemNeeds->where("sales.number !=", NULL);
                $itemNeeds->where("sales.id !=", NULL);
                $itemNeeds->where("sales.contact_id !=", NULL);
                $itemNeeds->where("sale_items.need_approve !=", NULL);
                $itemNeeds->orderBy("sales.transaction_date","desc");
                $itemNeeds = $itemNeeds->get();
                $itemNeeds = $itemNeeds->getResultObject();
                ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class='text-center'>Nomer SO</th>
                            <!-- <th class='text-center'>Nama Sales</th> -->
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Nama Produk</th>
                            <th class='text-center'>Butuh Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $itemNo = 0;  ?>
                        <?php foreach(  $itemNeeds as $item) : ?>
                        <?php $itemNo++; ?>
                        <tr>
                            <td class='text-center'><?= $item->sale_number?></td>
                            <!-- <td class='text-center'><?= $item->admin_name?></td> -->
                            <td class='text-center'><?= $item->contact_name ?></td>
                            <td class='text-center'><?= $item->product_name ?> <b>Harga (<?= $item->item_price_level ?>)</b></td>
                            <td class="text-center">
                           <?php
                               if ($item->sale_need_approved == NULL || $item->sale_need_approved == 0) {
                                   # code...
                               } else {
                                   echo config("App")->needApprovers[$item->sale_need_approved];
                               }
                               
                            ?>
                            </td> 
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>     
</div>

<div class="row">
<div class="col-md-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="card-title">Dikirim Dan Dikirim Sebagian</h5>
            </div>
            <div class="card-body table-responsive">
                <?php
                $itemNeeds = $db->table("sales");
                $itemNeeds->select('sales.id as sale_id');
                $itemNeeds->select('sales.number as sale_number');
                $itemNeeds->select('sales.admin_id as sale_admin');
                $itemNeeds->select('sales.contact_id as sale_contact');
                $itemNeeds->select('sales.payment_id as sale_payments');
                $itemNeeds->select('sales.promo_id as sale_promo');
                $itemNeeds->select('sales.location_id as location_id');
                $itemNeeds->select('sales.warehouse_id as sale_warehouse');
                $itemNeeds->select('sales.transaction_date as sale_transaction');
                $itemNeeds->select('sales.expired_date as sale_expired');
                $itemNeeds->select('sales.tags as sale_tags');
                $itemNeeds->select('sales.status as status');
                $itemNeeds->select('contacts.name as contact_name');
                $itemNeeds->select('locations.name as location_name');
                $itemNeeds->join('contacts','sales.contact_id=contacts.id','left');
                $itemNeeds->join('locations','sales.location_id=locations.id','left');
                $itemNeeds->where("sales.status >=",4); 
                $itemNeeds->where("sales.status <=",5);
                $itemNeeds->where("sales.number !=", NULL);
                $itemNeeds->where("sales.number !=", NULL);
                $itemNeeds->where("sales.id !=", NULL);
                $itemNeeds->where("sales.contact_id !=", NULL);
                $itemNeeds->orderBy("sales.transaction_date","desc");
                $itemNeeds = $itemNeeds->get();
                $itemNeeds = $itemNeeds->getResultObject();
                ?>
                <table class="table table-striped table-bordered" id="datatables-default5">
                    <thead>
                        <tr>
                            <th class='text-center'>Nomer SO</th>
                            <th class='text-center'>Pelanggan</th>
                            <th class='text-center'>Area Pengiriman</th>
                            <th class='text-center'>Tanggal Transaksi</th>
                            <th class='text-center'>Status Pengiriman</th>
                            <th class='text-center'>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $itemNo = 0;  ?>
                        <?php foreach($itemNeeds as $item) : ?>
                        <?php $itemNo++; ?>
                        <tr>
                            <td class='text-center'><?= $item->sale_number?></td>
                            <td class='text-center'><?= $item->contact_name?></td>
                            <td class='text-center'><?= $item->location_name ?></td>
                            <td class='text-center'><?= config("App")->orderStatuses[$item->status] ?></td>
                            <td class='text-center'><?= $item->sale_transaction?></td>
                            <td class='text-center'>
                                <a href="<?= base_url('warehouse/sales/'.$item->sale_id.'/manage') ?>" class='btn btn-success btn-sm' title="Kelola Pesanan Penjualan">
                                    <i class='fa fa-cog'></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>

    <script>
        $(document).ready(function() {
            $('#datatables-default5').DataTable( {
                dom: 'Bfrtip',
                "bInfo": false,
                "bPaginate": false,
            } );
        } );
    </script>

<br>

<?= $this->endSection() ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>