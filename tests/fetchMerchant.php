<?php

use USPC\Feeds\ServiceConnection;
use USPC\Feeds\MerchantRepository;

require_once(__DIR__ . '/../autoload.php');

try {
  $service = new ServiceConnection();
} catch (Exception $ex) {
  echo "Error: {$ex->getMessage()}", PHP_EOL;
  exit;
}

$repo = new MerchantRepository();
$repo->setConnection($service);

$merchant = $repo->find(1);

if ($merchant) {
  echo 'Merchant found:', PHP_EOL;
  echo '---------------', PHP_EOL;
  $maxLength = max(array_map(function($str) {
        return strlen($str);
      }, array_keys($merchant)));
      
  foreach ($merchant as $key => $value) {
    echo "   ", str_pad($key, $maxLength, ' ', STR_PAD_LEFT), ': ', $value, PHP_EOL;
  }
}
