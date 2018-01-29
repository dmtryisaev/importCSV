<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 28.01.2018
 * Time: 22:43
 */

/*
 * Модель магазина
 */
class shop {

    private $id; //integer

    private $title; //string

    private $regionId; //integer

    private $city; //string

    private $address; //string

    private $userId; //integer


    private function setId($id) {
        $this->id = $id;
    }


    private function getId() {
        return $this->id;
    }


    private function setTitle($title) {
        $this->title = $title;
    }


    private function getTitle() {
        return $this->title;
    }


    private function setRegionId($regionId) {
        $this->regionId = $regionId;
    }


    private function getRegionId() {
        return $this->regionId;
    }


    private function setCity($city) {
        $this->city = $city;
    }


    private function getCity() {
        return $this->city;
    }


    private function setAddress($address) {
        $this->address = $address;
    }


    private function getAddress() {
        return $this->address;
    }


    private function setUserId($userId) {
        $this->userId = $userId;
    }


    private function getUserId() {
        return $this->userId;
    }


    /*
     * получение свойств
     */
    public function __get($property)
    {
        switch ($property)
        {
            case 'id':
                return $this->getId();
                break;
            case 'TITLE':
                return $this->getTitle();
                break;
            case 'REGION_ID':
                return $this->getRegionId();
                break;
            case 'CITY':
                return $this->getCity();
                break;
            case 'ADDR':
                return $this->getAddress();
                break;
            case 'USER_ID':
                return $this->getUserId();
                break;
            default:
                throw new Exception('ERROR INVALID PROPERTY');
        }
    }


    /**
     * Установка свойств
     * @param $property
     * @param $value
     * @throws Exception
     */
    public function __set($property, $value)
    {
        switch ($property)
        {
            case 'id':
                $this->setId($value);
                break;
            case 'TITLE':
                $this->setTitle($value);
                break;
            case 'REGION_ID':
                $this->setRegionId($value);
                break;
            case 'CITY':
                $this->setCity($value);
                break;
            case 'ADDR':
                $this->setAddress($value);
                break;
            case 'USER_ID':
                $this->setUserId($value);
                break;
            default:
                throw new Exception('ERROR INVALID PROPERTY');
        }
    }

    /*
     * Сохранение в БД
     */
    public function save($host, $database, $collection) {

        if (!$this->validate()) {
            return;
        };

        $manager = new MongoDB\Driver\Manager($host);
        $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 100);
        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->insert([
            'TITLE' => (string) $this->title,
            "REGION_ID" => (int) $this->regionId,
            "CITY" => (string) $this->city,
            "ADDR" => (string) $this->address,
            "USER_ID" => (int) $this->userId
        ]);
        $manager->executeBulkWrite($database . '.' . $collection, $bulk, $writeConcern);
    }

    /*
     * Проверка свойств
     */
    private function validate() {

        // не пустые
        if(
            empty($this->getTitle()) ||
            empty($this->getRegionId()) ||
            empty($this->getCity()) ||
            empty($this->getAddress()) ||
            empty($this->getUserId())
        ) {
            throw new Exception('EMPTY PROPERTY');
        }

        // тип
        if (
            !is_string($this->getTitle()) ||
            !is_numeric($this->getRegionId()) ||
            !is_string($this->getCity()) ||
            !is_string($this->getAddress()) ||
            !is_numeric($this->getUserId())
        ) {
            throw new Exception('INVALID PROPERTY DATA');
        }

        return true;
    }
}

