<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

class MyGenerator
{
    public function __construct()
    {
        CModule::IncludeModule("iblock");
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

            while($ar_res = $res->Fetch()) {
                $iblocks[] = [
                    'id' => $ar_res['ID'],
                    'name' => $ar_res['NAME']
                ];
            }

            return $iblocks;
        }
    }

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


    public function getProperties(int $id): array
    {
        $arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");

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

        while($ob = $res->GetNextElement())
        {
            $arProperties = $ob->GetProperties();
        }

        $properties = array_map(fn($property) =>
                array_filter($property, fn($key) => $key === 'ID' || $key === 'NAME', ARRAY_FILTER_USE_KEY),
            $arProperties);

        return $properties;
    }
}