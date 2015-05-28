<?php

namespace USPC\Feeds;

use USPC\Feeds\Exceptions\MissedConfigException;
use USPC\Feeds\Exceptions\ConfigApiHostException;
use USPC\Feeds\Exceptions\ConfigApiUrlException;
use USPC\Feeds\Exceptions\ConfigApiKeyException;
use USPC\Feeds\Exceptions\ConfigSecretKeyException;

/**
 * Description of ServiceConnection
 *
 * @author Mykola Martynov <mykola.martynov@hotmail.com>
 */
class ServiceConnection
{

  const CONFIG_API_HOST = 'apiHost';
  const CONFIG_API_URL = 'apiUrl';
  const CONFIG_API_KEY = 'apiKey';
  const CONFIG_SECRET_KEY = 'secretKey';

  private $config;

  /**
   * 
   */
  public function __construct()
  {
    $this->loadConfiguration();
  }

  /**
   * 
   */
  private function loadConfiguration()
  {
    # load configuration
    $configFile = __DIR__ . '/config.php';
    $this->config = @include($configFile);
    $this->validateConfig();
  }

  /**
   * 
   * @throws MissedConfigException
   * @throws ConfigApiHostException
   * @throws ConfigApiUrlException
   * @throws ConfigApiKeyException
   * @throws ConfigSecretKeyException
   */
  private function validateConfig()
  {
    $config = $this->config;

    if (!$config) {
      throw new MissedConfigException();
    }

    # check if config values are exists
    if (empty($config[self::CONFIG_API_HOST])) {
      throw new ConfigApiHostException();
    }

    if (empty($config[self::CONFIG_API_URL])) {
      throw new ConfigApiUrlException();
    }

    if (empty($config[self::CONFIG_API_KEY])) {
      throw new ConfigApiKeyException();
    }

    if (empty($config[self::CONFIG_SECRET_KEY])) {
      throw new ConfigSecretKeyException();
    }
  }
  
  /**
   * 
   * @param string $func
   * @return mixed
   */
  public function fetch($func)
  {
    $url = $this->buildUrl() . $func;
    
    // replace simple get request with post authentication
    
    return @file_get_contents($url);
  }
  
  /**
   * Build general URL for access feeds API
   * 
   * @return string
   */
  private function buildUrl()
  {
    return 'http://' . $this->config[self::CONFIG_API_HOST] 
        . $this->config[self::CONFIG_API_URL];
  }

}
