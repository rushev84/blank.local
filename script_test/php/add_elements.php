<?php
require_once 'MyGenerator.php';
$generator = new MyGenerator();

$request = $_POST['request'];

$chosenProperties = $generator->getOnlyChosenProperties($request);

// добавляем элементы
for ($i = 1; $i <= $request['COUNT']; $i++) {
    $randNumber = rand();

    $el = new CIBlockElement;

    // общий массив для полей и свойств
    $arLoadProductArray = array(
        "IBLOCK_ID" => $request['IBLOCK_ID'],
        "NAME" => $generator->getRandWord(),
        "CODE" => "code_{$randNumber}",

        "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    );


    // добавляем поля
    in_array('ACTIVE', $request['fields']) ? $arLoadProductArray['ACTIVE'] = 'Y' : $arLoadProductArray['ACTIVE'] = 'N';

    if (in_array('PREVIEW_TEXT', $request['fields'])) {
        $arLoadProductArray['PREVIEW_TEXT'] = $generator->getRandWord();
//        dd($generator->getRandWord());
    }

    if (in_array('DETAIL_TEXT', $request['fields'])) {
        $arLoadProductArray['DETAIL_TEXT'] = $generator->getRandWord();
    }

    // создаём свойства для $arLoadProductArray
    $PROP = [];

    foreach ($chosenProperties as $property) {
        $PROP[$property['CODE']] = $generator->getPropertyValue($request['IBLOCK_ID'], $property);
    }

    // добавляем свойства в $arLoadProductArray (если они есть)
    if (!empty($PROP)) {
        $arLoadProductArray['PROPERTY_VALUES'] = $PROP;
    }

//    dd($PROP);

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


