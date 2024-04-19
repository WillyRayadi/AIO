<?php

namespace App\Controllers;

helper('tools_helper');

class Dashboard extends BaseController
{
    private $adminModel;
    private $saleModel;
    private $saleIemModel;
    private $teamModel;
    private $session;
    private $db;
    private $validation;
    private $saleItemModel ;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->validation =  \Config\Services::validation();

        helper("form");

        $this->adminModel = new \App\Models\Administrator();
        $this->saleModel = new \App\Models\Sale();
        $this->saleItemModel = new \App\Models\SaleItem();
        $this->teamModel = new \App\Models\Team();

        if($this->session->login_id == null){            
            $this->session->setFlashdata('msg', 'Maaf, Silahkan login terlebih dahulu!');
            header("location:".base_url('/'));
            exit();
        }
    }
    
    public function getAllAchievement()
    {
        $startDate = $this->request->getVar("startDate");
        $endDate = $this->request->getVar("endDate");
        
        $users = $this->adminModel->select(["id", "name", "role"])->whereIn("role", [2,3,4,5])->where("active", 1)->orderBy("role", "asc")->findAll();
        
        $bonus = $this->saleModel
        ->select(["SUM(sale_items.bonus_sales * sale_items.quantity) as bonus", "sales.admin_id"])
        ->join("sale_items", "sales.id = sale_items.sale_id", "left")
        ->whereIn("sales.admin_id", array_column($users, "id"))
        ->where("sales.status", 6)
        ->where("sales.transaction_date >=", $startDate)
        ->where("sales.transaction_date <=", $endDate)
        ->groupBy("sales.admin_id")
        ->findAll();
        
        /*
         * For Supervisor they got bonus when they made sales order and
         * when their subordinates made sales order
         *
         */
        $bonusSupervisor = $this->saleModel
            ->select(["SUM(sale_items.bonus_supervisor * sale_items.quantity) as bonus", "sales.admin_id"])
            ->join("sale_items", "sales.id = sale_items.sale_id", "left")
            ->whereIn("sales.admin_id", array_column($users, "id"))
            ->where("sales.status", 6)
            ->where("sales.transaction_date >=", $startDate)
            ->where("sales.transaction_date <=", $endDate)
            ->groupBy("sales.admin_id")
            ->findAll();
         
         $bonusFromSubordinate = $this->findBonusFromSubordinate($startDate, $endDate);
        
        $prepare = $this->prepareAchievement($users, $bonus, $bonusSupervisor, $bonusFromSubordinate);
        
        usort($prepare, function($a, $b) {
          return $b["bonus"] - $a["bonus"]; 
        });
        
        return $this->response->setJSON($prepare);
    }
    
    protected function prepareAchievement($users, $bonus, $bonusSupervisor, $bonusFromSubordinate)
    {
        $data = [];
        foreach($users as $user){
            $rowData = [];
            if($user->role == 2 || $user->role == 3){
                $rowData["sales"] = $user->name;
                $rowData["bonus"] = $this->findAllBonus($bonus, $user->id);
            }else if($user->role == 4 || $user->role == 5){
                $rowData["sales"] = $user->name. " (Supervisor)";
                $rowData["bonus"] = $this->findAllBonus($bonusSupervisor, $user->id);
                
                foreach($bonusFromSubordinate as $admin){
                  if($user->id == $admin["leader"]){
                        $rowData["bonus"] += $admin["bonus"];
                  }
                }
            }
            
            $data[] = $rowData;
        }
        
        return $data;
    }
    
    private function findBonusFromSubordinate($startDate, $endDate)
    {
        $users = $this->teamModel->select(["leader_id"])->groupBy("leader_id")->findAll();

        $team  = $this->teamModel->select(["team_member_id", "leader_id"])->whereIn("leader_id", array_column($users, "leader_id"))->findAll();

        $sales = $this->saleModel
            ->select(["SUM(sale_items.bonus_supervisor * sale_items.quantity) as bonus", "sales.admin_id"])
            ->join("sale_items", "sales.id = sale_items.sale_id", "left")
            ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
            ->where("sales.status", 6)
            ->where("sales.transaction_date >=", $startDate)
            ->where("sales.transaction_date <=", $endDate)
            ->groupBy("sales.admin_id")
            ->findAll();

        $prepare = $this->getBonusFromSubordinates($sales, $team);

        return $prepare;
    }
    
    private function getBonusFromSubordinates($sales, $team)
    {
        $bonus = [];
        
        $bonusMapping = [];
        foreach ($team as $admin) {
            $key = $admin->team_member_id;
            if (!isset($bonusMapping[$key])) {
                $bonusMapping[$key] = [];
            }
            $bonusMapping[$key][] = $admin->leader_id;
        }

        foreach ($sales as $user) {
            $sales = $user->admin_id;
            if (isset($bonusMapping[$sales])) {
                foreach ($bonusMapping[$sales] as $leader) {
                    $rowData = [
                        "leader" => $leader,
                        "bonus" => $user->bonus
                    ];

                    $bonus[] = $rowData;
                }
            }
        }

        return $bonus;
    }
    
    protected function findAllBonus($bonus, $userID)
    {
        foreach($bonus as $item){
            if($item->admin_id == $userID){
                return $item->bonus;
            }
        }
        
        return "0";
    }
    
    public function dashboard()
    {
        $data = ([
            "db" => $this->db,
            "myTeam" => $this->getTeamMember()
        ]);

        if(config("Login")->loginRole == 1){
            return view("modules/dashboard_admin",$data);
        }elseif(config("Login")->loginRole == 2){
            return view("modules/dashboard_sales",$data);
        }elseif(config("Login")->loginRole == 3){
            return view("modules/dashboard_sales",$data);
        }elseif(config("Login")->loginRole == 4){
            return view("modules/dashboard_supervisor",$data);
        }elseif(config("Login")->loginRole == 5){
            return view("modules/dashboard_supervisor",$data);
        }elseif(config("Login")->loginRole == 6){
            return view("modules/dashboard_warehouse",$data);
        }elseif(config("Login")->loginRole == 8){
            return view("modules/dashboard_audit",$data);
        }elseif(config("Login")->loginRole == 7){
            return view("modules/dashboard_owner",$data);
        }elseif(config("Login")->loginRole == 9){
            return view("modules/dashboard_cashier",$data);
        }elseif(config("Login")->loginRole == 10){    
            return view("modules/dashboard_sc", $data);
        }elseif(config("Login")->loginRole == 11){    
            return view("modules/dashboard_partner", $data);
        }else{            
            return view("modules/dashboard",$data);
        }
    }
    
    public function data_dashboard(){
        $team = $this->teamModel
        ->join('administrators', 'team.team_member_id = administrators.id')
        ->join('sales', 'sales.admin_id = administrators.id', 'left')
        ->join('sale_items', 'sale_items.sale_id = sales.id', 'left')
        ->where('administrators.active', 1)
        ->where('team.leader_id', $this->session->login_id)
        ->where('sales.status', 6)
        ->where("MONTH(sale_items.date)", date("m"))
        ->where("DATE(sale_items.date) <= LAST_DAY(NOW())")
        ->get()->getResultObject();
        
        $bonus = $this->adminModel
            ->join("sales", "sales.admin_id = administrators.id", "LEFT")
            ->join("sale_items", "sale_items.sale_id = sales.id", "LEFT")
            ->where("active", 1)
            ->where("administrators.id", $this->session->login_id)
            ->where("sales.status", 6)
            ->where("MONTH(sale_items.date)", date("m"))
            ->where("DATE(sale_items.date) <= LAST_DAY(NOW())")
            ->get()->getResultObject();

        $Bonus = $this->teamModel
            ->join('administrators', 'team.team_member_id = administrators.id')
            ->join('sales', 'sales.admin_id = administrators.id', 'left')
            ->join('sale_items', 'sale_items.sale_id = sales.id', 'left')
            ->where('administrators.active', 1)
            ->where('team.leader_id', $this->session->login_id)
            ->where('sales.status', 6)
            ->where("MONTH(sale_items.date)", date("m"))
            ->where("DATE(sale_items.date) <= LAST_DAY(NOW())")
            ->get()->getResultObject();
            
        
        $data = ([
            "db" => $this->db,
            // "MyAchievement" => $this->calculateMyAchievement(),
            // "Achievement" => $this->calculateAchievement(),
        ]);

        return view('modules/data_dashboard_sales', $data);
    }
    
    public function dashboard_supervisor(){
        $data = ([
            "db"    => $this->db,    
        ]);
        return view('modules/data_dashboard_supervisor', $data);   
    }
    
    public function cek_alert()
    {
        $this->session->setFlashdata('message_type', 'error');
        $this->session->setFlashdata('message_content', 'Gagal.');

        return redirect()->to(base_url('dashboard'));
    }
    public function settings(){
         $team = $this->teamModel
        ->join('administrators', 'team.team_member_id = administrators.id', 'left')
        ->where('leader_id', $this->session->login_id)
        ->orderBy('administrators.name', 'asc')
        ->groupBy('administrators.name')
        ->findAll();

        $data = ([
          'team_grosir' => $this->adminModel->where('role', 3)->where('active', 1)->orderBy("name", "asc")->findAll(),
          'team_retail' => $this->adminModel->where('role', 2)->where('active', 1)->orderBy("name", "asc")->findAll(),
          'team' => $team
        ]);
        
        return view("modules/settings", $data);
    }
    public function settings_save(){
        $recent = $this->request->getPost('recent');
        $new = $this->request->getPost('new');
        $confirm = $this->request->getPost('confirm');

        $new_hash = password_hash($new, PASSWORD_BCRYPT);
        $confirm_hash = password_hash($confirm, PASSWORD_BCRYPT);

        $admin = $this->adminModel
            ->where("id", $this->session->login_id)
            ->first();

        if (password_verify($recent, $admin->password)) {
            if(password_verify($confirm,$new_hash)){

                if(strlen($new) < 8){
                    $this->session->setFlashdata('message_type', 'error');
                    $this->session->setFlashdata('message_content', 'Password minimal 8 karakter');
        
                    return redirect()->to(base_url('settings'));
                }else{
                    $this->adminModel
                    ->where("id",$this->session->login_id)
                    ->set(["password"=>$new_hash])->update();
                    $this->session->setFlashdata('message_type', 'success');
                    $this->session->setFlashdata('message_content', 'Password berhasil disimpan');
        
                    return redirect()->to(base_url('settings'));
                }
            }else{
                $this->session->setFlashdata('message_type', 'error');
                $this->session->setFlashdata('message_content', 'Password konfirmasi salah');
    
                return redirect()->to(base_url('settings'));
            }
        }else{
            $this->session->setFlashdata('message_type', 'error');
            $this->session->setFlashdata('message_content', 'Password saat ini salah');

            return redirect()->to(base_url('settings'));
        }
    }
    
        public function save_team()
    {
        $dataInsert = [];
        $leaderId = session()->login_id;

        $teamMemberIds = $this->request->getPost('team_member_id');

        if (!empty($teamMemberIds)) {
            foreach ($teamMemberIds as $memberId) {
                $dataInsert[] = [
                    'leader_id' => $leaderId,
                    'team_member_id' => $memberId,
                ];
            }
        }

        if (!empty($dataInsert)) {
            $this->teamModel->insertBatch($dataInsert);
        }

        return redirect()->to(base_url('settings'));
    }

        public function delete_team($id)
    {
       $team = $this->teamModel->where('team_member_id', $id)->first();
       $ids = $team->id;

       $this->teamModel->delete($ids);

       return redirect()->to(base_url('settings'));
    }
    
    public function getTeamMember()
    {
        $team = $this->teamModel->select(["team_member_id"])->where("leader_id", $this->session->login_id)->findAll();
        
        if($team){
            $users = $this->adminModel->select(['id', 'name'])->whereIn("id", array_column($team, "team_member_id"))->findAll();
            
            $salesStatus = date('j') > 20 ? 5 : 6;
            $startDate = date('j') > 20 ? date("Y-m-21") : date("Y-m", strtotime("-1 month")) . "-21";
            $endDate = date('j') > 20 ? date("Y-m-t") : date("Y-m-20");
            
            $teamMemberIds = array_column($team, "team_member_id");
            
            $sales = $this->saleModel
                ->select(["SUM(sale_items.price * sale_items.quantity) as pencapaian", "sales.admin_id"])
                ->join("sale_items", "sale_items.sale_id = sales.id", "left")
                ->whereIn("sales.admin_id", $teamMemberIds)
                ->where("sales.status >=", $salesStatus)
                ->where("transaction_date >=", $startDate)
                ->where("transaction_date <=", $endDate)
                ->groupBy(["sales.admin_id"])
                ->findAll();
    
            $salesBonus = $this->saleModel
                ->select(["SUM(sale_items.bonus_sales * sale_items.quantity) as bonus", "sales.admin_id"])
                ->join("sale_items", "sale_items.sale_id = sales.id", "left")
                ->whereIn("sales.admin_id", $teamMemberIds)
                ->where("sales.status >=", $salesStatus)
                ->where("transaction_date >=", $startDate)
                ->where("transaction_date <=", $endDate)
                ->groupBy(["sales.admin_id"])
                ->findAll();
            
            // if(date('j') > 20){
            //      $sales = $this->saleModel
            //         ->select(["SUM(sale_items.price * sale_items.quantity) as pencapaian", "sales.admin_id"])
            //         ->join("sale_items", "sale_items.sale_id = sales.id", "left")
            //         ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
            //         ->where("sales.status >=", 5)
            //         ->where("transaction_date >=", date("Y-m-21"))
            //         ->where("transaction_date <=", date("Y-m-t"))
            //         ->groupBy(["sales.admin_id"])
            //         ->findAll();

            //     $salesBonus = $this->saleModel
            //         ->select(["SUM(sale_items.bonus_sales * sale_items.quantity) as bonus", "sales.admin_id"])
            //         ->join("sale_items", "sale_items.sale_id = sales.id", "left")
            //         ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
            //         ->where("sales.status >=", 5)
            //         ->where("transaction_date >=", date("Y-m-21"))
            //         ->where("transaction_date <=", date("Y-m-t"))
            //         ->groupBy(["sales.admin_id"])
            //         ->findAll();
            // }else{
            //      $sales = $this->saleModel
            //         ->select(["SUM(sale_items.price * sale_items.quantity) as pencapaian", "sales.admin_id"])
            //         ->join("sale_items", "sale_items.sale_id = sales.id", "left")
            //         ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
            //         ->where("sales.status >=", 6)
            //         ->where("transaction_date >=", date("Y-m", strtotime("-1 month")) . "-21")
            //         ->where("transaction_date <=", date("Y-m-20"))
            //         ->groupBy(["sales.admin_id"])
            //         ->findAll();

            //     $salesBonus = $this->saleModel
            //         ->select(["SUM(sale_items.bonus_sales * sale_items.quantity) as bonus", "sales.admin_id"])
            //         ->join("sale_items", "sale_items.sale_id = sales.id", "left")
            //         ->whereIn("sales.admin_id", array_column($team, "team_member_id"))
            //         ->where("sales.status >=", 6)
            //         ->where("transaction_date >=", date("Y-m", strtotime("-1 month")) . "-21")
            //         ->where("transaction_date <=", date("Y-m-20"))
            //         ->groupBy(["sales.admin_id"])
            //         ->findAll();
            // }
            
            $prepare = $this->prepareData($team, $users, $sales, $salesBonus);
            
            usort($prepare, function($a, $b){
                return $b["achievement"] - $a["achievement"];
            });
            
            return $prepare;
        }
        
        return "0";
    }
    
    public function prepareData($team, $users, $sales, $salesBonus)
    {
        $data = [];
        foreach($team as $user){
            $rowData = [
               "sales" => $this->findName($users, $user->team_member_id),
               "achievement" => $this->findSalesAchievement($sales, $user->team_member_id),
               "bonus" => $this->findSalesBonus($salesBonus, $user->team_member_id)
            ];
            
            $data[] = $rowData;
        }
        
        return $data;
    }
    
    public function findName($users, $memberID)
    {
        foreach($users as $user){
            if($user->id == $memberID){
                return $user->name;
            }
        }
        
        return "-";
    }
    
    public function findSalesAchievement($sales, $memberID)
    {
        foreach($sales as $user)
        {
            if($user->admin_id == $memberID){
                return $user->pencapaian;
            }
        }
        
        return "0";
    }
    
    public function findSalesBonus($salesBonus, $memberID)
    {
        foreach($salesBonus as $user){
            if($user->admin_id == $memberID){
                return $user->bonus;
            }
        }
        
        return "0";
    }
    
}
