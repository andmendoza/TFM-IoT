<?php
namespace App\Models;
use App\Libraries\DatabaseConnector;
class EmpleadoModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->empleado;
    }
    function getEmpleados($limit = 5) {
        try {
            $cursor = $this->collection->find([],['limit' => $limit]);
            $empleado = $cursor->toArray();

            return $empleado;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
    function getEmpleadosByClient($cliente_id,$limit = 100) {
        try {
            $cursor = $this->collection->find(['cliente_id' => new \MongoDB\BSON\ObjectId($cliente_id)], ['limit' => $limit]);
            $empleado = $cursor->toArray();

            return $empleado;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
}