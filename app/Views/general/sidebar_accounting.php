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
        <a href="<?= base_url('accounting/products/buys'); ?>" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
                Pembelian Barang (PD)
            </p>
        </a>
    </li>
<?php endif ?>

<li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon fa fa-tags"></i>
            <p>
                Penjualan (SO)
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <!-- <li class="nav-item">
                <a href="<?= base_url('sales/sales/add') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Buat Penjualan</p>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="<?= base_url('accounting/sales'); ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Data Penjualan
                    </p>
                </a>
            </li>
        </ul>
    </li>

<?php 
    $session = \Config\Services::session(); 
    if ($session->login_id != 38): ?>
    <li class="nav-item">
        <a href="<?= base_url('custom/insentif')?>" class="nav-link">
            <i class="nav-icon fa fa-dollar-sign"></i>
            <p>
                Insentif Sales
            </p>
        </a>
    </li>

<?php endif ?>

