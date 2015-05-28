<?php

use USPC\Feeds\ServiceConnection;
use USPC\Feeds\MerchantRepository;

require_once(__DIR__ . '/../autoload.php');

if ($argc < 2) {
  echo "Usage: $argv[0] word", PHP_EOL;
  exit;
}

$word = $argv[1];


try {
  $service = new ServiceConnection();
} catch (Exception $ex) {
  echo "Error: {$ex->getMessage()}", PHP_EOL;
  exit;
}


$repo = new MerchantRepository();
$repo->setConnection($service);

$merchants = $repo->findByName($word);

if (!empty($merchants)) {
  echo 'Found merchants:', PHP_EOL;
  echo '================', PHP_EOL;
}

foreach ($merchants as $merchant) {
  $maxLength = max(array_map(function($str) {
        return strlen($str);
      }, array_keys($merchant)));

  foreach ($merchant as $key => $value) {
    echo "   ", str_pad($key, $maxLength, ' ', STR_PAD_LEFT), ': ', $value, PHP_EOL;
  }
  echo '------------------------------------', PHP_EOL;
}
