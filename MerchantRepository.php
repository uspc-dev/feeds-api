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

  const API_FIND_MERCHANT = '/merchants/';
  const API_SEARCH_BY_DOMAIN = '/merchants/search/byDomain';

  /**
   * Return information about merchant with given $id
   * 
   * @param int $id
   * @return null|array
   */
  public function find($id)
  {
    $data = $this->service->fetch(self::API_FIND_MERCHANT . $id);
    if (empty($data)) {
      return null;
    }

    $xml = simplexml_load_string($data);

    if (!$xml->status || $xml->merchants['total'] == 0) {
      return null;
    }

    $merchant = $this->merchantInfo($xml->merchants->merchant);
    
    return $merchant;
  }

  /**
   * 
   * @param string $domain
   * @return array
   */
  public function findByDomain($domain)
  {
    $query = http_build_query(array(
        'domain' => $domain
    ));
    $data = $this->service->fetch(self::API_SEARCH_BY_DOMAIN . '?' . $query);
    
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

  public function findByName($name)
  {
    // !!! stub
  }

  private function merchantInfo($merchant)
  {
    $merchant = (array) $merchant;
    $merchant['id'] = intval($merchant['id']);
    $merchant['coupons'] = intval($merchant['@attributes']['coupons']);
    unset($merchant['@attributes']);
    
    return $merchant;
  }
}
