<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Tambah Akun
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('account') ?>">Akun Pengelola</a></li>
<li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
<?= $this->endSection() ?>

<?= $this->section("page_content"); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Akun</h3>
                </div>
                <form method="POST" action="<?= base_url('account/add'); ?>">
                    <div class="card-body">
                        
                      <div class="form-group">
                            <label for="name"> Nama </label>
                            <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" id="name" placeholder="Enter Nama ..." value="<?= (old('name')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('name'); ?>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="cabang">Lokasi Cabang</label>
                            <input type="text" class="form-control <?= ($validation->hasError('cabang')) ? 'is-invalid' : ''; ?>" name="cabang" id="cabang" placholder="Lokasi Cabang Toko" value="<?= (old('cabang')); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('cabang'); ?>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="phone"> No. Telepon </label>
                            <input type="text" class="form-control <?= ($validation->hasError('phone')) ? 'is-invalid' : ''; ?>" name="phone" id="phone" placeholder="Enter No. Telepon ..." value="<?= (old('phone')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('phone'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email"> Email</label>
                            <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Enter Email ..." value="<?= (old('email')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address"> Alamat</label>
                            <textarea type="text" class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" name="address" id="address" placeholder="Enter Alamat ..." value="<?= (old('address')); ?>" required autocomplete="off"><?= (old('address')); ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('address'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username"> Username </label>
                            <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Enter Username ..." value="<?= (old('username')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"> Password</label>
                            <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Enter Password ..." value="<?= (old('password')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_password"> Konfirmasi Password</label>
                            <input type="password" class="form-control <?= ($validation->hasError('confirm_password')) ? 'is-invalid' : ''; ?>" name="confirm_password" id="konfirmasi_password" placeholder="Enter Konfirmasi Password ..." value="<?= (old('confirm_password')); ?>" required autocomplete="off">
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirm_password'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name='role' class='form-control'>
                                <?php
                                for($r =1; $r <= count(config("App"->roles)) -1; $r++){
                                    echo"<option value='".$r."'>".config("App")->roles[$r]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="<?= base_url('account'); ?>">
                            <button type="button" class="btn btn-danger float-left">Kembali</button>
                        </a>
                        <button type="submit" class="btn btn-primary float-right">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("page_script") ?>

<?= $this->endSection() ?>