<?php

use USPC\Feeds\ServiceConnection;
use USPC\Feeds\ConfigNotFoundException as ConfigException;

require_once(__DIR__ . '/../autoload.php');

try {
$service = new ServiceConnection();
} catch (Exception $ex) {
  echo "Error: {$ex->getMessage()}", PHP_EOL;
  exit;
}

echo 'Service configuration loaded', PHP_EOL;
