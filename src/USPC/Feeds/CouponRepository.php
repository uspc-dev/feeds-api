<?php

namespace USPC\Feeds;

use USPC\Feeds\ServiceAware;

/**
 * Description of CouponRepository
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class CouponRepository extends ServiceAware
{

  const API_COUPONS_BY_MERCHANT = '/coupons/byMerchant';

  public function find($id)
  {
    // !!! stub
  }

  /**
   * Return information about merchant coupons with given merchant $id
   * 
   * @param int|array $id
   * @return array
   */
  public function getByMerchant($id)
  {
    if (is_array($id)) {
      $is_multiple = true;
      $id = join(',', $id);
    }

    $data = $this->service->fetch(self::API_COUPONS_BY_MERCHANT . '?merchantId=' . $id);
    if (empty($data)) {
      return [];
    }

    # get all coupons
    $all_coupons = $this->extractCoupons($data);

    # group by merchant id
    $coupons_by_merchant = array_reduce($all_coupons, function($acc, $coupon) {
      $merchant_id = $coupon['merchant']['id'];
      if (empty($acc[$merchant_id])) {
        $acc[$merchant_id] = [];
      }
      $acc[$merchant_id][] = $coupon;

      return $acc;
    }, []);

    return !empty($is_multiple) ? $coupons_by_merchant : current($coupons_by_merchant);
  }

  /**
   * 
   * @param string $data
   * @return array
   */
  private function extractCoupons($data)
  {
    if (empty($data)) {
      return array();
    }

    $xml = simplexml_load_string($data);
    if (!$xml->status) {
      return array();
    }

    $merchants = array();
    foreach ($xml->merchants->merchant as $merchant) {
      $merchantInfo = MerchantRepository::merchantInfo($merchant);
      $merchantId = $merchantInfo['id'];
      $merchants[$merchantId] = $merchantInfo;
    }

    $coupons = array();
    foreach ($xml->coupons->coupon as $coupon) {
      $couponInfo = $this->couponInfo($coupon);
      $merchantId = $couponInfo['merchant_id'];
      $merchantInfo = $merchants[$merchantId];
      $couponInfo['merchant'] = $merchantInfo;
      unset($couponInfo['merchant_id']);

      $coupons[] = $couponInfo;
    }

    return $coupons;
  }

  /**
   * 
   * @param array $coupon
   * @return array
   */
  static public function couponInfo($coupon)
  {
    $coupon = array_map(function($item) {
      return is_array($item) ? $item : (string) $item;
    }, (array) $coupon);

    $coupon['id'] = intval($coupon['id']);
    $coupon['merchant_id'] = intval($coupon['@attributes']['merchant_id']);

    $startDate = strtotime($coupon['startDate']);
    $endDate = strtotime($coupon['endDate']);

    $coupon['startDate'] = empty($startDate) ? null : $startDate;
    $coupon['endDate'] = empty($endDate) ? null : $endDate;

    unset($coupon['@attributes']);

    return $coupon;
  }

}
