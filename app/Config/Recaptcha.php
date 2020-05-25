<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Recaptcha extends BaseConfig
{
    public $siteUrl = 'https://www.google.com/recaptcha/api/siteverify';
    public $siteKey = '';
    public $secretKey = '';

}