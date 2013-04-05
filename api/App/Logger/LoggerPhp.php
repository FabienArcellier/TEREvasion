<?php
namespace App\Logger;

/**
 * Use the method trigger_error to report log information
 * Describes a logger instance
 *
 * The message MUST be a string or object implementing __toString().
 *
 *
 * This logger implementation don't use the context
 *
 * See https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
 * for the full interface specification.
 * 
 * @author Fabien Arcellier
 */
class LoggerPhp implements ILogger {
  private $debug;
  
  public function __construct()
  {
    $this -> debug = true;
  }

  public function setDebug($active) {
    $this -> debug = active;
  }
  
  /**
    * System is unusable.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function alert($message, array $context = array()) {
    $this ->message($message, E_USER_ERROR);   
  }

  /**
    * Action must be taken immediately.
    *
    * Example: Entire website down, database unavailable, etc. This should
    * trigger the SMS alerts and wake you up.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function critical($message, array $context = array()) {
    $this ->message($message, E_USER_ERROR);
  }

  /**
    * Critical conditions.
    *
    * Example: Application component unavailable, unexpected exception.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function emergency($message, array $context = array()) {
    $this ->message($message, E_USER_WARNING);
  }

  /**
    * Runtime errors that do not require immediate action but should typically
    * be logged and monitored.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function error($message, array $context = array()) {
    $this ->message($message, E_USER_ERROR);
  }
  
  /**
    * Exceptional occurrences that are not errors.
    *
    * Example: Use of deprecated APIs, poor use of an API, undesirable things
    * that are not necessarily wrong.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function warning($message, array $context = array()) {
    $this ->message($message, E_USER_WARNING);
  }
  
  /**
    * Normal but significant events.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function notice($message, array $context = array()) {
    $this ->message($message, E_USER_NOTICE);
  }
  
  /**
    * Interesting events.
    *
    * Example: User logs in, SQL logs.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function info($message, array $context = array()) {
    $this ->message($message, E_USER_NOTICE);
  }
  
  /**
    * Detailed debug information.
    *
    * @param string $message
    * @param array $context
    * @return null
    */
  public function debug($message, array $context = array()) {
    $this ->message($message, E_USER_NOTICE);
  }
  
  /**
    * Logs with an arbitrary level.
    *
    * @param mixed $level
    * @param string $message
    * @param array $context
    * @return null
    */
  public function log($level, $message, array $context = array()) {
    $this ->message($message, $level);
  }
  public function crit($message, array $context = array()) {
    $this ->critical($message, $context);
  }

  public function emerg($message, array $context = array()) {
    $this ->emergency($message, $context);
  }

  public function err($message, array $context = array()) {
    $this ->error($message, $context);
  }

  public function warn($message, array $context = array()) {
    $this ->warning($message, $context);
  }
  
  /**
   * Private method to send message to error log
   * @param string $message
   * @param integer $priority
   * @return null
   */
  private function message($message, $priority)
  {
    if ($this -> debug == false & $priority < E_USER_WARNING)
      return;
    
    $backtrace = debug_backtrace();
    if (array_key_exists('file', $backtrace[1]) &&
            array_key_exists('line', $backtrace[1]))
    {
      $file = $backtrace[1]["file"];
      $line = $backtrace[1]["line"];
      trigger_error('['.$file.'] l:'.$line.'-'.$message, $priority);
    }
    else
    {
      trigger_error($message, $priority);
    }
  }
}

?>
