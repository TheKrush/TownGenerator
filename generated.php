<?php

include("generation_c.php");

$town = new generation($_POST);
$town->getPopulationNumbers();
$town->createPopulation();
$town->createBusinessess();
$town->printSettings();
$town->printTown();

?>