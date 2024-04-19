<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

<?php 
$session = \Config\Services::session(); 
if ($session->login_id != 88 ) : ?>
    <li class="nav-item">
        <a href="<?= base_url('reports'); ?>" class="nav-link">
            <i class="nav-icon fa fa-file-alt"></i>
            <p>
                Laporan
            </p>
        </a>
    </li>
<?php endif ?>

<?php 
    $session = \Config\Services::session(); 
    if ($session->login_id != 38 && $session->login_id != 83): ?>
    <li class="nav-item">
        <a href="<?= base_url('custom/insentif')?>" class="nav-link">
            <i class="nav-icon fa fa-dollar-sign"></i>
            <p>
                Insentif Sales
            </p>
        </a>
    </li>
<?php endif ?>

<li class="nav-header">Stok</li>

<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>
            Persediaan Barang
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="<?= base_url('stok_opname') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Stok Opname</p>
                </a>
            </li>

        <!--<li class="nav-item">-->
        <!--    <a href="<?= base_url('products/available') ?>" class="nav-link">-->
        <!--        <i class="far fa-circle nav-icon"></i>-->
        <!--        <p>Persediaan Tersedia</p>-->
        <!--    </a>-->
        <!--</li>-->
        <!--<li class="nav-item">-->
        <!--    <a href="<?= base_url('products/warehouse') ?>" class="nav-link">-->
        <!--        <i class="far fa-circle nav-icon"></i>-->
        <!--        <p>Berdasarkan Gudang</p>-->
        <!--    </a>-->
        <!--</li>-->
        <!--<li class="nav-item">-->
        <!--    <a href="<?= base_url('products/stocks') ?>" class="nav-link">-->
        <!--        <i class="far fa-circle nav-icon"></i>-->
        <!--        <p>Penyesuaian Persediaan</p>-->
        <!--    </a>-->

        <!--</li>-->
        <!--<li class="nav-item">-->
        <!--    <a href="<?= base_url('products/transfers') ?>" class="nav-link">-->
        <!--        <i class="far fa-circle nav-icon"></i>-->
        <!--        <p>Transfer Barang</p>-->
        <!--    </a>-->
        <!--</li>-->

        <li class="nav-item">
            <a href="<?= base_url('products/displays') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Display</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('products/repairs') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Perbaikan (Service)</p>
            </a>
        </li>
        
        <?php 
        $this->db = \Config\Database::connect();
        $session = \Config\Services::session(); 
        $admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
        $roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

        if ($roles->products_lihat != NULL) : ?>
        
        <li class="nav-item">
            <a href="<?= base_url('products') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Barang</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('products/capacity') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kapasitas Barang</p>
            </a>
        </li>

        <?php endif ?>
        
        <li class="nav-item">
            <a href="<?= base_url('products/prices') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Rumus Harga</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Transaksi</li>

<!-- Retur -->

<?php 
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->retur_product_lihat != NULL): ?>

    <li class="nav-item">

        <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon fa fa-exchange-alt"></i>
            <p>
                Retur Product
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>

        <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="<?= base_url('products/returns') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Retur Sales</p>
                </a>
            </li>  

            <li class="nav-item">
                <a href="<?= base_url('return/pemasok') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Retur Pemasok
                    </p>
                </a>
            </li>

        </ul>
    </li>

<?php endif ?>

<!-- Transfer Gudang -->
<?php
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->transfer_warehouse_lihat != NULL): ?>

    <li class="nav-item">
        <a href="<?= base_url('products/transfers') ?>" class="nav-link">
            <i class="nav-icon fas fa-exchange-alt"></i>
            <p>
                Transfer Barang 
            </p>
        </a>
    </li>    
<?php endif ?>

<!-- Penjualan (SO) -->

<?php 
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->sales_order_lihat != NULL): ?>
    <li class="nav-item">
    <a href="<?= base_url('sales') ?>" class="nav-link">
        <i class="nav-icon far fa fa-dolly-flatbed"></i>
        <p>
            Penjualan (SO)
        </p>
    </a>
