<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('data_supervisor') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Dashboard Pencapaian
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Penjualan</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-tags"></i>
        <p>
            Penjualan (SO)
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">  
        <li class="nav-item">
            <a href="<?= base_url('supervisor/sales/add'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Buat Penjualan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('supervisor/sales'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Penjualan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('supervisor/sales/need_approval'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Butuh Persetujuan
                </p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-header">Data</li>
<li class="nav-item">
    <a href="<?= base_url('products') ?>" class="nav-link">
        <i class="nav-icon fas fa-th-large"></i>
        <p>
            Data Barang
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-file"></i>
        <p>
            Daftar Lainnya
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">   
        <li class="nav-item">
            <a href="<?= base_url('tags') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Tag
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('supervisor/target'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Target Penjualan
                </p>
            </a>
        </li>
    </ul>
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