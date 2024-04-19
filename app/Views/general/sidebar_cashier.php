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
    <a href="<?= base_url('data/products') ?>" class="nav-link">
        <i class="nav-icon fas fa-th"></i>
        <p>Data Produk</p>
    </a>
</li>

<li class="nav-item">
    <a href="<?= base_url('cashier/data/contacts') ?>" class="nav-link">
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
            Point User
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('cashier/user/point') ?>" class="nav-link">
                <p>
                    <i class="far fa-circle nav-icon"></i>
                    Point Member
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('cashier/user/redeems') ?>" class="nav-link">
                <p>
                    <i class="far fa-circle nav-icon"></i>
                    Redeem Point
                </p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fas fa-tag"></i>
        <p>
            Penjualan
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="" class="nav-link">
                <p>
                    <i class="far fa-circle nav-icon"></i>
                    Buat Penjualan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('cashier/sales') ?>" class="nav-link">
                <p>
                    <i class="far fa-circle nav-icon"></i>
                    Data Penjualan
                </p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="<?= base_url('deliveries') ?>" class="nav-link">
        <i class="nav-icon fas fa-truck"></i>
        <p>
            Pengiriman
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
    <ul class="nav nav-treeview"
</li>
