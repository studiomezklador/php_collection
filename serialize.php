<?php
/**
* File : serialize.php   
**/

$vehicules = [
    ["marque" => "renault", "modele" => "R5", "puissance" => "4 CV", "couleur" => "beige", "portes" => 3, "prix" => 1500],
    ["marque" => "peugeot", "modele" => "205", "puissance" => "5 CV", "couleur" => "rouge", "portes" => 3, "prix" => 2500],
    ["marque" => "citröen", "modele" => "DS3", "puissance" => "6 CV", "couleur" => "noire", "portes" => 5, "prix" => 5500]
];

$z = urlencode(serialize($vehicules));

var_dump($z);

$arr = unserialize(urldecode($z));

var_dump($arr);