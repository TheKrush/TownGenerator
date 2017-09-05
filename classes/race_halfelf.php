<?

require_once("race.php");

class halfelf extends gender_race
{
  function __construct()
  {
    parent::__construct("Halfelf");
    logMessage("DEBUG", get_class()." constructor\n");

    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 25) { $this->data['lastname'] = ""; }
  }
}

?>