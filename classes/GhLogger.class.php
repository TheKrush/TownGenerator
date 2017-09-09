<?php

class GhLoggerException extends RuntimeException
{
}

class GhLogger
{
  static protected $ERROR_LEVEL;
  
  const FATAL = 32;
  const ERROR = 16;
  const WARN  = 8;
  const INFO  = 4;
  const DEBUG = 2;
  const TRACE = 1;

  static protected $instance;
  static protected $enabled = false;
  
  static protected $useTimestamp = false;
  
  static public function setErrorLevel($level)
  {
    self::getInstance($level);
    self::$ERROR_LEVEL = $level;
  }
  
  static public function getErrorLevelName($level)
  {
    $name = "?????";
    switch($level)
    {
      case self::FATAL:
        $name = "FATAL";
        break;
      case self::ERROR:
        $name = "ERROR";
        break;
      case self::WARN:
        $name = "WARN";
        break;
      case self::INFO:
        $name = "INFO";
        break;
      case self::DEBUG:
        $name = "DEBUG";
        break;
      case self::TRACE:
        $name = "TRACE";
        break;
    }
    return $name;
  }

  static public function enableIf($condition = true)
  {
    if ((bool) $condition)
    {
      self::$enabled = true;
    }
  }

  static public function disable()
  {
    self::$enabled = false;
  }

  static protected function getInstance($level=self::DEBUG)
  {
    if (!self::hasInstance())
    {
      self::$instance = new self($level);
    }

    return self::$instance;
  }

  static protected function hasInstance()
  {
    return self::$instance instanceof self;
  }

  static public function writeIfEnabled($message, $level = self::DEBUG)
  {
    if (self::$enabled)
    {
      self::writeLog($message, $level);
    }
  }

  static public function writeIfEnabledAnd($condition, $message, $level = self::DEBUG)
  {
    if (self::$enabled)
    {
      self::writeIf($condition, $message, $level);
    }
  }

  static public function writeLog($message, $level = self::DEBUG)
  {
    self::getInstance()->writeLine($message, $level);
  }

  static public function writeIf($condition, $message, $level = self::DEBUG)
  {
    if ($condition)
    {
      self::writeLog($message, $level);
    }
  }

  protected function __construct($level)
  {
    self::$ERROR_LEVEL = $level;
    $this->writeLine("===================== STARTING =====================", self::DEBUG);
  }

  public function __destruct()
  {
    $this->writeLine("===================== ENDING =====================", self::DEBUG);
  }

  protected function writeLine($message, $level)
  {
    if ($level >= self::$ERROR_LEVEL)
    {
      $m = "";
      if(self::$useTimestamp)
      {
        $date = new DateTime();
        $m .= $date->format('d/m/Y H:i:s')." ";
      }
      $m .= "[".str_pad(self::getErrorLevelName($level), 5, " ", STR_PAD_LEFT)."] ";
      $m .= $message;
      echo("<pre>".$m."</pre>");
    }
  }
}

?>