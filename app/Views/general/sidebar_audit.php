<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('audit/report_sales'); ?>" class="nav-link">
        <i class="nav-icon fa fa-file-alt"></i>
        <p>
            Laporan
        </p>
    </a>
</li>
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
            <a href="<?= base_url('audit/products_all') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products_available') ?>" class="nav-link">
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
            <a href="<?= base_url('products_transfers') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i> 
                <p>Transfer Barang</p>  
            </a> 
        </li> 
    </ul>
</li>

<li class="nav-header">Penjualan</li>

<li class="nav-item">
    <a href="<?= base_url('audit/product/buys') ?>" class="nav-link">
        <i class="nav-icon fa fa-shopping-cart"></i>
        <p>
            Pembelian Barang (PD)
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="<?= base_url('audit/sales'); ?>" class="nav-link">
        <i class="fas fa-tag nav-icon"></i>
        <p>
            Penjualan (SO)
        </p>
    </a>
</li>

<li class="nav-item"> 
    <a href="<?= base_url('audit/sales_warehouse'); ?>" class="nav-link">
        <i class="fas fa-truck nav-icon"></i>
        <p>
            Pengiriman (DO)
        </p>
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
