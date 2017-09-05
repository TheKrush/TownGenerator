<?

require_once("race.php");

class dragonborn extends gender_race
{
  function __construct()
  {
    parent::__construct("Dragonborn");
    logMessage("DEBUG", get_class()." constructor\n");

    global $rand;
    if($rand->rangeint(0,100) < 90) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 50) { $this->data['lastname'] = ""; }
  }
}

?>