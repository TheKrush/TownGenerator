<?

require_once("race.php");

class goblin extends gender_race
{
  function __construct()
  {
    parent::__construct("Goblin");
    logMessage("DEBUG", get_class()." constructor\n");

    global $rand;
    if($rand->rangeint(0,100) < 80) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 80) { $this->data['lastname'] = ""; }
  }
}

?>