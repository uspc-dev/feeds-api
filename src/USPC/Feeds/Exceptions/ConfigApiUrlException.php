<?php

namespace USPC\Feeds\Exceptions;

/**
 * Description of ConfigApiHostException
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class ConfigApiUrlException extends \Exception
{

  const MSG_URL_ERROR = 'Base API Url is required.';

  /**
   * 
   */
  public function __construct()
  {
    parent::__construct(self::MSG_URL_ERROR);
  }

}
