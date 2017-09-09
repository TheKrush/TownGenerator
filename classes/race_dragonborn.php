<?

require_once("race.php");

class dragonborn extends gender_race
{
  function __construct($gender)
  {
    parent::__construct("Dragonborn", $gender);
    GhLogger::writeLog(get_class()." constructor - ".$gender, GhLogger::TRACE);

    global $rand;
    if($rand->rangeint(0,100) < 90) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 50) { $this->data['lastname'] = ""; }
  }
}

?>