<?php

$classes = [
  "Commoner" => 83.6,
  "Warrior" => 6,
  "Expert" => 4,
  "Adept" => 1,
  "Aristocrat" => 1,
  "Fighter" => 0.4,
  "Cleric" => 0.4,
  "Ranger" => 0.4,
  "Paladin" => 0.4,
  "Bard" => 0.4,
  "Rogue" => 0.4,
  "Barbarian" => 0.4,
  "Druid" => 0.4,
  "Monk" => 0.4,
  "Sorcerer" => 0.4,
  "Wizard" => 0.4
];

$totalclasss = [
  "Commoner" => 0,
  "Warrior" => 0,
  "Adept" => 0,
  "Expert" => 0,
  "Aristocrat" => 0,
  "Fighter" => 0,
  "Cleric" => 0,
  "Ranger" => 0,
  "Paladin" => 0,
  "Bard" => 0,
  "Rogue" => 0,
  "Barbarian" => 0,
  "Druid" => 0,
  "Monk" => 0,
  "Sorcerer" => 0,
  "Wizard" => 0
];

$racePopulations = [
  "Dwarf" => array(
    "1" => "70",
    "2" => "25",
    "3" => "5",
  ),
  "Dragonborn" => array(
    "1" => "70",
    "2" => "25",
    "3" => "5",
  ),
  "Elf" => array(
    "1" => "80",
    "2" => "15",
    "3" => "5",
  ),
  "Gnome" => array(
    "0" => "10",
    "1" => "20",
    "2" => "35",
    "3" => "20",
    "4" => "15"
  ),
  "Halfelf" =>array(
    "1" => "70",
    "2" => "25",
    "3" => "5",
  ),
  "Halfling" =>array(
    "0" => "10",
    "1" => "20",
    "2" => "35",
    "3" => "20",
    "4" => "15"
  ),
  "Halforc" =>array(
    "1" => "70",
    "2" => "25",
    "3" => "5",
  ),
  "Human" =>array(
    "1" => "70",
    "2" => "25",
    "3" => "5",
  ),
];

$businessPriority = array(
  "Blacksmiths" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Warrior",
      "Fighter",
      "Paladin"
    ),
    array(
      "Cleric",
      "Commoner",
      "Barbarian"
    )
  ),
  "Fletchers" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Ranger",
      "Fighter"
    ),
    array(
      "Commoner",
      "Rogue"
    )
  ),
  "Leatherworkers" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Ranger",
      "Fighter"
    ),
    array(
      "Commoner",
      "Rogue"
    )
  ),
  "Temples" => array(
    array(
      "Cleric",
      "Paladin"
    ),
    array(
      "Commoner"
    )
  ),
  "General_Stores" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Commoner"
    ),
    array(
      "Fighter",
      "Ranger",
      "Rogue",
      "Monk",
      "Druid",
      "Sorcerer",
      "Bard"
    )
  ),
  "Adventuring_Supplies" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Commoner"
    ),
    array(
      "Fighter",
      "Barbarian",
      "Ranger",
      "Rogue",
      "Monk",
      "Druid",
      "Sorcerer",
      "Bard"
    )
  ),
  "Tailors" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Commoner"
    ),
    array(
      "Fighter",
      "Ranger",
      "Rogue",
      "Monk",
      "Druid",
      "Sorcerer",
      "Bard"
    ),
    array(
      "Commoner"
    )
  ),
  "Taverns" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Aristocrat",
      "Fighter",
      "Ranger",
      "Rogue",
      "Barbarian",
      "Druid",
      "Monk",
      "Commoner"
    )
  ),
  "Jewelers" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Fighter",
      "Ranger",
      "Rogue",
      "Druid"
    ),
    array(
      "Commoner"
    )
  ),
  "Potion_Shops" => array(
    array(
      "Expert",
      "Adept"
    ),
    array(
      "Druid",
      "Ranger",
      "Wizard",
      "Rogue"
    ),
    array(
      "Commoner"
    )
  ),
  "Arcane_Shops" => array(
    array(
      "Wizard",
      "Sorcerer"
    ),
    array(
      "Expert",
      "Adept",
      "Bard"
    ),
    array(
      "Commoner"
    )
  )
);

