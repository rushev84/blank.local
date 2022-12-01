<?php

class MyIBlock
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    // Возвращает все инфоблоки данного сайта.
    public static function getAll(): array
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

    // Возвращает случайное слово из массива слов.
    public function getRandWord()
    {
        $words = ['rand_word1', 'rand_word2', 'rand_word3', 'rand_word4', 'rand_word5'];
        return $words[rand(0, count($words) - 1)];
    }

    public function getRandNumber()
    {
        return rand(1, 1000);
    }

    // Принимает id инфоблока, код свойства инфоблока (свойство должно быть типа "список").
    // Возвращает случайный элемент из списка для данного свойства.
    public function getRandListItem(string $propertyCode): array
    {
        $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$this->id, "CODE"=> $propertyCode));

        $enums = [];

        while($enum_fields = $property_enums->GetNext())
        {
           $enums[] = $enum_fields;
        }

        $enumIds = array_map(fn($enum) => $enum['ID'], $enums);

        $randEnum = $enumIds[array_rand($enumIds)];

        return ["VALUE" => $randEnum];
    }

    // Возвращает массив описаний свойств данного инфоблока (id, имя, код, тип).
    public function getProperties(): array
    {
        $properties = CIBlockProperty::GetList(array("sort" => "asc", "name" => "asc"), array("ACTIVE" => "Y", "IBLOCK_ID" => $this->id));

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
//        dd($this->id);
        $allProperties = $this->getProperties();
        return array_filter($allProperties, fn($property) => in_array($property['CODE'], $request['properties']));
    }

    // Принимает id инфоблока и свойство данного инфоблока.
    // Возвращает значение свойства, сгенерированное случайным образом. // тип пока непонятен
    public function getPropertyValue(array $property)
    {
        /* PROPERTY_TYPE - тип свойства:
            S - строка
            N - число
            L - список
            F - файл
            G - привязка к разделу
            E - привязка к элементу
        */
        switch ($property['PROPERTY_TYPE']) {
            case 'S':
                return $this->getRandWord();
            case 'N':
                return $this->getRandNumber();
            case 'L':
                return $this->getRandListItem($property['CODE']);
            default:
                return 'other type';
        }
    }
}