<?php

include("variables.php");
include("names_c.php");

class generation
{
  private $generationInfo;
  private $town;
  private $townSeed;
  private $seed;

  private $townName;
  private $townSize;
  private $townPopulations;
  private $townChildrenChance;

  #Construct function takes the sent data from the index page, and sets variables
  public function __construct($POST)
  {
    #This internal function filters all of the input and cleans it
    function filter(&$value)
    {
      $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }

    #Call filter function on the $_POST variable
    array_walk_recursive($POST, "filter");

    #Update variables
    $this->generationInfo = $POST;

    #Set a universal town seed
    $this->townSeed = $this->generationInfo["name"].$this->generationInfo["size"].$this->generationInfo["values"]["dwarf"].$this->generationInfo["values"]["dragonborn"].$this->generationInfo["values"]["elf"].$this->generationInfo["values"]["gnome"].$this->generationInfo["values"]["halfelf"].$this->generationInfo["values"]["halfling"].$this->generationInfo["values"]["halforc"].$this->generationInfo["values"]["human"].$this->generationInfo["children"];

    #Set assorted variables
    $this->townName = $this->generationInfo["name"];
    $this->townSize = $this->generationInfo["size"];
    $this->townPopulations = $this->generationInfo["values"];
    $this->townChildrenChance = $this->generationInfo["children"];
  }

  #This takes a string, and sets the seed
  public function setSeed($seed)
  {
    #It sets the internal seed and converts it into an INT32 through crc32
    $this->seed = crc32($seed);

    #And then sets mt_srand to use that new seed
    mt_srand($this->seed);
  }

  #This function takes an array, and returns an array with 0 => random selected index, and 1 => randomly selected content
  public function getRandom($array)
  {
    #Get random index from array
    $i = floor(mt_rand(0, count($array)-1));

    #Return that as an array with the content of that selection
    return array($i, $array[$i]);
  }

  #Debug option to print finished town
  public function printTown()
  {
    echo "<pre>";
    echo print_r($this->town);
    echo "</pre>";
  }

  #Debug option to print town settings (ie, $_POST input)
  public function printSettings()
  {
    echo "<pre>";
    echo print_r($this->generationInfo);
    echo "</pre>";
  }

  #This function creates the population numbers from the percentages gives on the index page
  public function getPopulationNumbers()
  {
    #Get the population variables from variables.php (see includes)
    global $populations;

    #Get population range based on town size
    $populationRange = explode("-", $populations[$this->townSize]["Population"]);

    #Get total population
    $populationNumber = floor(mt_rand($populationRange[0], $populationRange[1]));

    #For each of the percentage of races in the town
    foreach($this->townPopulations as $race => $percentage)
    {
      #Get part of population that is a part of that race
      $this->town["Demographics"][$race] = round($populationNumber*($percentage/100));
    }

    #Set total population
    $this->town["Population"] = $populationNumber;
  }

