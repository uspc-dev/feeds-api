<?php

namespace USPC\Feeds;

use USPC\Feeds\ServiceAware;

/**
 * Description of Merchant
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class MerchantRepository extends ServiceAware
{

  const API_FIND_MERCHANT = '/merchants/find/byId';
  const API_SEARCH_BY_DOMAIN = '/merchants/search/byDomain';
  const API_SEARCH_BY_NAME = '/merchants/search/byName';

  /**
   * Return information about merchant with given $id
   * 
   * @param int|array $id
   * @return null|array
   */
  public function find($id)
  {
    if (is_array($id)) {
      $isMultipleResult = true;
      $id = join(',', $id);
    }

    $data = $this->service->fetch(self::API_FIND_MERCHANT . '?merchantId=' . $id);
    if (empty($data)) {
      return null;
    }

    $merchants = $this->extractMerchants($data);

    if (!empty($isMultipleResult)) {
      return $merchants;
    }

    return empty($merchants) ? null : current($merchants);
  }

  /**
   * 
   * @param string $domain
   * @return array
   */
  public function findByDomain($domain)
  {
    $query = http_build_query(array(
        'domain' => $domain,
    ));
    $data = $this->service->fetch(self::API_SEARCH_BY_DOMAIN . '?' . $query);
    return $this->extractMerchants($data);
  }

  /**
   * 
   * @param string $name
   * @return array
   */
  public function findByName($name)
  {
    $query = http_build_query(array(
        'name' => $name,
    ));
    $data = $this->service->fetch(self::API_SEARCH_BY_NAME . '?' . $query);
    return $this->extractMerchants($data);
  }

  /**
   * 
   * @param string $data
   * @return array
   */
  private function extractMerchants($data)
  {
    if (empty($data)) {
      return array();
    }

    $xml = simplexml_load_string($data);
    if (!$xml->status || $xml->merchants['total'] == 0) {
      return array();
    }

    $merchants = array();
    foreach ($xml->merchants->merchant as $merchant) {
      $merchants[] = $this->merchantInfo($merchant);
    }

    return $merchants;
  }

  /**
   * 
   * @param array $merchant
   * @return array
   */
  static public function merchantInfo($merchant)
  {
    $merchant = array_map(function($item) {
      return is_array($item) ? $item : (string) $item;
    }, (array) $merchant);

    $merchant['id'] = intval($merchant['id']);
    $merchant['coupons'] = intval($merchant['@attributes']['coupons']);
    unset($merchant['@attributes']);

    return $merchant;
  }

}