$populations = [
  "Thorp" =>   array(
  "Population" => "3-20",
  "Businesses" => array(
    "Blacksmiths" => array(
      "0" => "10",
      "1" => "90"
    ),
    "Fletchers" => array(
      "0" => "85",
      "1" => "15"
    ),
    "Leatherworkers" => array(
      "0" => "15",
      "1" => "85"
    ),
    "Temples" => array(
      "0" => "45",
      "1" => "55"
    ),
    "General_Stores" => array(
      "0" => "10",
      "1" => "90"
    ),
    "Adventuring_Supplies" => array(
      "0" => "85",
      "1" => "15"
    ),
    "Tailors" => array(
      "0" => "25",
      "1" => "75"
    ),
    "Taverns" => array(
      "0" => "10",
      "1" => "90"
    ),
    "Jewelers" => array(
      "0" => "95",
      "1" => "5"
    ),
    "Potion_Shops" => array(
      "0" => "80",
      "1" => "20"
    ),
    "Arcane_Shops" => array(
      "0" => "95",
      "1" => "5"
    )
  )
),
"Hamlet" => array(
  "Population" => "21-60",
  "Businesses" => array(
    "Blacksmiths" => array(
      "0" => "10",
      "1" => "70",
      "2" => "20"
    ),
    "Fletchers" => array(
      "0" => "10",
      "1" => "65",
      "2" => "25"
    ),
    "Leatherworkers" => array(
      "0" => "10",
      "1" => "75",
      "2" => "15"
    ),
    "Temples" => array(
      "1" => "65",
      "2" => "35"
    ),
    "General_Stores" => array(
      "0" => "5",
      "1" => "85",
      "2" => "10"
    ),
    "Adventuring_Supplies" => array(
      "0" => "10",
      "1" => "75",
      "2" => "15"
    ),
    "Tailors" => array(
      "0" => "20",
      "1" => "65",
      "2" => "15"
    ),
    "Taverns" => array(
      "0" => "10",
      "1" => "65",
      "2" => "25"
    ),
    "Jewelers" => array(
      "0" => "85",
      "1" => "15",
      "2" => "5"
    ),
    "Potion_Shops" => array(
      "0" => "75",
      "1" => "15"
    ),
    "Arcane_Shops" => array(
      "0" => "80",
      "1" => "20"
    )
  )
),
"Village" => array(
  "Population" => "61-200",
  "Businesses" => array(
    "Blacksmiths" => array(
      "0" => "5",
      "1" => "25",
      "2" => "65",
      "3" => "5"
    ),
    "Fletchers" => array(
      "0" => "10",
      "1" => "45",
      "2" => "30",
      "3" => "15"
    ),
    "Leatherworkers" => array(
      "0" => "10",
      "1" => "30",
      "2" => "55",
      "3" => "5"
    ),
    "Temples" => array(
      "0" => "15",
      "1" => "65",
      "2" => "15",
      "3" => "5"
    ),
    "General_Stores" => array(
      "0" => "5",
      "1" => "10",
      "2" => "65",
      "3" => "10"
    ),
    "Adventuring_Supplies" => array(
      "0" => "5",
      "1" => "35",
      "2" => "45",
      "3" => "10",
      "4" => "5"
    ),
    "Tailors" => array(
      "0" => "5",
      "1" => "35",
      "2" => "50",
      "3" => "10"
    ),
    "Taverns" => array(
      "0" => "5",
      "1" => "65",
      "2" => "25",
      "3" => "5"
    ),
    "Jewelers" => array(
      "0" => "80",
      "1" => "10",
      "2" => "5",
      "3" => "5"
    ),
    "Potion_Shops" => array(
      "0" => "35",
      "1" => "55",
      "2" => "5",
      "3" => "5"
    ),
    "Arcane_Shops" => array(
      "0" => "80",
      "1" => "15",
      "2" => "5"
    )
  )
),
"Small Town" => array(
  "Population" => "201-2000",
  "Businesses" => array(
    "Blacksmiths" => array(
      "2" => "15",
      "3" => "30",
      "4" => "40",
      "5" => "15"
    ),
    "Fletchers" => array(
      "2" => "10",
      "3" => "65",
      "4" => "25"
    ),
    "Leatherworkers" => array(
      "2" => "10",
      "3" => "15",
      "4" => "75"
    ),
    "Temples" => array(
      "1-4" => "100"
    ),
    "General_Stores" => array(
      "3" => "10",
      "4" => "65",
      "5" => "15"
    ),
    "Adventuring_Supplies" => array(
      "2" => "15",
      "3" => "30",
      "4" => "30",
      "5" => "15"
    ),
    "Tailors" => array(
      "3" => "25",
      "4" => "50",
      "5" => "25"
    ),
    "Taverns" => array(
      "2" => "15",
      "3" => "30",
      "4" => "40",
      "5" => "15"
    ),
    "Jewelers" => array(
      "1" => "10",
      "2" => "20",
      "3" => "30",
      "4" => "30",
      "5" => "10"
    ),
    "Potion_Shops" => array(
      "1" => "15",
      "2" => "75",
      "3" => "10",
      "4" => "5"
    ),
    "Arcane_Shops" => array(
      "1" => "20",
      "2" => "65",
      "3" => "10",
      "4" => "5"
    )
  )
),
"Large Town" => array(
  "Population" => "2001-5000",
  "Businesses" => "6-14"
),
"Small City" => array(
  "Population" => "5001-10000",
  "Businesses" => "15-25"
),
"Large City" => array(
  "Population" => "10001-25000",
  "Businesses" => "35-64"
),
"Metropolis" => array(
  "Population" => "25000-50000",
  "Businesses" => "65-95"
)];

?>

