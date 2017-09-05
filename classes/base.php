<?

require_once("_global.php");

abstract class base
{
  protected static $names;
  private static $seed;

  protected $data;

  function __construct()
  {
    logMessage("DEBUG", get_class()." constructor");

    if(is_null($this->data))
    {
      $this->data = array();
    }

    if(is_null(self::$names))
    {
      self::$names = array();
    }
  }

  protected function getRandom($array)
  {
    if(count($array) == 0) { return null; }

    global $rand;
    $i = $rand->rangeint(0,count($array)-1);
    return $array[$i];
  }

  public function getData()
  {
    return $this->data;
  }
}

?>