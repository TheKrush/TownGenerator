<?

require_once("_global.php");

abstract class base
{
  protected $data;

  function __construct()
  {
    GhLogger::writeLog(get_class()." constructor", GhLogger::TRACE);

    if(is_null($this->data))
    {
      $this->data = array();
    }
  }

  protected function getRandom($array)
  {
    if(count($array) == 0) { return null; }

    global $rand;
    $i = $rand->rangeint(0,count($array)-1);
    return $array[$i];
  }
  
  protected function generate()
  {
  }

  public function getData()
  {
    return $this->data;
  }
  
  public function printData()
  {
    print_r($this->data);
  }
}

?>