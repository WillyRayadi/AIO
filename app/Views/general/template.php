<!DOCTYPE html> 
<html lang="en"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= config("App")->name ?> | <?= config("Company")->name ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> 

    <!-- Font Awesome Icons --> 
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/fontawesome-free/css/all.min.css"> 

    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/plugins/toastr/toastr.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('public/adminlte') ?>/dist/css/adminlte.min.css">

    <!-- Datatable -->
    <link href="<?= base_url('/public/adminlte') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    
    <style>
        .price-option-need-approve{
            color: #d34949;
        }
    </style>
    
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper"> 

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-blue navbar-dark">

            <!-- Left navbar links -->

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                        &nbsp;
                        <?= config("Login")->loginName ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">Akun</span>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('settings') ?>" class="dropdown-item">
                            Setting
                        </a>
                        <a href="<?= base_url('logout') ?>" class="dropdown-item">
                            Logout
                        </a>
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-header"></span>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="position:fixed;">
            <!-- Brand Logo -->
            <a href="<?= base_url('dashboard') ?>" class="brand-link">
                <span class="brand-text font-weight-light"><?= config("Company")->name ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar" style="position:fixed;">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php
                        if(config("Login")->loginRole == 1){
                            echo view("general/sidebar_admin");

                        }elseif(config("Login")->loginRole == 2){
                            echo view("general/sidebar_sales");

                        }elseif(config("Login")->loginRole == 3){
                            echo view("general/sidebar_sales");

                        }elseif(config("Login")->loginRole == 4){
                            echo view("general/sidebar_supervisor");

                        }elseif(config("Login")->loginRole == 5){
                            echo view("general/sidebar_supervisor");

                        }elseif(config("Login")->loginRole == 6){
                            echo view("general/sidebar_warehouse");

                        }elseif(config("Login")->loginRole == 7){
                            echo view("general/sidebar_owner");
                        }elseif(config("Login")->loginRole == 8){
                            echo view("general/sidebar_audit");
                        }elseif(config("Login")->loginRole == 9){
                            echo view("general/sidebar_cashier");
                        }elseif(config("Login")->loginRole == 10){    
                            echo view("general/sidebar_sc");
                        }elseif(config("Login")->loginRole == 11){
                            echo view("general/sidebar_partner");
                        }else{

                        }
                        
                        ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $this->renderSection("page_title") ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?= $this->renderSection("page_breadcrumb") ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?= $this->renderSection("page_content") ?>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <?= config("App")->name ?>
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; <?= config("App")->yearMade ?> <a href="#"><?= config("Company")->name ?></a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url('public/adminlte') ?>/plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('public/adminlte') ?>/dist/js/adminlte.min.js"></script>
    <!-- Datatable -->
    <script src="<?= base_url('/public/adminlte') ?>/plugins/datatables/jquery.dataTables.min.js"> </script>
    <script src="<?= base_url('/public/adminlte') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"> </script>

    <!-- Axios -->
    <script type="text/javascript" src="<?= base_url('public/axios.min.js') ?>"></script>

    <script type="text/javascript">  
        // Periksa IP
        async function checkIpClient() {
            try {
                const response = await axios.get('https://api.ipify.org?format=json');
                $.ajax({
                    data : { ip : response.data.ip},
                    url : "<?= base_url('ajax/check_ip') ?>",
                    type : "POST",
                    success : function(response){
                        response = parseInt(response)
                        if(response == 1){
                        }else{
                            //window.location.href = "<?= base_url('logout') ?>";
                        }
                    }
                })
            }catch (error) {
            }
        }
        checkIpClient()
    </script>

    <?php
    if (isset($_SESSION['message_content'])) {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                toastr.<?= $_SESSION['message_type'] ?>('<?= $_SESSION['message_content'] ?>')
            });
        </script>
        <?php
    }
    ?>
    
    <script>
        $(document).ready(function() {
            $('#datatables-default').DataTable({
                "aaSorting": [],
            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#datatables-default1').DataTable({
                "aaSorting": [],


            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });
            
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#datatables-default2').DataTable({
                "aaSorting": [],    

            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });
            
        });
    </script>
  
  
    <script>
        $(document).ready(function() {
            $('#datatables-default5').DataTable({
                "aaSorting": [],


            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });
            
        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('#datatables-grosir').DataTable({
                "aaSorting": [],
            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });

        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('#datatables-default12').DataTable({
                 "aaSorting": [],
                 dom: 'Bfrtip', 
                 buttons: [
                 'excel' 
                 ]
             });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            $('#datatables-default7').DataTable({
                "aaSorting": [],    
                pageLength : 5,
                lengthMenu: [[5, 10, 20, 50], [5, 10, 20, 50]]

            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });
            
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#datatables-default8').DataTable({
                "aaSorting": [],    
                pageLength : 5,
                lengthMenu: [[5, 10, 20, 50], [5, 10, 20, 50]]

            });
            $('#datatables-second').DataTable({
                "aaSorting": [],
            });
            $('#datatables-third').DataTable({
                "aaSorting": [],
            });
            
        });
    </script>
    
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            
            $('#sales').select2({
                theme: 'bootstrap4'
            })

            $('.select2bs4-modalAdd').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalAdd'),
            })
            
            $('.select2bs4-capacity').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalAdd'),
            })
            
            $('.select2bs4-modals').select2({
                theme: 'bootstrap4',
                dropdownParent: $('sale'),
            })

            $('.select2bs4-modals').select2({
                theme: 'bootstrap4',
                dropdownParent: $('modal_sale'),
            })

            $('.select2bs4-mods').select2({
                theme: 'bootstrap4',
                dropdownParent: $('mod_sale'),
            })

            $('.select2bs4-modalEdit').select2({
                theme: 'bootstrap4',
                dropdownParent: $('#modalEdit'),
            })
        })
    </script>
    <?= $this->renderSection("page_script") ?>
</body>

</html>

