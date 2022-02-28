<?php
//oturumla başlatıyoruz. hata raporlamasını başlatıyoruz.
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
ob_start();
session_start();

//tarih verisini istemiyoruz .
date_default_timezone_set('Europe/Istanbul');
const PKEY = 'pk_live_';
const SKEY = 'sk_live_';
const SITEADI = 'Güvenli Ödeme Sayfası';
require 'vendor/autoload.php';

use Dcblogdev\PdoWrapper\Database;

// make a connection to mysql here
/*$options = [
    //required
    'host' => 'blank',
    'port' => 'blank',
    'username' => 'blank',
    'database' => 'blank',
    'password' => 'blank',
];

$db = new Database($options);
*/

?>