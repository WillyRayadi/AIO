<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Pengaturan Akun
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>
<li class="breadcrumb-item"><a href="<?= base_url('/dashboard'); ?>">Home</a></li>
<li class="breadcrumb-item active">Pengaturan Akun</li>
<?= $this->endSection() ?>

<?= $this->section("page_content") ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Pengaturan Akun [<?= config("App")->roles[config("Login")->loginRole] ?>]</h5>
            </div>
            <?php if (config('Login')->loginRole == 4 || config('Login')->loginRole == 5): ?>
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#MyProfile" data-toggle="tab">My Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#MyTeam" data-toggle="tab">My Team</a></li>
                </ul>
            </div>
            <?php endif; ?>
            <div class="card-body">
               <?php if(config('Login')->loginRole == 4 || config('Login')->loginRole == 5){ ?>
                <div class="tab-content">
                    <div class="active tab-pane" id="MyProfile">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Nama</b>
                                        <br>
                                        <?= config("Login")->loginName ?>
                                        <br><br>
                                        <b>Username</b>
                                        <br>
                                        <?= config("Login")->loginUsername ?>
                                        <br><br>
                                        <b>E-mail</b>
                                        <br>
                                        <?= config("Login")->loginEmail ?>
                                        <br><br>
                                        <b>Telp / Hp</b>
                                        <br>
                                        <?= config("Login")->loginPhone ?>
                                        <br><br>
                                        <b>Alamat</b>
                                        <br>
                                        <?= config("Login")->loginAddress ?>

                                    </div>
                                    <div class="col-md-6">
                                        <b>Reset Password</b>
                                        <hr>
                                        <form method="post" action="<?= base_url('settings/save') ?>">
                                            <div class="form-group">
                                                <label>Password Saat Ini</label>
                                                <input type='password' class='form-control' name='recent' placeholder="Password Saat Ini" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Password Baru</label>
                                                <input type='password' class='form-control' name='new' placeholder="Password Baru" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Konfirmasi Password Baru</label>
                                                <input type='password' class='form-control' name='confirm' placeholder="Konfirmasi Password Baru" required>
                                            </div>
                                            <div class="form-group">
                                                <button type='submit' class='btn btn-success'>
                                                    <i class='fa fa-save'></i>
                                                    Reset Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="MyTeam">
                        <div class="card">
                            <div class="card-header">
                                <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#add">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered" id="datatables-default7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; foreach($team as $key): $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key->name ?></td>
                                                <td>
                                                    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#delete-<?= $key->id ?>"> 
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form action="<?= base_url("settings/add_team") ?>" method="POST">
                          <input type="hidden" name="<?= csrf_token(); ?>" value="<?= csrf_hash(); ?>">
                          <input type="hidden" name="leader_id" value="<?= session()->login_id ?>">
                          <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Add Team Data</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label for="name">Pilih Sales</label>
                                    <select name='team_member_id[]' class="select2bs4" id="tagSelect" multiple="multiple">
                                        <?php if(config('Login')->loginRole == 4): ?> 
                                             <?php foreach($team_retail as $retail): ?>
                                                <option value="<?= $retail->id ?>"><?= $retail->name ?></option>
                                             <?php endforeach; ?>                                       
                                        <?php endif ?>
                                        <?php if(config('Login')->loginRole == 5): ?>
                                             <?php foreach($team_grosir as $grosir): ?>
                                                <option value="<?= $grosir->id ?>"><?= $grosir->name ?></option>
                                             <?php endforeach; ?>                                       
                                        <?php endif ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Konfirmasi</button>
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                        <?php foreach ($team as $key => $value): ?>
                          <div class="modal fade" id="delete-<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Hapus Data?</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-footer">
                                  <form action="<?= base_url("settings/team/".$value->id."/delete") ?>">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i> Konfirmasi</button>
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Batalkan</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endforeach ?>
                    </div>
                </div>
               <?php }else{ ?>
                <div class="row">
                    <div class="col-md-6">
                        <b>Nama</b>
                        <br>
                        <?= config("Login")->loginName ?>
                        <br><br>
                        <b>Username</b>
                        <br>
                        <?= config("Login")->loginUsername ?>
                        <br><br>
                        <b>E-mail</b>
                        <br>
                        <?= config("Login")->loginEmail ?>
                        <br><br>
                        <b>Telp / Hp</b>
                        <br>
                        <?= config("Login")->loginPhone ?>
                        <br><br>
                        <b>Alamat</b>
                        <br>
                        <?= config("Login")->loginAddress ?>
                    </div>
                    <div class="col-md-6">
                        <b>Reset Password</b>
                        <hr>
                        <form method="post" action="<?= base_url('settings/save') ?>">
                            <div class="form-group">
                                <label>Password Saat Ini</label>
                                <input type='password' class='form-control' name='recent' placeholder="Password Saat Ini" required>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type='password' class='form-control' name='new' placeholder="Password Baru" required>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type='password' class='form-control' name='confirm' placeholder="Konfirmasi Password Baru" required>
                            </div>
                            <div class="form-group">
                                <button type='submit' class='btn btn-success'>
                                    <i class='fa fa-save'></i>
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
               <?php } ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>