  #This function creates all the citizens in the town, with regards to demographics, and then generates relationships between the citizens
  public function createPopulation()
  {
    #Create a new name generator class
    $nameGenerator = new race();

    #For each demographic
    for($raceint = 0; $raceint < count($this->town["Demographics"]); $raceint++)
    {
      #Get the name of the current race
      $race = array_keys($this->town["Demographics"])[$raceint];

      #Get the amount of each race
      $content = $this->town["Demographics"][$race];

      #For each person in that demographic
      for($popint = 0; $popint < $content; $popint++) {
        #Create a seed from the total town seed, race type, and the population type
        $this->setSeed($this->townSeed.$raceint.$popint);

        #This gets the class for the person
        $class = $this->getClass();

        #There's a 50/50 chance of each person being female or male
        #Possible input later; male/female balance?
        $gender = mt_rand(0,100) < 50 ? 0 : 1;

        #Set the name generator's seed to include the gender
        $nameGenerator->setSeed($this->townSeed.$raceint.$popint.$gender);

        #Create a name for the person with their $race (variable) as the function
        $name = $nameGenerator->$race($gender);

        #Set the variable for the citizens
        $this->town["Citizens"][] = array(
          "Race"      => ucfirst($race),
          "Name"      => $name,
          "Gender"    => $gender == 0 ? "Female" : "Male",
          "Class"     => $class,
          "Profession"  => "",
          "Relationships" => array()
        );
      }
    }

    #Declare race populations variable (see include variables.php)
    global $racePopulations;

    #Loop through each citizen
    for($id = 0; $id < count($this->town["Citizens"]); $id++) {
      #Set the seed to the town seed and the id of the person
      $this->setSeed($this->townSeed.$id);

      #If the random number is above this random number (make into input?)
      if(mt_rand(1,100) > 75)
      {
        #Then try to find a partner for the person
        $partner = $this->getPartner($this->town["Citizens"][$id]);

        #If the variable is valid (not false, see getPartner function)
        if($partner)
        {
          #Set the relationships
          $this->town["Citizens"][$id]["Relationships"]["Partner"] = $partner;
          $this->town["Citizens"][$partner]["Relationships"]["Partner"] = $id;

          #Set the seed to include the partner
          $this->setSeed($this->townSeed.$id.$partner);

          #There's a 50/50 chance that either of the partner will take the other's last name
          if(mt_rand(1,100) >= 50)
          {
            #Here the person gets their partner's last name
            $this->town["Citizens"][$id]["Name"]["Last"] = $this->town["Citizens"][$partner]["Name"]["Last"];
          }
          else
          {
            #Here the partner gets the current person's last name
            $this->town["Citizens"][$partner]["Name"]["Last"] = $this->town["Citizens"][$id]["Name"]["Last"];
          }

          #If the random chance is smaller than the chance of getting children, the person and the partner's gender are not the same, they are of the same race
          if(mt_rand(1,100) <= $this->townChildrenChance && $this->town["Citizens"][$partner]["Gender"] != $this->town["Citizens"][$id]["Gender"] && $this->town["Citizens"][$partner]["Race"] == $this->town["Citizens"][$id]["Race"])
          {
            #Then set the seed to include the race of the family
            $this->setSeed($this->townSeed.$id.$partner.$this->town["Citizens"][$id]["Race"]);

            #Set the chance of children
            $chance = floor(mt_rand(1, 100));

            #Set the base chance
            $childrenChance = 1;

            #For each of the races in the race population variable
            foreach($racePopulations[$this->town["Citizens"][$partner]["Race"]] as $number => $childrenChances)
            {
              #If the chance of children is between the min and max chance
              if($chance >= $childrenChance && $chance <= ($childrenChance+$childrenChances-1))
              {
                #Set the number of children
                $childrenNumbers = $number;

                #break out of the loop
                break;
              }
              else
              {
                #If not, increase the chance and check again
                $childrenChance = $childrenChance + $childrenChances;
              }
            }

            #If the numbers is a range, split them
            $children = explode("-", $childrenNumbers);

            #If that is the case, get a random number between those two, else the first number
            if(isset($children[1]))
            {
              $number = floor(mt_rand($children[0], $children[1]));
            }
            else
            {
              $number = $children[0];
            }

            #If there's children
            if($number > 0) {
              #Get children (see getChildren function)
              $children = $this->getChildren($number, $this->town["Citizens"][$id]['Race']);

              #If there are children
              if($children) {

                #For each of the children
                foreach($children as $child)
                {
                  #Add the child to the parent's relationships
                  $this->town["Citizens"][$id]["Relationships"]["Children"][] = $child;
                  $this->town["Citizens"][$partner]["Relationships"]["Children"][] = $child;

                  #Check who is the father and who is the mother
                  if($this->town["Citizens"][$id]["Gender"] == "Male")
                  {
                    $this->town["Citizens"][$child]["Relationships"]["Father"] = $id;
                    $this->town["Citizens"][$child]["Relationships"]["Mother"] = $partner;
                  }
                  else
                  {
                    $this->town["Citizens"][$child]["Relationships"]["Mother"] = $id;
                    $this->town["Citizens"][$child]["Relationships"]["Father"] = $partner;
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  #This function returns a class, with each class having a certain percent of appearing
  private function getClass()
  {
    #Get the classes variables from variables.php (see includes)
    global $classes;

    #The chance for that person
    $classChance = floor(mt_rand(1,100));

    #The smallest chance, currently
    $minChance = 1;

    #For each of the classes, get their names and chances of a person to become that class
    foreach($classes as $className => $chance) {

      #If the chance is greater than the minimum chance and less than the high chance
      if($classChance >= $minChance && $classChance <= ($minChance + $chance - 1))
      {
        #Add class to class demographics
        $this->town["Class Demographics"][$className] = isset($this->town["Class Demographics"][$className]) ? $this->town["Class Demographics"][$className] + 1 : 1;

        #Return the class name
        return $className;

      }
      else
      {
        #Else, add the chance to the min chance and continue to loop
        $minChance += $chance;
      }
    }
  }

  public function createBusinessess()
  {
    #Get the population and business priority variables from variables.php (see includes)
    global $populations;
    global $businessPriority;

    #Create a new business generator class
    $businessGenerator = new business();

    #For each type of business
    for($i = 0; $i < count($populations[$this->townSize]["Businesses"]); $i++)
    {
      #Get the current business type in the loop
      $businessType = array_keys($populations[$this->townSize]["Businesses"])[$i];

      #Set the seed to take this into consideration
      $this->setSeed($this->townSeed.$businessType);

      #Set the business chance for the number of businessess in this town
      $chance = floor(mt_rand(1, 100));

      #Set base chance
      $businessChance = 1;

      #For each business type, get the number of them and the chance of that number to appear (0 has 50% of appearing, 1 has 25% of appearing, etc etc)
      foreach($populations[$this->townSize]["Businesses"][$businessType] as $number => $businessChances)
      {
        #If the business chance is within the range
        if($chance >= $businessChance && $chance <= ($businessChance + $businessChances - 1))
        {
          #We have found the number of businessess that should be in this town
          $businessNumbers = $number;
          break 1;
        }
        else
        {
          #Else, we increase the chance, and continue the loop
          $businessChance = $businessChance + $businessChances;
        }
      }

      #We check if the amount of businessess aren't a range (eg. 5-10 businessess, we get 5 and 10)
      $business = explode("-", $businessNumbers);

      #If that is the case, get a random number between those two, else the first number
      if(isset($business[1]))
      {
        $num = floor(mt_rand($business[0], $business[1]));
      }
      else
      {
        $num = $business[0];
      }

      #If there are any businessess
      if($num > 0)
      {
        #We loop for the amount of businessess there are
        for($j = 0; $j < $num; $j++)
        {
          #We add the businessess to the town array
          $this->town["Businesses"][$businessType][] = array();

          #Add number of businessess and the current business number to the seed for extra random
          $this->setSeed($this->townSeed.$businessType.$num.$j);

          #For each of the business class priority, get that priority
          foreach($businessPriority[$businessType] as $priority)
          {
            #Define array that we will put eligible citizens in
            $citizens = array();

            #Loop through all of the classes in the priory list
            foreach($priority as $class)
            {
              #Loop through all of the citizens
              for($k = 0; $k < count($this->town["Citizens"]); $k++)
              {
                #If the current citizen is of the current class and not employed anywhere
                if($this->town["Citizens"][$k]['Class'] == $class && $this->town["Citizens"][$k]['Profession'] == "")
                {
                  #add the citizen to the eligible array, as an array with the citizen's integer and the citizen info
                  $citizens[] = array($k, $this->town["Citizens"][$k]);
                }
              }

              #If this type of class gave us any eligible citizens
              if(count($citizens) > 0)
              {
                #Get random citizen from this arrays
                $owner = $citizens[round(mt_rand(0, count($citizens)-1))];
                break 1;
              }
            }
          }

          #Set the seed to the town seed, business type, number of businessess, current business, and the owner's name
          $businessGenerator->setSeed($this->townSeed.$businessType.$num.$j.$owner[1]["Name"]["First"].$owner[1]["Name"]["Middle"].$owner[1]["Name"]["Last"]);

          #Generate a business name with the business type variable as the function
          $businessName = $businessGenerator->$businessType($owner[1]);

          #Set the business' name and owner
          $this->town["Businesses"][$businessType][$j]["Name"] = $businessName;
          $this->town["Businesses"][$businessType][$j]["Owner"] = $owner[0];

          #Set the owner's profession
          $this->town["Citizens"][$owner[0]]["Profession"] = "Owner of ".$businessName;
        }
      }
    }
  }

  #This function returns a partner for a citizen
  private function getPartner($citizen)
  {
    #Declare eligible citizen array
    $citizens = array();

    #Loop through each citizen
    for($i = 0; $i < count($this->town["Citizens"]); $i++)
    {
      #Set the current looped citizen to a variable
      $currentCitizen = $this->town['Citizens'][$i];

      #If that person has no relationships, and is not the same as the citizen that's looking for a partner, and they share the same race
      if(count($currentCitizen['Relationships']) == 0 && $currentCitizen != $citizen && $currentCitizen["Race"] == $citizen["Race"])
      {
        #Add that person's ID to the citizen array
        $citizens[] = $i;
      }

    }

    #If there's any eligible citizens
    if(count($citizens) > 0)
    {
      #Select a random citizen ID from the array
      $citizen = $citizens[round(mt_rand(0, count($citizens)-1))];

      #Return that ID
      return $citizen;
    }
    else
    {
      #If there's no eligible citizens
      return false;
    }
  }

  #This function takes a number of children that you want, and their race, and returns their IDs
  private function getChildren($number, $race)
  {
    #Declare eligiable citizen arrays
    $allChildren = array();
    $children = array();

    #For each citizen
    for($i = 0; $i < count($this->town["Citizens"]); $i++)
    {
      #Set the current citizen variable
      $currentChild = $this->town['Citizens'][$i];

      #If the person has no relationships (eg, no parents or spouses), the person is a commoner, and shares the parent's race
      if(count($currentChild['Relationships']) == 0 && $currentChild['Class'] == "Commoner" && $race == $currentChild['Race'])
      {
        #Add that person to the array
        $allChildren[] = $i;
      }
    }

    #If there's any eligible children
    if(count($allChildren) > 0)
    {
      #Loop number of times equal to the requested children
      for($i = 0; $i < $number; $i++)
      {
        #Double check that the arrays still have citizens in it
        if(count($allChildren) > 0)
        {
          #Get a random child's ID
          $selectedChild = round(mt_rand(0, count($allChildren)-1));

          #Add that to the eligible array of children
          $children[] = $allChildren[$selectedChild];

          #Remove that child from the eligible children
          array_splice($allChildren, $selectedChild, 1);
        }
      }

      #When done, return the children
      return $children;
    }
    else
    {
      #If there's no eligible children
      return false;
    }
  }

  #This function takes an array of names, and returns a combined string
  private function getFullName($nameArray)
  {
    #If the first name exists, set the first name
    if($nameArray["First"])
    {
      $name = $nameArray["First"];
    }

    #If the middle name exists, add it to the variable
    if($nameArray["Middle"])
    {
      $name .= " " . $nameArray["Middle"];
    }

    #If the last name exists, add it to the variable
    if($nameArray["Last"])
    {
      $name .= " " . $nameArray["Last"];
    }

    return $name;
  }
}

?>