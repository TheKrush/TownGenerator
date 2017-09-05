<?

require_once("race.php");

class orc extends gender_race
{
  function __construct()
  {
    parent::__construct("Orc");
    logMessage("DEBUG", get_class()." constructor\n");

    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 75) { $this->data['lastname'] = ""; }
  }
}

?>