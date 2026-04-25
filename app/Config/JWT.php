<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig 
{
    public $jwtSecret = 'Infraconnect@1242';
    public $accessTokenExpiry = 180000000;
    public $refreshTokenExpiry = 180000000;
}