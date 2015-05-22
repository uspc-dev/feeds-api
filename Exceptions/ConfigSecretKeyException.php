<?php

namespace USPC\Feeds\Exceptions;

/**
 * Description of ConfigApiHostException
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class ConfigSecretKeyException extends \Exception
{

  const MSG_SECRET_KEY = 'Secret Key must be specified to access remote Service.';

  /**
   * 
   */
  public function __construct()
  {
    parent::__construct(self::MSG_SECRET_KEY);
  }

}
