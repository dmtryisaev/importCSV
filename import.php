<?php
require_once("model/shop.php");

//Настройки
$host = "mongodb://localhost:27017";
$database = "TestDatabase";
$collection = "TestCollection";
$fieldSeparator = ",";
$csvFilePath = $argv[1];

if(!file_exists($csvFilePath)) {
    die("File not found.");
}

$file = fopen($csvFilePath, "r");

//Первоя строка CSV файла с именами полей
$params = fgetcsv($file, 1000, $fieldSeparator);

$stringCounter = 1;

while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    $stringCounter++;
    try {
        $shop = new shop;

        foreach ($data as $key => $value) {
            $shop->__set($params[$key], iconv("WINDOWS-1251", "UTF-8", $value));
        }

        $shop->save($host, $database, $collection);
    } catch (Exception $e) {
        echo("Warning: ".$e->getMessage()) . " on " . $stringCounter;
    }
}


