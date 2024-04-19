<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Edit Akun
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('account') ?>">Akun Pengelola</a></li>
<li class="breadcrumb-item active" aria-current="page">Edit Akun</li>
<?= $this->endSection() ?>

<?= $this->section("page_content"); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="card-body card">
            <nav>
                <?php
                if (isset($_GET['active'])) {
                    if ($_GET['active'] === "password") {
                        $header_tab1 = "";
                        $header_tab2 = "active";
                    } else {
                        $header_tab1 = "active";
                        $header_tab2 = "";
                    }
                } else {
                    $header_tab1 = "active";
                    $header_tab2 = "";
                }
                ?>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link <?= $header_tab1 ?>" data-toggle="pill" href="#nav-profile" type="button" role="tab" aria-selected="true">Profile</button>
                    <button class="nav-link <?= $header_tab2 ?>" data-toggle="pill" href="#nav-password" type="button" role="tab" aria-selected="false">Password</button>
                </div>
            </nav>
            <div class="tab-content mt-4" id="nav-tabContent">
                <?php
                if (isset($_GET['active'])) {
                    if ($_GET['active'] === "profile") {
                        $class_siswa_tab = "tab-pane fade active show";
                    } else {
                        $class_siswa_tab = "tab-pane fade";
                    }
                } else {
                    $class_siswa_tab = "tab-pane fade active show";
                }
                ?>
                <div class="<?= $class_siswa_tab ?>" id="nav-profile" role="tabpanel">
                    <form class="fr-login" action="<?= base_url('account/edit') ?>" method="post">
                        <div class="form-floating form-login">
                            <input type="hidden" name="id" value="<?= $dataAccount->id; ?>">
                            
                          <div class="mb-2 my-3">
                                <label for="floatingInput"> Nama </label>
                                <input type="text" value="<?= (old('name')) ? old('name') : $dataAccount->name ?>" class="form-control shadow-none <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" id="floatingInput" placeholder="Nama" required autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name'); ?>
                                </div>
                            </div>
                          
                            <div class="mb-2 my-3">
                                <label for="floatingInput">Lokasi Cabang</label>
                                <input type="text" value="<?= (old('cabang')) ? old('cabang') : $dataAccount->cabang ?>" class="form-control shadow-none <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="cabang" id="floatingInput" placeholder="Lokasi Cabang Toko" required autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('cabang'); ?>
                                </div>
                            </div>
                          
                            <div class="mb-2 my-3">
                                <label for="floatingInput"> Email </label>
                                <input type="email" value="<?= (old('email')) ? old('email') : $dataAccount->email ?>" class="form-control shadow-none <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="floatingInput" placeholder="Email" required autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                            <div class="mb-2 my-3">
                                <label for="floatingInput"> No. Telepon </label>
                                <input type="text" value="<?= (old('phone')) ? old('phone') : $dataAccount->phone ?>" class="form-control shadow-none <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" name="phone" id="floatingInput" placeholder="No. Telepon" required autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('phone'); ?>
                                </div>
                            </div>
                            <div class="mb-2 my-3">
                                <label for="floatingInput"> Alamat </label>
                                <textarea type="text" value="<?= (old('address')) ? old('address') : $dataAccount->address ?>" class="form-control shadow-none <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" name="address" id="floatingInput" placeholder="alamat" required autocomplete="off"><?= (old('address')) ? old('address') : $dataAccount->address ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('address'); ?>
                                </div>
                            </div>
                            <div class="mb-2 my-3">
                                <label for="floatingInput"> Username </label>
                                <input type="text" value="<?= (old('username')) ? old('username') : $dataAccount->username ?>" class="form-control shadow-none <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="floatingInput" placeholder="username" required autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select name='role' class='form-control'>
                                    <?php
                                    for($r =1; $r <= 10; $r++){
                                        if($r == $dataAccount->role){
                                            $selectedRole = "selected";
                                        }else{
                                            $selectedRole = "";   
                                        }
                                        echo"<option value='".$r."' $selectedRole>".config("App")->roles[$r]."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label>Akses Lokasi</label>
                                <select name='warehouses[]' class="select2bs4" id="tagSelect" multiple="multiple" style="width: 100%;">
                                <?php
                                foreach($warehouses as $warehouse){
                                $warehouseExplode = explode('"',$admins->allow_warehouses.'"');

                                $thisWarehouseSelected = "";
                                foreach($warehouseExplode as $saleTag){
                                    if($warehouse->id == $saleTag){
                                        $thisWarehouseSelected = "selected";
                                    }else{
                                        if($thisWarehouseSelected === "selected"){
                                            $thisWarehouseSelected = "selected";
                                        }else{
                                            $thisWarehouseSelected = '""';
                                        }
                                    }
                                }
                                    echo"<option value='".$warehouse->id."' $thisWarehouseSelected>".$warehouse->name."</option>";
                                    }
                                ?>
                                </select>
                            </div>
                            
                            <div class="mt-2">
                                <label>Status</label>
                                <br>
                                <label>
                                    <input type='radio' name='status' <?php echo $dataAccount->active == 1 ? "checked" : ""; ?> value="1">
                                    Aktif
                                </label>
                                <label class="ml-2">
                                    <input type='radio' name='status' <?php echo $dataAccount->active == 0 ? "checked" : ""; ?> value="0">
                                    Tidak Aktif
                                </label>
                            </div>
                        </div>
                        <div class="mb-2 my-3">
                            <button style="background-color: #198754; color:white;" class="w-100 btn" type="submit">Ubah</button>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_GET['active'])) {
                    if ($_GET['active'] === "password") {
                        $class_kelompok_kelas_tab = "tab-pane fade active show";
                    } else {
                        $class_kelompok_kelas_tab = "tab-pane fade";
                    }
                } else {
                    $class_kelompok_kelas_tab = "tab-pane fade";
                }
                ?>
                <div class="<?= $class_kelompok_kelas_tab ?>" id="nav-password" role="tabpanel">
                    <form class="fr-login" action="<?= base_url('account/reset_password') ?>" method="post">
                        <div class="form-floating form-login">
                            <input type="hidden" name="id" value="<?= $dataAccount->id; ?>">
                            <input type="hidden" name="name" value="<?= $dataAccount->name; ?>">
                            <label for="floatingInput"><i class="fas fa-key"></i> Password</label>
                            <input type="password" class="form-control shadow-none <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="floatingInput" placeholder="Password" value="<?= (old('password')); ?>" autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password'); ?>
                            </div>
                        </div>
                        <div class="form-floating form-login mt-3">
                            <label for="floatingInput"><i class="fas fa-lock"></i> Kofirmasi Password</label>
                            <input type="password" class="form-control shadow-none <?= ($validation->hasError('confirm_password')) ? 'is-invalid' : ''; ?>" name="confirm_password" id="floatingInput" placeholder="Konfirmasi Password" value="<?= (old('confirm_password')); ?>" autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirm_password'); ?>
                            </div>
                        </div>
                        <div class="form-floating form-login mt-3">
                            <button class="w-100 btn" style="background-color: #fd7e14;" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>