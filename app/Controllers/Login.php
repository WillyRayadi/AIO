<?php

namespace App\Controllers;

class Login extends App
{
    public function form_login(){
        
        return view("general/form_login");
    }
    public function process_login(){
        $email = $this->request->getPost("email");
        $password = $this->request->getPost("password");
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        
        $ip = $this->request->getPost("ip");

        $admin = $this->adminModel
            ->where("email", $email)
            ->orWhere("username", $email)
            ->first();

        if ($admin) {
            if ($admin->active == 1) {
                if (password_verify($password, $admin->password)) {
                    $address = $this->addressModel->where("address",$ip)->first();

                    if($admin->role == 3){
                        $session_data = ([
                            "login_id"           => $admin->id,
                        ]);
                        $this->session->set($session_data);
                        return redirect()->to(base_url('/dashboard'));
                    }else{
                        if($admin->role == 7){
                            $session_data = ([
                                "login_id"           => $admin->id,
                            ]);
                            $this->session->set($session_data);
                            return redirect()->to(base_url('/dashboard'));
                        }else{
                            //if($address){
                                $session_data = ([
                                    "login_id"           => $admin->id,
                                ]);
                                $this->session->set($session_data);
                                return redirect()->to(base_url('/dashboard'));
                            //}else{
                                //$this->session->setFlashdata('msg', "<strong>Maaf, IP Tidak Terdaftar.</strong>");
                                //$this->session->setFlashdata('msg_status', 'danger');
                                //return redirect()->to(base_url('/'));
                         //   }
                        }

                        if($admin->role == 8){
                            $session_data = ([
                                "login_id"           => $admin->id,
                            ]);
                            $this->session->set($session_data);
                            return redirect()->to(base_url('/dashboard'));
                        }else{
                            //if($address){
                                $session_data = ([
                                    "login_id"           => $admin->id,
                                ]);
                                $this->session->set($session_data);
                                return redirect()->to(base_url('/dashboard'));
                            //}else{
                                //$this->session->setFlashdata('msg', "<strong>Maaf, IP Tidak Terdaftar.</strong>");
                                //$this->session->setFlashdata('msg_status', 'danger');
                                //return redirect()->to(base_url('/'));
                         //   }
                        }
                    }
 
                } else { 
                    $this->session->setFlashdata('msg', "<strong>Maaf, login gagal.</strong> <br> Periksa kembali data login anda.!");
                    $this->session->setFlashdata('msg_status', 'danger');
                    return redirect()->to(base_url('/'));
                }
            } else {
                $this->session->setFlashdata('msg', "<strong>Maaf, login gagal.</strong> <br> Periksa kembali data login anda.!");
                $this->session->setFlashdata('msg_status', 'danger');
                return redirect()->to(base_url('/'));
            }
        } else {
            $this->session->setFlashdata('msg', "<strong>Maaf, login gagal.</strong> <br> Periksa kembali data login anda.!");
            $this->session->setFlashdata('msg_status', 'danger');
            return redirect()->to(base_url('/'));
        }
    }
}
