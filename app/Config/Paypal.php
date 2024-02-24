<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Paypal extends BaseConfig
{
    public $clientId = 'AeFWC2dPM29EMopbKx5vaowNd2Iic4gLT5tOzKzSRtHB5W-VbEVbbeNCU2fGZ12dYyXlrOY3y0JI_RxX';
    public $clientSecret = 'ENDUisTNMz8TMoUvajJbuHdsEERE-CrE2e9HazyJHdgMCM338Oiecmt8b8URHnwD_vGJClrJ9r6E6YKb';
    public $settings = array(
        'mode' => 'sandbox', // sandbox or live
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'FINE'
    );
}