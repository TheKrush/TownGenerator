<?

require_once("race.php");

class elf extends gender_race
{
  function __construct($gender)
  {
    parent::__construct("Elf", $gender);
    GhLogger::writeLog(get_class()." constructor - ".$gender, GhLogger::TRACE);

    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 25) { $this->data['lastname'] = ""; }
  }
}

?>