</li>
<?php endif ?>

<!-- Delivery Order -->

<?php 
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->delivery_order_lihat != NULL): ?>
    <li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon far fa fa-truck"></i>
        <p>
            Pengiriman (DO)
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        
        <li class="nav-item">
            <a href="<?= base_url('sales_warehouse'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Pengiriman
                </p>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('histori/pengiriman') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Histori Pengiriman
                </p>
            </a>
        </li>
    </ul>
</li>
<?php endif ?>

<!-- Purchase order -->

    <?php 
    $session = \Config\Services::session(); 
    if ($session->login_id == 70 || $session->login_id == 61 || $session->login_id == 48): ?>
        <li class="nav-item">
            <a href="<?= base_url('product/purchase/order')?>" class="nav-link">
                <i class="nav-icon far fa fa-shopping-bag"></i>
                <p>
                    Purchase Orders
                </p>
            </a>
        </li>
    <?php else: ?>
        <li class="nav-item">
            <a href="<?= base_url('purchases') ?>" class="nav-link">
                <i class="nav-icon far fa fa-shopping-bag"></i>
                <p>
                    Purchases order
                </p>
            </a>
        </li>
    <?php endif ?>

<!-- Purchase Delivery (PD) --> 

<?php 
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->purchase_order_lihat != NULL): ?>
    <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
                Pembelian Barang
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?= base_url('products/buy') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data PD</p>
                </a>
            </li>  

            <li class="nav-item">
                <a href="<?= base_url('perubahan/data') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Data Persetujuan
                    </p>
                </a>
            </li>
        </ul>
    </li>
<?php endif ?> 


<li class="nav-header">Data</li>
<li class="nav-item">
    <a href="<?= base_url('products/inden') ?>" class="nav-link">
        <i class="fa fa-list nav-icon"></i>
        <p>Barang Inden</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('contacts') ?>" class="nav-link">
        <i class="nav-icon fas fa-address-book"></i>
        <p>
            Kontak
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-star"></i>
        <p>
            Point Member
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('user/point') ?>" class="nav-link">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>
                    Point User
                </p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('redeem/points') ?>" class="nav-link">
                <i class="nav-icon far fa-circle nav-icon"></i>
                <p>
                    Redeem Point
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-file"></i>
        <p>
            Daftar Lainnya
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        
        <li class="nav-item">
            <a href="<?= base_url('activity_approval') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Aktifitas Persetujuan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('brands') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Brand</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('products/capacity') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kapasitas</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('warehouses') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gudang</p>
            </a>
        </li>        
        <li class="nav-item">
            <a href="<?= base_url('codes') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Kode Barang
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products/categories') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori Barang</p>
            </a>
        </li>        
        <li class="nav-item">
            <a href="<?= base_url('vehicles') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Kendaraan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('tags') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Tag
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('payment/terms') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Metode Pembayaran
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('promo/types') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Jenis Promo</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('promo') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Promo</p>
            </a>
        </li>

    <?php
    $session = \Config\Services::session();

    if ($session->login_id == 83) :
    ?>

        <li class="nav-item">
            <a href="<?= base_url('products/stokOpname') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Stok Opname (-)</p>
            </a>
        </li>

    <?php endif; ?>

    </ul>
</li>
<li class="nav-header">Akun</li>
<!--<li class="nav-item">-->
<!--    <a href="<?= base_url('account') ?>" class="nav-link">-->
<!--        <i class="nav-icon fa fa-users-cog"></i>-->
<!--        <p>-->
<!--            Pengelolaan Akun-->
<!--        </p>-->
<!--    </a>-->
<!--</li>-->
<li class='nav-item'>
    <a href="<?= base_url('settings') ?>" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <p>
            Pengaturan Akun
        </p>
    </a>
</li>
