<?php
namespace App\Models;
use App\Libraries\DatabaseConnector;
class AsignacionModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->asignacion;
    }
    function getAsignacionesByClient($cliente_id){
        try {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'device',
                        'localField' => 'device_id',
                        'foreignField' => '_id',
                        'as' => 'device'
                    ]
                ],
                [
                    '$unwind' => '$device'
                ],
                [
                    '$lookup' => [
                        'from' => 'empleado',
                        'localField' => 'empleado_id',
                        'foreignField' => '_id',
                        'as' => 'empleado'
                    ]
                ],
                [
                    '$unwind' => '$empleado'
                ],
                [
                    '$match' => [
                        'empleado.cliente_id' => new \MongoDB\BSON\ObjectId($cliente_id)
                    ]
                ]
            ];
            $cursor = $this->collection->aggregate($pipeline);
            $asignaciones = $cursor->toArray();

            return $asignaciones;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
}