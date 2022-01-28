<?php

/**
 * Dictionnaire
 */
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$dico = explode("\n", $string);

// part 1
echo "le dictionnaire contient : " . count($dico) . ' mots. <br>';

// part 2
$words15 = 0;
foreach ($dico as $word) {
    if (strlen($word) === 15) {
        $words15++;
    }
}
echo $words15 . " mots font exactement 15 caractères. <br>";

// part 3
$letterW = 0;
foreach ($dico as $word) {
    if (strpos($word, "w") !== false) {
        $letterW++;
    }
}
echo $letterW . " mots contienne la lettre w. <br>";

// part 4
$letterQ = 0;
foreach ($dico as $word) {
    if (strpos($word, "q") === (strlen($word) - 1)) {
        $letterQ++;
    }
}
echo $letterQ . " mots finissent par la lettre q. <br>";


/**
 * Liste de films
 */
$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut = json_decode($string, true);
$top = $brut["feed"]["entry"];

// part 1
for ($i = 0; $i < 10; $i++){
    echo ($i + 1) . " " . $top[$i]['im:name']['label'] . "<br>";
}

// part 2
$nb = 0;
foreach ($top as $value) {
    if ($value['im:name']['label'] !== "Gravity") {
        $nb++;
    } else {
        break;
    }
}

echo "Gravity est classé " . ($nb + 1) . 'ème <br>';

// part 3
foreach ($top as $value) {
    if ($value['im:name']['label'] === "The LEGO Movie") {
        echo $value['im:artist']['label'] . '<br>';
    }
}

// part 4
$nb = 0;
foreach ($top as $value) {
    if (strtotime($value['im:releaseDate']['label']) < strtotime('01/01/2000')) {
        $nb++;
    }
}

echo $nb . ' films sont sortis avant 2000 <br>';

// part 5
$mostRecent = 0;
$lessRecent = 2025;

foreach ($top as $value) {
    $year = explode('-', $value['im:releaseDate']['label']);

    if ((int)$year[0] > $mostRecent) {
        $mostRecent = $year[0];
    }

    if ((int)$year[0] < $lessRecent) {
        $lessRecent = $year[0];
    }

}

echo 'Le film le plus récent est sorti en : ' . $mostRecent . ' et le moins récent en : ' . $lessRecent . '<br>';

// part 6
$categories = [];
foreach ($top as $value) {
    array_push($categories, $value['category']['attributes']["label"]);
}

$categoriesList = array_values(array_unique($categories));
$occurrences = [];

foreach ($categoriesList as $value) {
    $occurrence = 0;
    foreach ($categories as $item) {
        if ($item === $value) {
            $occurrence++;
        }
    }
    array_push($occurrences, $occurrence);
}

asort($occurrences);
$index = array_key_last($occurrences);

echo 'La catégorie la plus représentée est : ' . $categoriesList[$index] . '<br>';

// part 7
$rea = [];
foreach ($top as $value) {
    array_push($rea, $value['im:artist']["label"]);
}

$reaList = array_values(array_unique($rea));
$occurrences = [];

foreach ($reaList as $value) {
    $occurrence = 0;
    foreach ($rea as $item) {
        if ($item === $value) {
            $occurrence++;
        }
    }
    array_push($occurrences, $occurrence);
}

asort($occurrences);
$index = array_key_last($occurrences);

echo 'La catégorie la plus représentée est : ' . $reaList[$index] . '<br>';

// part 8
// on ne peut pas tous les louer ?
$cost = 0;

for($i = 0; $i < 10; $i++) {
    $cost += $top[$i]['im:price']['attributes']['amount'];
}

echo "le top 10 coute " . $cost ."$ à l'achat <br>";


$cost = 0;

for($i = 0; $i <= 10; $i++) {
    if (isset($top[$i]['im:rentalPrice']['attributes']['amount'])) {
        $cost += $top[$i]['im:rentalPrice']['attributes']['amount'];
    }

}

echo "le top 10 coute " . $cost ."$ à la location <br>";

// part 9
$months = [];
foreach ($top as $value) {
    $month = explode('-', $value['im:releaseDate']['label']);
    array_push($months, $month[1]);
}

$monthsList = array_values(array_unique($months));
$occurrences = [];

foreach ($monthsList as $value) {
    $occurrence = 0;
    foreach ($months as $item) {
        if ($item === $value) {
            $occurrence++;
        }
    }
    array_push($occurrences, $occurrence);
}

asort($occurrences);

$index = array_key_last($occurrences);

echo 'Le mois qui comporte le plus de sorties : ' . $monthsList[$index] . '<br>';

// part 10
$lowPrices = [];
foreach ($top as $value) {
    $newValue = explode('$', $value['im:price']['label']);
    $lowPrices[$value['im:name']['label']] = $newValue[1];
}

asort($lowPrices);
$a = 0;

foreach ($lowPrices as $key => $value) {
    if($a < 10) {
        echo $key . ' pour ' . $value . '<br>';
        $a++;
    }
}
