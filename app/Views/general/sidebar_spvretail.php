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
            <a href="<?= base_url('spv/retail/products') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('spv/retail/price/approval') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Perlu Persetujuan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Penjualan</li>
<li class="nav-item">
    <a href="<?= base_url('spv/retail/sales'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tags"></i>
        <p>
            Penjualan (SO)
        </p>
    </a>
</li>
