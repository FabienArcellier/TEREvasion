<?php

namespace App\Database;
use App\ConfigIni;
use App\Logger\ILogger;

/**
 * Manage the database connection. This component use PDO
 * @author farcellier
 */
class Connection {
  
  /**
   * Configuration information
   * @var \App\ConfigIni
   */
  private $config;
  
  /**
   * Component to log information
   * @var \App\Logger\ILogger 
   */
  private $logger;
  
  /**
   * Instanciate a Database\Connection component
   * @param \App\ConfigIni $config
   * @param \App\Logger\ILogger $logger
   */
  public function __construct(ConfigIni $config, ILogger $logger)
  {
    $this -> config = $config;
    $this -> logger = $logger;
  }
  
}

?>
