<?

require_once("race.php");

class demon extends genderless_race
{
  function __construct()
  {
    parent::__construct("Demon");
    GhLogger::writeLog(get_class()." constructor", GhLogger::TRACE);
    
    $this->addNamePattern(array(0,1,4), "First");
    $this->addNamePattern(array(6,2,4), "First");
    $this->addNamePattern(array(5,3,4,1), "First");
    $this->addNamePattern(array(0,1,2,4), "First");
    
    $this->generate();
    
    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 25) { $this->data['lastname'] = ""; }
  }
}

?>