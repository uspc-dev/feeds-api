<?php

namespace USPC\Feeds\Exceptions;

/**
 * Description of ConfigApiHostException
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class ConfigApiKeyException extends \Exception
{

  const MSG_KEY_ERROR = 'API Key is required to use Service.';

  /**
   * 
   */
  public function __construct()
  {
    parent::__construct(self::MSG_KEY_ERROR);
  }

}
