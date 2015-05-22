<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace USPC\Feeds\Exceptions;

/**
 * Description of ConfigurationNotFoundException
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class MissedConfigException extends \Exception
{

  const MSG_NOT_FOUND = "Configuration file not found.";

  /**
   * 
   */
  public function __construct()
  {
    parent::__construct(self::MSG_NOT_FOUND);
  }

}
