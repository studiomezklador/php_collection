<?php
/**
* File : extract_kv.php   
**/
$park = [
    ["marque" => "renault", "modele" => "R5", "puissance" => "4 CV", "couleur" => "beige", "portes" => 3, "prix" => 1500],
    ["marque" => "peugeot", "modele" => "205", "puissance" => "5 CV", "couleur" => "rouge", "portes" => 3, "prix" => 2500],
    ["marque" => "citröen", "modele" => "DS3", "puissance" => "6 CV", "couleur" => "noire", "portes" => 5, "prix" => 5500]
];

var_dump(is_array($park[0]));
extract($park, EXTR_PREFIX_INVALID, "vehicule");

$tot = count($park);
$i = 0;



    $parking[0] = new stdClass();
    $parking[0]->vehicule = $vehicule_0;
$parking[1] = new stdClass();
$parking[1]->vehicule = $vehicule_1;
$parking[2] = new stdClass();
$parking[2]->vehicule = $vehicule_2;


var_dump($parking);