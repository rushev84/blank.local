<?php
require_once 'MyGenerator.php';
$generator = new MyGenerator();

$request = [
    'iblock_id' => 284,
    'fields' => [
        'active' => true,
        'name' => true,
        'preview_text' => false,
        'detail_text' => true
    ],
    'properties' => [
        'INSTRUMENT_TYPE' => true,
        'DESCRIPTION' => false,
        'PURPOSE' => true
    ]
];


$newElements = [];

$randWords = ['rand_word1', 'rand_word2', 'rand_word3', 'rand_word4', 'rand_word5'];
$propertyValues = ['INSTRUMENT_TYPE', 'DESCRIPTION', 'PURPOSE'];

for ($i = 1; $i <= 4; $i++) {
    $randNumber = rand();
    $randWord = $randWords[rand(0, count($randWords) - 1)];

    $element = [
        'iblock_id' => 284,
        'name' => $randWord,
        'code' => "code_{$randNumber}",
        'property_values' => [],
        'preview_text' => $randWord,
        'detail_text' => $randWord
    ];

    foreach ($propertyValues as $key => $value) {
        $element['property_values'][$value] = $randWord;
    }

    $newElements["el{$i}"] = $element;

}

//dd($newElements);


//echo '<pre>'; print_r( $el ); echo'</pre>';

foreach ($newElements as $element) {

    $el = new CIBlockElement;

    $PROP = array();

    foreach ($element['property_values'] as $key => $value) {
        $PROP[$key] = $value;
    }

    $arLoadProductArray = array(
        "IBLOCK_ID" => $element['iblock_id'],
        "NAME" => $element['name'],
        "CODE" => $element['code'],
        "PROPERTY_VALUES" => $PROP,
        "PREVIEW_TEXT" => $element['preview_text'],
        "DETAIL_TEXT" => $element['detail_text'],

        "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
        "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
        "ACTIVE" => "Y",            // активен
    );

    $PRODUCT_ID = $el->Add($arLoadProductArray);

    if ($PRODUCT_ID) {
        echo "New ID: " . $PRODUCT_ID;
    } else {
        echo "Error: " . $el->LAST_ERROR;
    }
}



