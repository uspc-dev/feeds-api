<?php

namespace USPC\Feeds;

use USPC\Feeds\ServiceAwareInterface;

/**
 * Description of BaseRepository
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
abstract class ServiceAware implements ServiceAwareInterface
{

  protected $service;

  /**
   * @inheridoc
   */
  public function setConnection(ServiceConnection $service)
  {
    $this->service = $service;
  }

}
