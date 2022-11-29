<?php
require_once 'MyGenerator.php';
$generator = new MyGenerator();

$request = [
    'iblock_id' => 284,
    'count' => 3,
    'fields' => [
//        'active',
        'name',
        'preview_text',
//        'detail_text'
    ],
    'properties' => [
//        'INSTRUMENT_TYPE',
        'DESCRIPTION',
        'PURPOSE'
    ]
];


$words = ['rand_word1', 'rand_word2', 'rand_word3', 'rand_word4', 'rand_word5'];

for ($i = 1; $i <= $request['count']; $i++) {

    $el = new CIBlockElement;

    $randNumber = rand();
    $randWord = $words[rand(0, count($words) - 1)];

    $PROP = array();

    foreach ($request['properties'] as $property) {
        $PROP[$property] = $randWord;
    }

    $arLoadProductArray = array(
        "IBLOCK_ID" => $request['iblock_id'],
        "NAME" => $randWord,
        "CODE" => "code_{$randNumber}",

        "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    );


    if (in_array('preview_text', $request['fields'])) {
        $arLoadProductArray['PREVIEW_TEXT'] = $randWord;
    }

    if (in_array('detail_text', $request['fields'])) {
        $arLoadProductArray['DETAIL_TEXT'] = $randWord;
    }

    if (!empty($PROP)) {
        $arLoadProductArray['PROPERTY_VALUES'] = $PROP;
    }

    in_array('active', $request['fields']) ?  $arLoadProductArray['ACTIVE'] = 'Y' : $arLoadProductArray['ACTIVE'] = 'N';

//    dd($arLoadProductArray);

    $PRODUCT_ID = $el->Add($arLoadProductArray);

    if ($PRODUCT_ID) {
        echo "New ID: " . $PRODUCT_ID;
    } else {
        echo "Error: " . $el->LAST_ERROR;
    }
}



