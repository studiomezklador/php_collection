<?php
require_once 'RecursiveIt.php';
$arr = array(0, 1, 2, 3, 4, 5 => array(10, 20, 30), 6, 7, 8, 9 => array(1, 2, 3));
$mri = new RecursiveIt($arr);

foreach ($mri as $c => $v) {
    if ($mri->hasChildren()) {
        echo "$c has children: <br />";
        $mri->getChildren();
    } else {
        echo "$v <br />";
    }

}
?>