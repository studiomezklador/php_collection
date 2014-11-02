<h1>Multi-array</h1>
<?php
// multi-array

$a = [
    [
        'id' => 1234,
        'username' => 'lala',
        'pwd' => 'azerty'
    ],
    [
        'id' => 4567,
        'username' => 'lolo',
        'pwd' => 'tyuiop'
    ],
    [
        'id' => 6789,
        'username' => 'lili',
        'pwd' => 'qsdfgh'
    ]
];

var_dump($a);
?>
<hr />
<h1>array_column()</h1>
<?php 
$get_username = array_column($a, 'username');
var_dump($get_username);
?>
<hr />
<h1>array_column() with assoc</h1>
<?php
$get_id_pwd = array_column($a, 'pwd', 'id');
var_dump($get_id_pwd);
?>
<hr />
<h1>array_keys(), inside a foreach loop</h1>
<?php
foreach($a as $k)
{
    $get_subkeys = array_keys($k);
}

var_dump($get_subkeys);
