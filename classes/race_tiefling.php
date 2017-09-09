<?

require_once("race.php");

class tiefling extends gender_race
{
  function __construct($gender)
  {
    parent::__construct("Tiefling", $gender);
    GhLogger::writeLog(get_class()." constructor - ".$gender, GhLogger::TRACE);
    
    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 75) { $this->data['lastname'] = ""; }

    if($this->data['firstname'] != "" && $rand->rangeint(0,100) > 5)
    {
      $this->data['nickname'] = "";
    }
  }
}

?>