<?php
namespace App\Models;
use App\Libraries\DatabaseConnector;
class DeviceModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->device;
    }
    function getDevices($limit = 100) {
        try {
            $cursor = $this->collection->find([], ['limit' => $limit]);
            $clientes = $cursor->toArray();

            return $clientes;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
    function getDevice($id) {
        try {
            $device = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            return $device;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }
    function getDeviceSerieExist($serie) {
        try {
            $device = $this->collection->findOne(['serie' => $serie]);

            return $device;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }
    function insertDevice($nombre, $ubicacion, $serie) {
        try {
            $insertOneResult = $this->collection->insertOne([
                'nombre' => $nombre,
                'ubicacion' => $ubicacion,
                'serie' => $serie,
                'estado' => '1',
            ]);

            if($insertOneResult->getInsertedCount() == 1) {
                return true;
            }

            return false;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while creating a book: ' . $ex->getMessage(), 500);
        }
    }
}