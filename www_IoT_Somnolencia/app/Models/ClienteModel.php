<?php
namespace App\Models;
use App\Libraries\DatabaseConnector;
class ClienteModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->cliente;
    }
    function getClientes($limit = 100) {
        try {
            $cursor = $this->collection->find([], ['limit' => $limit]);
            $clientes = $cursor->toArray();

            return $clientes;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching books: ' . $ex->getMessage(), 500);
        }
    }
    function getCliente($id) {
        try {
            $cliente = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);

            return $cliente;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }
    function getValidCliente($email, $password){
        try {
            $cliente = $this->collection->findOne(['email' => $email,'password'=>$password]);
            return $cliente;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }
    function getEmailExist($email){
        try {
            $cliente = $this->collection->findOne(['email' => $email]);
            return $cliente;
        } catch(\MongoDB\Exception\RuntimeException $ex) {
            show_error('Error while fetching book with ID: ' . $id . $ex->getMessage(), 500);
        }
    }
    function insertCliente($nombre, $direccion, $email,$telefono,$password) {
        try {
            $insertOneResult = $this->collection->insertOne([
                'nombre' => $nombre,
                'direccion' => $direccion,
                'email' => $email,
                'telefono' => $telefono,
                'password' => $password,
                'is_admin' => 'no'
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