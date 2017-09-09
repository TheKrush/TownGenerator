<html>
<head>
<style>
body {
  background-color: #ddd;
}
pre {
  margin: 0px;
}
</style>
</head>
<body>
<?

$seed = $_GET['seed'];if(!$seed)
{
  $seed = rand();
}
require_once("classes/_global.php");
GhLogger::setErrorLevel(GhLogger::INFO);
//GhLogger::setErrorLevel(GhLogger::TRACE);
GhLogger::writeLog("Seed: ".$seed);

require_once("classes/races.php");

require_once("classes/base.php");
class town extends base
{
  private $generationInfo;

  private $citizens;

  function __construct($generationInfo)
  {
    parent::__construct();
    GhLogger::writeLog(get_class()." constructor", GhLogger::TRACE);

    $this->generationInfo = $generationInfo;

    if(is_null($this->citizens))
    {
      $this->citizens = array();
      $this->genCitizens();
    }
  }
  
  public function printTown()
  {
    foreach($this->citizens as $citizen)
    {
        GhLogger::writeLog($citizen->getName()." - ".$citizen->getRace()." ".$citizen->getGender(), GhLogger::INFO);
        //$citizen->printData();
    }
  }

  private function genCitizens()
  {
    global $race_list;
    foreach($race_list as $race)
    {
      $race_type = get_parent_class($race);

      switch($race_type)
      {
        case "genderless_race":
          $citizen = new $race();
          $this->citizens[] = $citizen;
          break;
        case "gender_race":
          $citizen = new $race("female");
          $this->citizens[] = $citizen;
          $citizen = new $race("male");
          $this->citizens[] = $citizen;
          break;
      }
    }
  }
}

$town = new town(array());
$town->printTown();
/*
$people = array();

for($i = 0; $i < 100; ++$i)
{
  global $rand;
  $j = floor($rand->rangeint(0, 10));
  switch($j)
  {
    case 0:
      $person = new demon();
      break;
    case 1:
      $person = new dwarf();
      break;
    case 2:
      $person = new dragonborn();
      break;
    case 3:
      $person = new elf();
      break;
    case 4:
      $person = new gnome();
      break;
    case 5:
      $person = new goblin();
      break;
    case 6:
      $person = new halfelf();
      break;
    case 7:
      $person = new halfling();
      break;
    case 8:
    default:
      $person = new human();
      break;
    case 9:
      $person = new orc();
      break;
    case 10:
      $person = new tiefling();
      break;
  }

  array_push($people, $person);

  if(!function_exists("cmp"))
  {
    function cmp($a, $b)
    {
      $r = strcmp($a->getRace(), $b->getRace());
      return $r ? $r : strcmp($a->getName(), $b->getName());
    }
  }
  usort($people, "cmp");
}

$i = 1;
foreach($people as $person)
{
  GhLogger::writeLog(str_pad ($i++, 3, " ", STR_PAD_LEFT)." | ".$person->getName()." - ".$person->getRace()." ".$person->getGender());
  //print_r($person->getData());
  //echo("\n");
}
*/
?>
</body>
</html>