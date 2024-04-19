<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Custom extends BaseConfig
{
    // Pengaturan persentase harga
    public $pricePercentages = ([
        "",
        5, // Harga ke-2
        10, // Harga ke-3
        15, // Harga ke-4
        20, // Harga ke-5
        25, // Harga ke-6
        30, // Harga ke-7
        35, // Harga ke-8
        40, // Harga ke-9
        45, // Harga ke-10
    ]);
}