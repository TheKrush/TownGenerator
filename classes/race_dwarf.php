<?

require_once("race.php");

class dwarf extends gender_race
{
  function __construct()
  {
    parent::__construct("Dwarf");
    logMessage("DEBUG", get_class()." constructor\n");

    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 25) { $this->data['lastname'] = ""; }
  }
}

?>