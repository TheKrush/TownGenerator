<?

require_once("base.php");

abstract class race extends base
{
  const PARTS = array('First', 'Middle', 'Last', 'Nick');
  const GENDER_NEUTRAL = 'Androgynous';
  const GENDERS = array('Androgynous', 'Female', 'Male');
  
  static protected $names;
  static protected $namePatterns;

  function __construct($race, $gender)
  {
    parent::__construct();
    GhLogger::writeLog(get_class()." constructor - ".$race." ".$gender, GhLogger::TRACE);

    if(is_null(self::$names))
    {
      self::$names = array();
    }

    if(is_null(self::$namePatterns))
    {
      self::$namePatterns = array();
    }
    
    $this->data['race'] = $race = ucfirst(strtolower($race));
    $this->data['gender'] = $gender = ucfirst(strtolower($gender));
    $this->loadNames($gender);
    
    $this->generate();
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
  
  protected function generate()
  {
    parent::generate();
    
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
  
  protected function addNamePattern($pattern, $part, $gender=null)
  {
    $race = $this->data['race'];
    $part = ucfirst(strtolower($part));
    $gender = $gender ? $gender : self::GENDER_NEUTRAL;
    
    self::$namePatterns[$race][$part][$gender][] = $pattern;
  }

  private function getPartName($part, $gender=null)
  {
    $race = $this->data['race'];
    $part = ucfirst(strtolower($part));
    $gender = $gender ? $gender : self::GENDER_NEUTRAL;

    $name = "";
    if(is_null(self::$namePatterns[$race][$part][$gender]))
    {
      global $MAX_FILECOUNT;
      for($k = 0; $k < $MAX_FILECOUNT; ++$k)
      {
        $n = $this->getPartIndexName($part, $k, $gender);
        if (!$n) { break; }
        $name .= $n;
      }
    }
    else
    {
      global $rand;
      $pattternIndex = $rand->rangeint(0, count(self::$namePatterns[$race][$part][$gender])-1);
      GhLogger::writeLog("Pattern: ".json_encode(self::$namePatterns[$race][$part][$gender][$pattternIndex]));
      foreach(self::$namePatterns[$race][$part][$gender][$pattternIndex] as $k)
      {
        if(is_numeric($k))
        {
          $name .= $this->getPartIndexName($part, $k, $gender);
        }
        else
        {
          $name .- $k;
        }
      }
    }
    
    $name = ucfirst(strtolower($name));

    return !$name && $gender != self::GENDER_NEUTRAL ? $this->getPartName($part) : $name;
  }

  private function getPartIndexName($part, $partIndex, $gender=null)
  {
    $race = $this->data['race'];
    $part = ucfirst(strtolower($part));
    $gender = $gender ? $gender : self::GENDER_NEUTRAL;

    return $this->getRandom(self::$names[$race][$part][$partIndex][$gender]);
  }

  private function loadNames($gender)
  {
    foreach(self::PARTS as $part)
    {
      $this->loadPart($part);
      $this->loadPart($part, $gender);
    }
  }

  private function loadPart($part, $gender=self::GENDER_NEUTRAL)
  {
    global $MAX_FILECOUNT;
    for($k = 0; $k < $MAX_FILECOUNT; ++$k)
    {
      if(!$this->loadPartNames($part, $k, $gender)) { break; }
    }
  }

  private function loadPartNames($part, $partIndex, $gender=self::GENDER_NEUTRAL)
  {
    $race = $this->data['race'];
    $part = ucfirst(strtolower($part));

    $filename = "data/".$race."_".$part.$partIndex.($gender == self::GENDER_NEUTRAL ? "" : "_".$gender).".txt";
    GhLogger::writeLog($filename);
    if(!file_exists($filename)) { return false; }
    if(!is_null(self::$names[$race][$part][$partIndex][$gender])) { return false; }
    
    GhLogger::writeLog("Loading: ".$filename);
    self::$names[$race][$part][$partIndex][$gender] = file($filename, FILE_IGNORE_NEW_LINES);
    GhLogger::writeLog("Count: ".count(self::$names[$race][$part][$partIndex][$gender]));

    return true;
  }
}

abstract class genderless_race extends race
{
  function __construct($race)
  {
    parent::__construct($race, self::GENDER_NEUTRAL);
    GhLogger::writeLog(get_class()." constructor - ".$race, GhLogger::TRACE);
  }
}

abstract class gender_race extends race
{
  function __construct($race, $gender)
  {
    parent::__construct($race, $gender);
    GhLogger::writeLog(get_class()." constructor - ".$race, GhLogger::TRACE);
  }
}

?>