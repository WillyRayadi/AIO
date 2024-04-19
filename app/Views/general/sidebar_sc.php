<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-exchange-alt"></i>
        <p>
            Data Lainnya
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('returns/data'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Retur
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('warehouse/transfers') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Transfers
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
