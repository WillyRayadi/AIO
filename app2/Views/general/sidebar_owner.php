<li class="nav-item">
    <a href="<?= base_url('dashboard'); ?>" class="nav-link">
        <i class="nav-icon fa fa-tachometer-alt"></i>
        <p>
            Dashboard
        </p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('reports'); ?>" class="nav-link">
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
        <?php
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
        $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

        if ($roles->transfer_warehouse_lihat != NULL) : ?>
            <li class="nav-item">
                <a href="<?= base_url('products/transfers') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Transfer Barang</p>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item">
            <a href="<?= base_url('products/repairs') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Perbaikan (Service)</p>
            </a>
        </li>

        <?php
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
        $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

        if ($roles->retur_product_lihat != NULL) : ?>
            <li class="nav-item">
                <a href="<?= base_url('sales/sale/retur') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Return</p>
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
<li class="nav-header">Penjualan</li>

<?php
$db = \Config\Database::connect();
$session = \Config\Services::session();
$admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
$roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->purchase_order_lihat != NULL) : ?>
    <li class="nav-item">
        <a href="<?= base_url('products/buys') ?>" class="nav-link">
            <i class="nav-icon fa fa-shopping-cart"></i>
            <p>
                Pembelian Barang (PD)
            </p>
        </a>
    </li>
<?php endif ?>

<?php
$db = \Config\Database::connect();
$session = \Config\Services::session();
$admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
$roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->sales_order_lihat != NULL) : ?>
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
                <a href="<?= base_url('sales/sales/add') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Buat Penjualan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('owner/sales'); ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Data Penjualan
                    </p>
                </a>
            </li>
        </ul>
    </li>

<?php endif ?>


<?php
$db = \Config\Database::connect();
$session = \Config\Services::session();
$admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
$roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->agreement_lihat != NULL) : ?>
    <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
            <i class="nav-icon fa fa-check"></i>
            <p>Persetujuan
                <i class="right fas fa-angle-left"></i>
            </p>

        </a>

        <ul class="nav nav-treeview">

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('owner/sales/need_approval'); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Persetujuan Harga
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('owner/perubahan/status'); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Persetujuan Perubahan
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('owner/perubahan/data'); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Perubahan Data PD
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('approve/submission/do'); ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>
                        Pengajuan Print Ulang
                    </p>
                </a>
            </li>
        </ul>
    </li>

<?php endif ?>


<?php
$db = \Config\Database::connect();
$session = \Config\Services::session();
$admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
$roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

if ($roles->delivery_order_lihat != NULL) : ?>
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
                <a href="<?= base_url('owner/delivery_orders') ?>" class="nav-link">
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

<li class="nav-header">Data</li>
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
        <i class="nav-icon fas fa-file"></i>
        <p>
            Daftar Lainnya
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('warehouses') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Gudang</p>
            </a>
        </li>
        <?php
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
        $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

        if ($roles->stokopname_lihat != NULL) : ?>
            <li class="nav-item">
                <a href="<?= base_url('stok_opname') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Stok Opname</p>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item">
            <a href="<?= base_url('codes') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Kode
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('products/categories') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kategori</p>
            </a>
        </li>
        <?php
        $db = \Config\Database::connect();
        $session = \Config\Services::session();
        $admins = $db->table('administrators')->where('id', $session->login_id)->get()->getFirstRow();
        $roles =  $db->table('administrator_role')->where('id', $admins->role)->get()->getFirstRow();

        if ($roles->products_lihat != NULL) : ?>
            <li class="nav-item">
                <a href="<?= base_url('products') ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Data Barang</p>
                </a>
            </li>
        <?php endif ?>

        <li class="nav-item">
            <a href="<?= base_url('vehicles') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Kendaraan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('locations') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Area Pengiriman
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
            <a href="<?= base_url('tags') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Tag
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('owner/addresses'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Alamat IP
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('owner/target'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Target Penjualan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('owner/insentif') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Insentif Karyawan</p>
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

        <li class="nav-item">
            <a href="<?= base_url('brands') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Brand</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('products/stokOpname') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data Stok Opname (-)</p>
            </a>
        </li>

    </ul>
</li>
<li class="nav-header">Akun</li>

<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-user"></i>
        <p>
            User Akun
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="<?= base_url('management/account') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Role Akun</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('account') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Akun User
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('settings') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Lupa Password Akun
                </p>
            </a>
        </li>

    </ul>
</li>