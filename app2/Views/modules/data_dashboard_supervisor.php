<?= $this->extend("general/template") ?>

<?= $this->section("page_title") ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section("page_breadcrumb") ?>

<li class="breadcrumb-item active">Dashboard</li>

<?= $this->endSection(); ?>

<?= $this->section("page_content") ?>

<?php  
$thisMonth = date("n");
$lastMonth = $thisMonth - 1;

if($thisMonth > 1){
    $lastMonth = $lastMonth;
}else{
    $lastMonth = 12;
}

$saleMe = $db->table("sales");
$saleMe->select("sales.id as sale_id");
$saleMe->join("administrators","sales.admin_id=administrators.id","left");
if(config("Login")->loginRole == 4){
    $saleMe->where("administrators.role",2);
}else{
    $saleMe->where("administrators.role",3);
}
if(date("j") > 20){
    $saleMe->where("transaction_date >=",date("Y-".$thisMonth."-21"));
    $saleMe->where("transaction_date <=",date("Y-".$thisMonth."-31"));
}else{
    $saleMe->where("transaction_date >=",date("Y-".$lastMonth."-21"));
    $saleMe->where("transaction_date <=",date("Y-".$thisMonth."-20"));
}
$saleMe->where("sales.status >=",6);
$saleMe->orderBy("sales.id","desc");
$saleMe = $saleMe->get();
$saleMe = $saleMe->getResultObject();

$myAchievement = 0;
foreach($saleMe as $sale){
    $items = $db->table("sale_items");
    $items->where("sale_id",$sale->sale_id);
    $items = $items->get();
    $items = $items->getResultObject();

    foreach($items as $item){
        $myAchievement += ($item->quantity * $item->price);
    }
}
?>

<?php
$admins = $db->table("administrators");
$admins->where("active !=",0);
if(config("Login")->loginRole == 4){
    $admins->where("role",2);
}else{
    $admins->where("role",3);
}
$admins = $admins->get();
$admins = $admins->getResultObject();

foreach($admins as $admin){
    $saleThey = $db->table("sales");
    $saleThey->where("admin_id",$admin->id);
    if(date("j") > 20){
        $saleThey->where("transaction_date >=",date("Y-".$thisMonth."-21"));
        $saleThey->where("transaction_date <=",date("Y-".$thisMonth."-31"));
    }else{
        $saleThey->where("transaction_date >=",date("Y-".$lastMonth."-21"));
        $saleThey->where("transaction_date <=",date("Y-".$thisMonth."-20"));
    }
    $saleThey->where("status >=",6);
    $saleThey->orderBy("id","desc");
    $saleThey = $saleThey->get();
    $saleThey = $saleThey->getResultObject();
    
    $theirAchievement = 0;
    foreach($saleThey as $sale){
        $items = $db->table("sale_items");
        $items->where("sale_id",$sale->id);
        $items = $items->get();
        $items = $items->getResultObject();
    
        foreach($items as $item){
            $theirAchievement += ($item->quantity * $item->price);
        }
    }

    $scores[] = array("name"=>$admin->name,"score"=>$theirAchievement);
}

$scoreColumns = array_column($scores, 'score');
array_multisort($scoreColumns, SORT_ASC, $scores);
?>

<div class="row">        
    <div class="col-md-5">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp. <?php 
                    $teamAchievement = 0;
                    if(!empty($myTeam)){
                        foreach($myTeam as $user){
                            $teamAchievement += $user['achievement'];
                        }
                    
                        echo number_format($teamAchievement, 0,",", ".");
                    }
                ?></h3>
                <p>
                    Penjualan (SO) Bulan Ini (<?= config("App")->months[date("n")] ?> <?= date("Y") ?>)
                </p>
            </div>
            <div class="icon">
                <i class="fa fa-money-bill-wave"></i>
            </div>
            <a href="javascript:void(0)" class="small-box-footer">
                &nbsp; <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-info">
                <h5 class="card-title">Leaderboard Bulan Ini (<?= config("App")->months[date("n")] ?> <?= date("Y") ?>)</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="datatables-default">
                    <thead>
                        <tr>
                            <th class='text-center'>No</th>
                            <th class='text-center'>Nama</th>
                            <th class='text-center'>Pencapaian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $scoreNo = 0;
                        if(!empty($myTeam)){
                        foreach($myTeam as $score){
                            $scoreNo++;
                            ?>
                            <tr>
                                <td class='text-center'><?= $scoreNo ?></td>
                                <td><?= $score['sales'] ?></td>
                                <td class='text-right'>Rp. <?= number_format($score['achievement'],0,",",".") ?></td>
                            </tr>
                            <?php
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?= $this->endSection() ?>