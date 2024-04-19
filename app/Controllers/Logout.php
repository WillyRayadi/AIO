<?php

namespace App\Controllers;

class Logout extends App
{
    public function process_logout(){
        $this->session->destroy();
        return redirect()->to(base_url('/'));
    }
}