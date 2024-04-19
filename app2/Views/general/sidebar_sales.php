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
            <a href="<?= base_url('/dashboard') ?>" class="nav-link">
                <i class="nav-icon far fa-circle"></i>
                <p>Dashboard</p>
            </a>
       </li>
       <li class="nav-item">
           <a href="<?= base_url('/data_dashboard') ?>" class="nav-link">
               <i class="far fa-circle nav-icon"></i>
               <p>Data Pencapaian</p>
           </a>
       </li>
   </ul>
</li>

<li class="nav-header">Data</li>
<li class="nav-item">
    <a href="<?= base_url('contacts') ?>" class="nav-link">
        <i class="nav-icon fas fa-address-book"></i>
        <p>
            Kontak
        </p>
    </a>
</li>


<?php if (config("Login")->loginRole == 2): ?>
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
            <a href="<?= base_url('sales/sales/add') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Buat Penjualan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('sales/sales'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Penjualan
                </p>
            </a>
        </li>        
        
        <li class="nav-item">
            <a href="<?= base_url('sales/perubahan_status') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Perubahan Status SO
                </p>
            </a>
        </li>
        
    </ul>
</li>
<?php endif ?>

<?php if (config("Login")->loginRole == 3): ?>
<li class="nav-header">Penjualan</li>
<li class="nav-item">
    <a href="javascript:void(0)" class="nav-link">
        <i class="nav-icon fa fa-tags"></i>
        <p>
            Penjualan Grosir (SO)
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
            <a href="<?= base_url('sales/sales/grosir'); ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Data Penjualan
                </p>
            </a>
        </li>       
        
        <li class="nav-item">
            <a href="<?= base_url('sales/perubahan_status') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Perubahan Status SO
                </p>
            </a>
        </li>
        
    </ul>
</li>
<?php endif ?>

<?php if (config("Login")->loginRole == 3): ?>
<li class='nav-item'>
    <a href="<?= base_url('sales/delivery_orders') ?>" class="nav-link">
        <i class="nav-icon fa fa-truck"></i>
        <p>
            Pengiriman (DO)
        </p>
    </a>
</li>
<?php endif ?>

<li class="nav-item">
    <a class="nav-link" href="<?= base_url('sales/sale/retur')?>">
        <i class="nav-icon fa fa-undo"></i>
        <p>
            Return Barang
        </p>
    </a>
</li>

<li class="nav-item">
    <a href="<?= base_url('sales/transfers') ?>" class="nav-link">
        <i class="nav-icon fas fa-exchange-alt"></i>
        <p>
            Transfer Barang
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