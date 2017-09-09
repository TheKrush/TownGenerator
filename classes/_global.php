<?

require_once("GhLogger.class.php");
require_once("mersenne_twister.php");
use mersenne_twister\twister;

if(!$seed)
{
  $seed = 0;
}

global $rand;
$rand = new twister(crc32($seed));

global $MAX_FILECOUNT;
$MAX_FILECOUNT = 100;

global $race_list;
$race_list = array(
  "demon",
  "dragonborn",
  "dwarf",
  "elf",
  "gnome",
  "goblin",
  "halfelf",
  "halfling",
  "human",
  "orc",
  "tiefling"
);

?>