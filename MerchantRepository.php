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

  const API_MERCHANTS = '/merchants/';

  /**
   * Return information about merchant with given $id
   * 
   * @param int $id
   * @return null|array
   */
  public function find($id)
  {
    $data = $this->service->fetch(self::API_MERCHANTS . $id);
    if (empty($data)) {
      return null;
    }

    $xml = simplexml_load_string($data);

    if (!$xml->status || $xml->merchants['total'] == 0) {
      return null;
    }

    $merchant = (array) $xml->merchants->merchant;
    $merchant['id'] = intval($merchant['id']);
    $merchant['coupons'] = intval($merchant['@attributes']['coupons']);
    unset($merchant['@attributes']);
    
    return $merchant;
  }

  public function findByDomain($domain)
  {
    // !!! stub
  }

  public function findByName($name)
  {
    // !!! stub
  }

}
