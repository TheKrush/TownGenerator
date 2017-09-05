<html>
<head>
<style>
body {
    background-color: #ccc;
}
</style>
</head>
<body>
<pre>
<?

$seed = $_GET['seed'];

require_once("classes/_global.php");
require_once("classes/races.php");

logMessage("INFO", "Seed: ".$seed);

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
  logMessage("INFO", str_pad ($i++, 3, " ", STR_PAD_LEFT)." | ".$person->getName()." - ".$person->getRace()." ".$person->getGender());
  //print_r($person->getData());
  //echo("\n");
}

?>
</pre>
</body>
</html>