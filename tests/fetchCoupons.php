<?php 

require_once __DIR__ . '/../vendor/autoload.php';

use USPC\Feeds\ServiceConnection;
use USPC\Feeds\CouponRepository;

try {
  $service = new ServiceConnection();
} catch (Exception $ex) {
  echo "Error: {$ex->getMessage()}", PHP_EOL;
  exit;
}

$repo = new CouponRepository();
$repo->setConnection($service);

$coupons = $repo->getByMerchant(1);

if ($coupons) {
  echo 'Coupons found:', PHP_EOL;
  echo '---------------', PHP_EOL;

  foreach ($coupons as $coupon) {
    echo $coupon['offer'], PHP_EOL;
    echo $coupon['url'], PHP_EOL;
    echo PHP_EOL;
  }
} else {
  echo "No coupons found.", PHP_EOL;
}
