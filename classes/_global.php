<?

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

function logMessage($level, $message)
{
  if($level == "DEBUG")
  {
    return;
  }
  echo("[".$level."] ".$message."\n");
}

?>