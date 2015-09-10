<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use USPC\Feeds\ServiceConnection;

try {
  $service = new ServiceConnection();
} catch (Exception $ex) {
  echo "Error: {$ex->getMessage()}", PHP_EOL;
  exit;
}

echo 'Service configuration loaded', PHP_EOL;
