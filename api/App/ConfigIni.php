<?php
namespace App;

/**
 * Config is a service for expose the content of a config
 * file.
 *
 * @author Fabien Arcellier
 */
class ConfigIni {

  /**
   * @var string path of config file
   */
  private $path;

  /**
   * @var array contains the data from the ini file
   */
  private $ini_content = array();

  /**
   * 
   * @var ILogger logger 
   */
  private $logger = null;

  /**
   * @param string $path path of config file
   */
  public function __construct($path, Logger\ILogger $logger) {
    $this -> path = $path;
    $this -> logger = $logger;
    $parsed = parse_ini_file($this->path, true);
    if ($parsed == false) {
      $this->logger->warning("Failed to log " + $this->path);
    }
    else
    {
      $this -> ini_content = $parsed;
    }
  }

  /**
   * Use the convention application/debug to get information store in section
   * application and value debug
   * @param string $path path to get information
   */
  public function get($path) {
    $result = '';
    $split_path = explode('/', $path);
    if (count($split_path) == 2) {
      if (array_key_exists($split_path[0], $this->ini_content)) {
        $section = $this->ini_content[$split_path[0]];
        if (array_key_exists($split_path[1], $section)) {
          $result = $section[$split_path[1]];
        } else {
          $this->logger->warning('That key ' . $split_path[1] . ' does not exists in section .'.$split_path[0]);
        }
      } else {
        $this->logger->warning('That section ' . $split_path[0] . ' does not exists.');
      }
    } else {
      if (array_key_exists($split_path, $this->ini_content)) {
        $result = $this->ini_content[$split_path];
      } else {
        $this->logger->warning('That key ' . $split_path . ' does not exists.');
      }
    }

    return $result;
  }

}

?>
