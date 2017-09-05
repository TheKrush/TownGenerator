<?

require_once("base.php");

abstract class race extends base
{
  const PARTS = array('First', 'Middle', 'Last', 'Nick');
  const GENDER_NEUTRAL = 'Androgynous';
  const GENDERS = array('Androgynous', 'Female', 'Male');

  function __construct($race)
  {
    parent::__construct();
    logMessage("DEBUG", get_class()." constructor");

    $this->data['race'] = $race;
    $this->loadNames();

    $gender = $this->data['gender'];

    $this->data['firstname'] = $this->getPartName("First", $gender);
    $this->data['middlename'] = $this->getPartName("Middle", $gender);
    $this->data['lastname'] = $this->getPartName("Last", $gender);
    $this->data['nickname'] = $this->getPartName("Nick", $gender);

    global $rand;
    $useNickname = $rand->rangeint(0,100) > 90 ? true : false;
    if($useNickname && $this->data['nickname'] != "")
    {
      $this->data['firstname'] = "";
      $this->data['middlename'] = "";
      $this->data['lastname'] = "";
    }
  }

  public function getRace()
  {
    return $this->data['race'];
  }

  public function getGender()
  {
    $gender = $this->data['gender'];
    return $gender == self::GENDER_NEUTRAL ? "" : $gender;
  }

  public function getName()
  {
    $first = $this->data['firstname'] != "";
    $middle = $this->data['middlename'] != "";
    $last = $this->data['lastname'] != "";
    
    $name = trim(($first ? $this->data['firstname']." " : "").($middle ? $this->data['middlename']." " : "").($last ? $this->data['lastname']." " : ""));
    $nickname = $this->data['nickname'];
    
    if($name && $nickname)
    {
      return $name." aka ".$nickname;
    }
    
    return $name != "" ? $name : $nickname;
  }

  protected function getPartName($part, $gender=null)
  {
    $race = $this->data['race'];
    $gender = $gender ? ucfirst(strtolower($gender)) : self::GENDER_NEUTRAL;

    $name = "";

    global $MAX_FILECOUNT;
    for($k = 0; $k < $MAX_FILECOUNT; ++$k)
    {
      $n = $this->getPartIndexName($part, $k, $gender);
      if (!$n) { break; }
      $name .= $n;
    }

    return !$name && $gender != self::GENDER_NEUTRAL ? $this->getPartName($part) : $name;
  }

  protected function getPartIndexName($part, $partIndex, $gender=null)
  {
    $race = $this->data['race'];
    $gender = $gender ? ucfirst(strtolower($gender)) : self::GENDER_NEUTRAL;

    return $this->getRandom(self::$names[$race][$part][$partIndex][$gender]);
  }

  private function loadNames()
  {
    foreach(self::PARTS as $part)
    {
      $this->loadPart($part);
      foreach(self::GENDERS as $gender)
      {
        $this->loadPart($part, $gender);
      }
    }
  }

  private function loadPart($part, $gender=null)
  {
    global $MAX_FILECOUNT;
    for($k = 0; $k < $MAX_FILECOUNT; ++$k)
    {
      if(!$this->loadPartNames($part, $k, $gender)) { break; }
    }
  }

  private function loadPartNames($part, $partIndex, $gender=null)
  {
    $race = $this->data['race'];
    $gender = $gender == self::GENDER_NEUTRAL ? null : $gender;

    if($gender)
    {
      $filename = "data/".$race."_".$part.$partIndex."_".$gender.".txt";
    }
    else
    {
      $filename = "data/".$race."_".$part.$partIndex.".txt";
      $gender = self::GENDER_NEUTRAL;
    }
    if(!file_exists($filename)) { return false; }
    logMessage("DEBUG", "Loading: ".$filename);
    self::$names[$race][$part][$partIndex][$gender] = file($filename, FILE_IGNORE_NEW_LINES);
    logMessage("DEBUG", "Count: ".count(self::$names[$race][$part][$partIndex][$gender]));

    return true;
  }
}

abstract class genderless_race extends race
{
  function __construct($race)
  {
    $this->data['gender'] = self::GENDER_NEUTRAL;

    parent::__construct($race);
    logMessage("DEBUG", get_class()." constructor - ".$race);
  }
}

abstract class gender_race extends race
{
  function __construct($race)
  {
    global $rand;
    $this->data['gender'] = $rand->rangeint(0,100) < 50 ? "Female" : "Male";

    parent::__construct($race);
    logMessage("DEBUG", get_class()." constructor - ".$race);
  }
}

?>