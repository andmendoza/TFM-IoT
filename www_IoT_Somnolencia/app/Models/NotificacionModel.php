<?php

namespace App\Models;

use App\Libraries\DatabaseConnector;

class NotificacionModel
{
    private $collection;

    function __construct()
    {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->notificaciones;
    }
    function getNotificacionesDesdeHasta($empleado_id, $desde, $hasta)
    {
        $startDate = new \MongoDB\BSON\UTCDateTime(strtotime($desde) * 1000); // Fecha de inicio del rango
        $endDate = new \MongoDB\BSON\UTCDateTime(strtotime($hasta) * 1000); //
        try {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'tracking',
                        'localField' => 'tracking_id',
                        'foreignField' => '_id',
                        'as' => 'tracking'
                    ]
                ],
                ['$unwind' => '$tracking'],
                [
                    '$lookup' => [
                        'from' => 'asignacion',
                        'localField' => 'tracking.asignacion_id',
                        'foreignField' => '_id',
                        'as' => 'asignacion'
                    ]
                ],
                ['$unwind' => '$asignacion'],
                [
                    '$lookup' => [
                        'from' => 'empleado',
                        'localField' => 'asignacion.empleado_id',
                        'foreignField' => '_id',
                        'as' => 'empleado'
                    ]
                ],
                ['$unwind' => '$empleado'],
                [
                    '$lookup' => [
                        'from' => 'device',
                        'localField' => 'asignacion.device_id',
                        'foreignField' => '_id',
                        'as' => 'device'
                    ]
                ],
                ['$unwind' => '$device'],
                [
                    '$match' => [
                        'asignacion.empleado_id' => new \MongoDB\BSON\ObjectId($empleado_id),
                        'tracking.fecha' => [
                            '$gte' => $startDate,
                            '$lte' => $endDate
                        ]
                    ]
                ],    
                [
                    '$group' => [
                        '_id' => [
                            'fecha' => ['$dateToString' => ['format' => "%Y-%m-%d", 'date' => '$tracking.fecha']],
                        ],
                        'count' => ['$sum' => 1]
                    ]
                ]
            ];
            $cursor = $this->collection->aggregate($pipeline, []);
            $notificaciones = $cursor->toArray();

            return $notificaciones;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }

    function getNotificacionesAll()
    {
        try {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'tracking',
                        'localField' => 'tracking_id',
                        'foreignField' => '_id',
                        'as' => 'tracking'
                    ]
                ],
                ['$unwind' => '$tracking'],
                [
                    '$lookup' => [
                        'from' => 'asignacion',
                        'localField' => 'tracking.asignacion_id',
                        'foreignField' => '_id',
                        'as' => 'asignacion'
                    ]
                ],
                ['$unwind' => '$asignacion'],
                [
                    '$lookup' => [
                        'from' => 'empleado',
                        'localField' => 'asignacion.empleado_id',
                        'foreignField' => '_id',
                        'as' => 'empleado'
                    ]
                ],
                ['$unwind' => '$empleado'],
                [
                    '$lookup' => [
                        'from' => 'device',
                        'localField' => 'asignacion.device_id',
                        'foreignField' => '_id',
                        'as' => 'device'
                    ]
                ],
                ['$unwind' => '$device']
            ];
            $cursor = $this->collection->aggregate($pipeline, []);
            $notificaciones = $cursor->toArray();

            return $notificaciones;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
    function getNotificacionesByCliente($cliente_id)
    {
        try {
            $pipeline = [
                [
                    '$lookup' => [
                        'from' => 'tracking',
                        'localField' => 'tracking_id',
                        'foreignField' => '_id',
                        'as' => 'tracking'
                    ]
                ],
                ['$unwind' => '$tracking'],
                [
                    '$lookup' => [
                        'from' => 'asignacion',
                        'localField' => 'tracking.asignacion_id',
                        'foreignField' => '_id',
                        'as' => 'asignacion'
                    ]
                ],
                ['$unwind' => '$asignacion'],
                [
                    '$lookup' => [
                        'from' => 'empleado',
                        'localField' => 'asignacion.empleado_id',
                        'foreignField' => '_id',
                        'as' => 'empleado'
                    ]
                ],
                ['$unwind' => '$empleado'],
                [
                    '$lookup' => [
                        'from' => 'device',
                        'localField' => 'asignacion.device_id',
                        'foreignField' => '_id',
                        'as' => 'device'
                    ]
                ],
                ['$unwind' => '$device'],
                [
                    '$match' => [
                        'empleado.cliente_id' => new \MongoDB\BSON\ObjectId($cliente_id)
                    ]
                ]
            ];
            $cursor = $this->collection->aggregate($pipeline, []);
            $notificaciones = $cursor->toArray();

            return $notificaciones;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
}
