<?php require 'Collection.php'; ?>
<?php require 'RecursiveIt.php'; ?>
<?php
$park = [
   "roger" =>  ["marque" => "Renault", "modele" => "R5", "puissance" => "4 CV", "couleur" => "beige"],
    "giselle" => ["marque" => "Peugeot", "modele" => "205", "puissance" => "5 CV", "couleur" => "rouge"],
    "charles" => ["marque" => "Citröen", "modele" => "DS", "puissance" => "6 CV", "couleur" => "noire"]
];
$garage = new Collection($park);
$models = $garage->get("modele");

var_dump($models);
var_dump($garage->first("roger"));
//var_dump($garage->listing("marque"));

$test = new objCollection($park['roger']);
var_dump($test->all());
var_dump($test->getbyMarque(), $test->getbyModele(), $test->getbyPuissance(), $test->hasCouleur());
//var_dump($test->methods);
var_dump(key($park));
die();
//$garage = new RecursiveIt($park);
//
//foreach($garage as $it_k => $it_v)
//{
//    if($garage->hasChildren())
//    {
//        $garage->getChildren();
//    } else {
//        $garage->$it_v;
//    }
//}
//var_dump($garage); die();
//var_dump($garage->listing("charles.couleur"));
//die();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Collection Class</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <h1>Collection Class</h1>
    <?php $tab = [1,2,3]; ?>
    <?php $z = new Collection($tab); ?>
    <h4>Insertion d'une clé (qui devient la numéro 3) avec la valeur : <?php $z[3] = 4; ?></h4>
    <p></p><?= $z->get(3); ?></p>
    <hr>
    <h4>Loop with Each (IteratorArray SPL)</h4>
    <ul><?php
        foreach ($z as $k => $v) {
            if ($k == 3)
            {
                echo "<li><strong>$k -> $v</strong></li>";
            } else {
                echo "<li>$k -> $v</li>";
            }
        }
        ?></ul>
    <hr>

    <?php
    $tab_2 = [
        ["name" => "Albert", "note" => 20],
        ["name" => "Julie", "note" => 18],
        ["name" => "Lola", "note" => 14],
        ["name" => "Simon", "note" => 7]
    ];
    $col = new Collection($tab_2);
    ?>
    <h4>listing("key", "value") method : récupération d'un tableau avec clé /valeur/h4>
    <?php var_dump($col->listing("name", "note")); ?>
    <hr>
    <h4>Same way, with extract("note") method : récupération d'un tableau avec juste els valeurs d'une clé</h4>
    <?php var_dump($col->extract("note")); ?>
    <hr>
    <h4>Join Method (implode) : permet de joindre les valeurs d'une clé dans une seule variable, avec séparateur <em>(String)</em></h4>
    <p><?php var_dump($col->extract("note", true)->join(' / ')); ?></p>
    <hr>
    <h4>MIN & MAX methods : ici, on code $obj->extract("clé", true)->min()</h4>
    <p><?php var_dump($col->extract("note", true)->min()); ?></p>
    <p><?php var_dump($col->max("note")); // it's possible to just inject the KEY into the method directly (2-way to define) ?></p>
    <hr>
    <h4>First() & last() methods : ramener clé/valeur du premier et dernier élément de l'objet</h4>
    <p><?php var_dump($col->first()); ?></p>
    <p><?php var_dump($col->last()); ?></p>
    <hr>
    <h4>length() methods : nombre total d'éléments dans l'objet</h4>
    <p><?php var_dump($col->length()); ?></p>
    <hr/>
    <h4>toJson() Method : tableau jSon (sortie directe, sans <em>var_dump()</em> )</h4>
    <pre><p><?= $col->toJson(); ?></p></pre>
    <hr/>
    <h4>orderBy Method</h4>
    <h5>orderBy("note", true) -> inversion du classement (décroissant)</h5>
    <p><?php var_dump($col->orderBy("note", true)); ?></p>
    <h5>orderBy("name") -> classement croissant, sur <em>String</em></h5>
    <p><?php var_dump($col->orderBy("name")); ?></p>
        <hr/>
        <h4>digData Method</h4>
        <h5></h5>
        <p><?php var_dump($col->digData("Albert", "note")); ?></p>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</body>
</html>