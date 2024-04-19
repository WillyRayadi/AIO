<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item active">Dashboard</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                Selamat Datang <b><?= config("Login")->loginName ?></b>, sebagai <?= config("App")->roles[config("Login")->loginRole] ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <?php
                $thisMonth = date("n");
                $lastMonth = $thisMonth - 1;

                // if ($thisMonth > 1) {
                //     $lastYear = date("Y");
                //     $lastMonth = $lastMonth;
                // } else {
                //     $lastYear = date("Y") - 1;
                //     $lastMonth = 12;
                // }
                
                if($thisMonth > 1){
                    $lastYear = date("Y");
                    $lastMonth = $lastMonth;
                }else{
                    $lastYear = date("Y") - 1;
                    $lastMonth = 12;
                }

                $times = $db->table('sales');
                $times->select('AVG(TIMESTAMPDIFF(SECOND, sales.time_create, sales.time_done)) AS average_seconds');
                $times->where('sales.contact_id !=', NULL);
                $times->where('sales.time_create !=', NULL);

                // Add the conditions for the last month
                if(date("j") > 20){
                    $times->where("transaction_date >=",date("Y-".$thisMonth."-01"));
                    $times->where("transaction_date <=",date("Y-".$thisMonth."-31"));
                }else{
                    $times->where("transaction_date >=",date("Y-".$thisMonth."-01"));
                    $times->where("transaction_date <=",date("Y-".$thisMonth."-31"));
                }
                $times = $times->get();
                $averageSeconds = $times->getRow()->average_seconds;

                // Calculate average time
                $days = floor($averageSeconds / (60 * 60 * 24));
                $averageSeconds %= (60 * 60 * 24);
                $hours = floor($averageSeconds / (60 * 60));
                $averageSeconds %= (60 * 60);
                $minutes = floor($averageSeconds / 60);
                $seconds = $averageSeconds % 60;
    
                // Display the result
                echo "Rata-rata pengiriman bulan ini: ";
                if ($days > 0) {
                    echo "<b>$days hari,</b> ";
                }
                if ($hours > 0) {
                    echo "<b>$hours jam,</b>";
                }
                if ($minutes > 0) {
                    echo "<b>$minutes menit, </b>";
                }
                echo "<b>$seconds detik</b>.";
                ?>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h5 class="card-title">Data Bonus Sales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Pilih Tanggal Mulai</label>
                            <input type="date" id="startDate" class="form-control" style="border: none; border-bottom: 1px solid #343A40">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <label for="">Pilih Tanggal Selesai</label>
                            <input type="date" id="endDate" class="form-control" style="border: none; border-bottom: 1px solid #343A40">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="form-group">
                            <button id="Filter" class="btn btn-info mt-4">Filter</button>
                        </div>
                    </div>
                </div>
                <div class="row" id="export" style="display: none;">
                    <div class="col-sm">
                        <button class="btn btn-success" id="exportBtn">Export Into Excel</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pencapaian mt-3">
                            <table class="table table-striped" id="pencapaian">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Bonus</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg">
    <div class="card">
        <div class="card-header bg-info">
            <h5 class="card-title">Penjualan Disetujui</h5>
        </div>
        <div class="card-body"> 
            <table class="table table-striped table-bordered table-responsive" id="datatables-default">
                <thead>
                    <tr>
                        <th class="text-center">Nomer SO</th>
                        <th class="text-center">Sales</th>
                        <th class="text-center">Pelanggan</th>
                        <th class="text-center">Tanggal Transaksi</th>
                        <th class="text-center">Alamat Pelanggan</th>
                        <th class="text-center">Status penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sales = $db->table('sales');
                        $sales->select([
                            'sales.status',
                            'contacts.address',
                            'sales.id as sale_id',
                            'sales.number as sale_number',
                            'contacts.name as contact_name',
                            'administrators.name as admin_name',
                            'sales.transaction_date as sale_date',
                        ]);
                        $sales->join('contacts', 'sales.contact_id = contacts.id', 'left');
                        $sales->join('administrators', 'sales.admin_id = administrators.id', 'left');
                        $sales->where('sales.contact_id !=', NULL);
                        $sales->where('sales.status', 2);
                        $sales->orderBy('sales.id','desc');
                        $sales = $sales->get();
                        $sales = $sales->getResultObject();
                        
                        foreach($sales as $sale){
                    ?>
                    <tr>
                        <td><a href="<?= base_url('sales/'.$sale->sale_id.'/manage') ?>"><?= $sale->sale_number ?></a></td>
                        <td><?= $sale->admin_name ?></td>
                        <td><?= $sale->contact_name ?></td>
                        <td class="text-center"><?= $sale->sale_date ?></td>
                        <td><?= $sale->address ?></td>
                        <td class="text-center"><span class="badge badge-<?= config("App")->orderStatusColor[$sale->status] ?>"><?= config("App")->orderStatuses[$sale->status] ?></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        
      function exportToExcel(data)
      {
          const URL = "<?= base_url('report/sales/bonus') ?>";
          $.ajax({
                url: URL,
                type: "GET",
                data: {
                    data: JSON.stringify(data)
                },
                success: function(response){
                    window.location = URL + "?data=" + JSON.stringify(data);
                }
          });
      }
        
       $("#Filter").on("click", function(){
           const bonusURL = "<?= base_url('ajax/get/all/bonus') ?>";
           
           // Check if table pencapaian already has DataTable
           if($.fn.DataTable.isDataTable("#pencapaian")){
                // if so then destroy it
                $('#pencapaian').DataTable().destroy();
           }
           
           $("#pencapaian").DataTable({
               dom: "Bfrtip",
               "bPaginate": false,
               searching: false,
               ajax: {
                  url: bonusURL,
                  dataSrc: "",
                  type: "GET",
                  data: {
                      startDate: $("#startDate").val(),
                      endDate: $("#endDate").val()
                  },
               },
               columns: [
                  {data: "No",
                   render: function(data,type,row,meta){
                       return meta.row + 1;
                   }
                  },
                  {data: "sales"},
                  {data: "bonus",
                   render: function(data, type, row){
                       return new Intl.NumberFormat("id-ID", {
                           style: "currency",
                           currency: "IDR",
                           minimumFractionDigits: 0
                       }).format(data);
                   }
                  }
                ]
           }).ajax.reload();
           $('#export').show();
       }); 
       
      $('#exportBtn').on("click", function() {
          const rows = Array.from(document.querySelectorAll("#tableBody tr"));
          const data = rows.map(row => Array.from(row.querySelectorAll("td")).map(cell => cell.innerText));
          exportToExcel(data);
      });
    });
</script>

<?= $this->endSection() ?>