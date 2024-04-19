<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Token extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'token:check';
    protected $description = 'Check token validity';

    public function run(array $params)
    {
        $controller = new \App\Controllers\BaseController();
        $controller->runTokenCheck();
    }
}
