<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

class MyGenerator
{
    public function __construct()
    {
        CModule::IncludeModule("iblock");
    }

    // Возвращает случайное слово из массива слов.
    public function getRandWord()
    {
        $words = ['rand_word1', 'rand_word2', 'rand_word3', 'rand_word4', 'rand_word5'];
        return $words[rand(0, count($words) - 1)];
    }


    public function getIblocks(): array
    {

        if (CModule::IncludeModule("iblock")) {
            $res = \CIBlock::GetList(
                array(
                    "NAME" => "ASC"
                ),
                array(
                    "ACTIVE" => "Y"
                ), true
            );

            $iblocks = [];

            while ($ar_res = $res->Fetch()) {
                $iblocks[] = [
                    'id' => $ar_res['ID'],
                    'name' => $ar_res['NAME']
                ];
            }

            return $iblocks;
        }
    }

    // Принимает id инфоблока.
    // Возвращает массив описаний свойств данного инфоблока (id, имя, код, тип).
    public function getProperties(int $iblockId): array
    {
        $properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $iblockId));

        $props = [];

        while ($prop_fields = $properties->GetNext()) {
            $props[] = $prop_fields;
        }

        return array_map(fn($property) => array_filter($property, fn($key) => $key === 'ID' || $key === 'NAME' || $key === 'PROPERTY_TYPE' || $key === 'CODE', ARRAY_FILTER_USE_KEY),
            $props);
    }

    // Принимает запрос, полученный со страницы выбора свойств.
    // Возвращает свойства инфоблока, отфильтрованные в соответствии с запросом.
    public function getOnlyChosenProperties(array $request): array
    {
        $allProperties = $this->getProperties($request['IBLOCK_ID']);
        return array_filter($allProperties, fn($property) => in_array($property['CODE'], $request['properties']));
    }

    // Принимает свойство инфоблока.
    // Возвращает значение свойства, сгенерированное случайным образом. // тип пока непонятен
    public function getPropertyValue(array $property)
    {
        return $this->getRandWord();
    }

    // удалить из финальной версии
    public function getFields(int $id)
    {
        $arSelect = array("ID", "NAME", "IBLOCK_ID", "DETAIL_TEXT", "DETAIL_TEXT_TYPE");

        $arFilter = array(
            "IBLOCK_ID" => $id,
            "ACTIVE_DATE" => "Y",
            "ACTIVE" => "Y"
        );

        $res = CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            array(
                "nPageSize" => 50
            ),
            $arSelect
        );


        $element = $res->GetNextElement();

//        echo '<pre>'; print_r( $element ); echo'</pre>';

//        $fields = [];
//
//        while($ob = $res->GetNextElement())
//        {
//            $arFields = $ob->GetFields();
//            $fields[] = $arFields;
//        }
//
//        return $fields;
    }

    // удалить из финальной версии
    public function getProperties_old(int $id): array
    {
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*");

        $arFilter = array(
            "IBLOCK_ID" => $id,
            "ACTIVE_DATE" => "Y",
            "ACTIVE" => "Y",
        );

        $res = CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            array(
                "nPageSize" => 50
            ),
            $arSelect
        );

        while ($ob = $res->GetNextElement()) {
            $arProperties = $ob->GetProperties();
        }

        $properties = array_map(fn($property) => array_filter($property, fn($key) => $key === 'ID' || $key === 'NAME', ARRAY_FILTER_USE_KEY),
            $arProperties);

        dd($properties);

        return $properties;
    }
}