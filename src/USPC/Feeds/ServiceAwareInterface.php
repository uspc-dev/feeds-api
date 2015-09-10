<?php

namespace USPC\Feeds;

use USPC\Feeds\ServiceConnection;

/**
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
interface ServiceAwareInterface
{

  /**
   * 
   * @param ServiceConnection $service
   */
  public function setConnection(ServiceConnection $service);
}
