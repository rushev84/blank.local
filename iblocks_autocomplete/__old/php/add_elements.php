<?php
require_once 'MyGenerator.php';
$generator = new MyGenerator();

$request = $_POST['request'];


function getRandWord()
{
    $words = ['rand_word1', 'rand_word2', 'rand_word3', 'rand_word4', 'rand_word5'];
    return $words[rand(0, count($words) - 1)];
}


for ($i = 1; $i <= $request['COUNT']; $i++) {

    $el = new CIBlockElement;

    $randNumber = rand();

    $PROP = array();

    foreach ($request['properties'] as $property) {
        $PROP[$property] = getRandWord();
    }

    $arLoadProductArray = array(
        "IBLOCK_ID" => $request['IBLOCK_ID'],
        "NAME" => getRandWord(),
        "CODE" => "code_{$randNumber}",

        "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    );


    if (in_array('PREVIEW_TEXT', $request['fields'])) {
        $arLoadProductArray['PREVIEW_TEXT'] = getRandWord();
    }

    if (in_array('DETAIL_TEXT', $request['fields'])) {
        $arLoadProductArray['DETAIL_TEXT'] = getRandWord();
    }

    if (!empty($PROP)) {
        $arLoadProductArray['PROPERTY_VALUES'] = $PROP;
    }

    in_array('ACTIVE', $request['fields']) ? $arLoadProductArray['ACTIVE'] = 'Y' : $arLoadProductArray['ACTIVE'] = 'N';

//    dd($arLoadProductArray);

    $PRODUCT_ID = $el->Add($arLoadProductArray);

    if ($PRODUCT_ID) {
        echo "Создан новый элемент с ID = " . $PRODUCT_ID;
        echo "<br>";
    } else {
        echo "Error: " . $el->LAST_ERROR;
    }
}

?>

<!--<span>--><? //= $request ?><!--</span>-->


