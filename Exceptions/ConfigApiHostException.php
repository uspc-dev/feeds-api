<?php

namespace USPC\Feeds\Exceptions;

/**
 * Description of ConfigApiHostException
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class ConfigApiHostException extends \Exception
{

  const MSG_HOST_ERROR = 'Host for the Service is not specified.';

  /**
   * 
   */
  public function __construct()
  {
    parent::__construct(self::MSG_HOST_ERROR);
  }

}
