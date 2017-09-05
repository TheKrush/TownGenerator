<?

require_once("race.php");

class demon extends genderless_race
{
  function __construct()
  {
    parent::__construct("Demon");
    logMessage("DEBUG", get_class()." constructor\n");

    $this->data['firstname'] = ucfirst(strtolower($this->getFirstName('First')));
    
    global $rand;
    if($rand->rangeint(0,100) < 75) { $this->data['middlename'] = ""; }
    if($rand->rangeint(0,100) < 25) { $this->data['lastname'] = ""; }
  }

  private function getFirstName($part, $gender=null)
  {
    $race = $this->data['race'];
    $gender = $gender ? ucfirst(strtolower($gender)) : self::GENDER_NEUTRAL;

    $name = "";
    switch($part)
    {
      case "First":
        global $rand;
        switch(floor($rand->rangeint(0, 3)))
        {
          case 0:
            $name .= $this->getPartIndexName($part, 0);
            $name .= $this->getPartIndexName($part, 1);
            $name .= $this->getPartIndexName($part, 4);
            break;
          case 1:
            $name .= $this->getPartIndexName($part, 6);
            $name .= $this->getPartIndexName($part, 2);
            $name .= $this->getPartIndexName($part, 4);
            break;
          case 2:
            $name .= $this->getPartIndexName($part, 5);
            $name .= $this->getPartIndexName($part, 3);
            $name .= $this->getPartIndexName($part, 4);
            $name .= $this->getPartIndexName($part, 1);
            break;
          case 3:
          default:
            $name .= $this->getPartIndexName($part, 0);
            $name .= $this->getPartIndexName($part, 1);
            $name .= $this->getPartIndexName($part, 2);
            $name .= $this->getPartIndexName($part, 4);
            break;
        }
        break;
      default:
        return parent::getPartName($part, $gender);
    }

    return !$name && $gender != self::GENDER_NEUTRAL ? $this->getPartName($part) : $name;
  }
}

?>