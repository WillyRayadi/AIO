<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

<li class="nav-header">Pembelian</li>
<li class="nav-item">
    <a href="<?= base_url('partner/products/buys') ?>" class="nav-link">
        <i class="nav-icon fa fa-shopping-cart"></i>
        <p>
            Pembelian Barang (PD)
        </p>
    </a>
</li>

<li class="nav-header">Penjualan</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-tags"></i>
        <p>
            Penjualan (SO)
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('sales/datas') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Penjualan</p>
            </a>
        </li>
        
        <li class="nav-item">
            <a href="<?= base_url('') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Persetujuan</p>
            </a>
        </li>
        
    </ul>
</li>
 
<li class="nav-item">
    <a href="<?= base_url('deliveries/data') ?>" class="nav-link">
        <i class="fas fa-truck nav-icon"></i>
        <p>Pengiriman (DO)</p>
    </a>
</li>

<li class="nav-header">Akun</li> 
<li class='nav-item'>
    <a href="<?= base_url('settings') ?>" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <p>
            Pengaturan Akun
        </p>
    </a>
</li>
