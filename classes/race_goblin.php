<?

require_once("race.php");

class goblin extends gender_race
{
  function __construct($gender)
  {
    parent::__construct("Goblin", $gender);
    GhLogger::writeLog(get_class()." constructor - ".$gender, GhLogger::TRACE);

    global $rand;
    if($rand->rangeint(0,100) < 80) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 80) { $this->data['lastname'] = ""; }
  }
}

?>