<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-header">Data</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-th-large"></i>
        <p>
            Barang
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('products/available') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Persediaan Tersedia</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products/warehouse') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Berdasarkan Gudang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products/stocks') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Penyesuaian Persediaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products/transfers') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transfer Barang</p>
            </a>
        </li>
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
        <li class="nav-item">
            <a href="<?= base_url('products/returns') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Return</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-header">Transaksi</li>

<?php
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if($roles->sales_order_lihat != NULL): ?>
<li class="nav-item">
    <a href="<?= base_url('sales') ?>" class="nav-link">
        <i class="nav-icon far fa fa-dolly-flatbed"></i>
        <p>
            Penjualan (SO)
        </p>
    </a>
</li>
<?php endif ?>

<?php
$this->db = \Config\Database::connect();
$session = \Config\Services::session(); 
$admins = $this->db->table('administrators')->where('id',$session->login_id)->get()->getFirstRow();
$roles =  $this->db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if($roles->delivery_order_lihat != NULL): ?>

<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-truck"></i>
        <p>
            Pengiriman (DO)
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('warehouse/delivery_orders') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Buat Pengiriman</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('warehouse/sales'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Pengiriman
                </p>
            </a>
        </li>
    
    </ul>
</li>

<?php endif ?>

<li class="nav-header">Akun</li>
<li class='nav-item'>
    <a href="<?= base_url('settings') ?>" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <p>
            Pengaturan Akun
        </p>
    </a>
</li>