<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | <?= config("App")->name ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1">
                    <?php
                    $loginCompanyName = explode(" ", config("Company")->name);
                    ?>
                    <b><?= $loginCompanyName[0] ?></b> <?= $loginCompanyName[1] ?>
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                    } else {
                        echo "Masuk untuk mengelola aplikasi";
                    }
                    ?>
                </p>
                <p id="IPContainer"></p>

                <form action="<?= base_url('process_login') ?>" method="post">
                    <input type='hidden' name='ip' id='myIP'>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" required name='email' required placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" required name='password' id='inputPassword' placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" onclick="myFunction()">
                        <label class="form-check-label" for="exampleCheck1">Show Password</label>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('public/adminlte') ?>/dist/js/adminlte.min.js"></script>

    <!-- Axios -->
    <script type="text/javascript" src="<?= base_url('public/axios.min.js') ?>"></script>

    <script type="text/javascript">
        async function getIpClient() {
            try {
                const response = await axios.get('https://api.ipify.org?format=json');
                // console.log(response);
                $("#IPContainer").html("IP Kamu : "+ response.data.ip)
                $("#myIP").val(response.data.ip)
            }catch (error) {
                // console.error(error);
            }
        }
        getIpClient();
    </script>
    
    <script>
        function myFunction() {
            var x = document.getElementById("inputPassword");
          if (x.type === "password") {
            x.type = "text";
          } else {
            x.type = "password";
          }
        } 
    </script>
</body>

</html>