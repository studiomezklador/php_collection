<?php
/**
* File : versus.php   
**/

$array = array(
    [
    'brand' => 'ford',
    'model' => 'F150',
    'color' => 'blue',
    'options' => array('radio' => 'satellite')],
    [
        'brand' => 'chevrolet',
        'model' => 'camara',
        'color' => 'red',
        'options' => array('radio' => 'cdplayer')]
);

$recursiveIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
var_dump(iterator_to_array($recursiveIterator, true));

$iterator = new IteratorIterator(new ArrayIterator($array));
var_dump(iterator_to_array($iterator,true));

//$iterator = new ArrayIterator($array);
//var_dump(iterator_to_array($iterator,true));

$search = ["ford", "color"];
echo '<ul>';
foreach($recursiveIterator as $k)
{
    if ($k == $search[0])
    {
        echo "<li>{$recursiveIterator[$search[1]]}</li>";
    }
}
echo '</ul>';

