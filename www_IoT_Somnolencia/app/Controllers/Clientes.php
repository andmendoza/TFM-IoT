<?php

namespace App\Controllers;

use App\Models\AsignacionModel;
use App\Models\ClienteModel;
use App\Models\DeviceModel;
use App\Models\EmpleadoModel;
use App\Models\NotificacionModel;
use CodeIgniter\Controller;

helper('inflector');
class Clientes extends BaseController
{
    public function index()
    {
        // Retrieve all posts and display them
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
            'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Listado de Clientes'])
        ];
        $modelCliente = model(ClienteModel::class);
        $data['documentos'] = $modelCliente->getClientes();
        return view('sitio/clientes-dataview', $data);
    }
    public function new()
    {
        // Display the form to create a new post
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
            'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Agregar Cliente'])
        ];
        return view('sitio/clientes-addform', $data);
    }
    public function create()
    {
        // Display the form to create a new post
        helper(['form']);

        $request = service('request');
        $rules = [
            'nombre' => [
                'label' => 'nombre',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],
            'direccion' => [
                'label' => 'direccion',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],
            'email' => [
                'label' => 'email',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],
            'telefono' => [
                'label' => 'telefono',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],
            'password' => [
                'label' => 'password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],

        ];
        $data = $this->request->getPost();
        if ($this->validate($rules)) {
            $modelCliente = model(ClienteModel::class);
            $cliente_email = $modelCliente->getEmailExist($data['email']);
            if (!$cliente_email) {
                $tranret = $modelCliente->insertCliente(
                    $data['nombre'],
                    $data['direccion'],
                    $data['email'],
                    $data['telefono'],
                    sha1($data['password'])
                );
                if ($tranret) {
                    session()->setFlashdata('success', 'Se guardo correctamente');
                    return redirect()->to('clientes');
                } else {
                    $data = [
                        'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
                        'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Agregar Cliente'])
                    ];
                    session()->setFlashdata('failed', '¡Falló! No se puede guardar intentelo mas tarde.');
                    return view('sitio/clientes-addform', $data);
                }
            } else {
                $data = [
                    'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
                    'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Agregar Cliente'])
                ];
                session()->setFlashdata('failed', '¡Falló! No puede repetir el email.');
                return view('sitio/clientes-addform', $data);
            }
        } else {
            $data = [
                'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
                'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Agregar Cliente'])
            ];
            $data['errors'] = $this->validator->getErrors();
            session()->setFlashdata('failed', '¡Falló! Error al agregar un nuevo cliente.');
            return view('sitio/clientes-addform', $data);
        }
    }


    public function show($id)
    {
        // Retrieve and display a specific post
        $modelCliente = model(ClienteModel::class);
        $currentRow = $modelCliente->getCliente($id);
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Clientes']),
            'page_title' => view('partials/page-title', ['title' => 'Clientes', 'pagetitle' => 'Administrar Cliente'])
        ];
        $data['currentRow'] = $currentRow;

        $modelNotificaciones = model(NotificacionModel::class);
        $data['listadoNotificaciones'] = $modelNotificaciones->getNotificacionesByCliente($id);
        return view('sitio/clientes-showform', $data);
    }

    public function edit($id)
    {
        // Display the form to edit a specific post
    }

    public function update($id)
    {
        // Update the specified post
    }

    public function delete($id)
    {
        // Delete the specified post
    }
    public function empleados($cliente_id)
    {
        $modelEmpleado = model(EmpleadoModel::class);
        $documentos = $modelEmpleado->getEmpleadosByClient($cliente_id);
        $salida = '';
        foreach ($documentos as $documento) {
            $imagen = '';
            $path =  SERVER_BASE . $documento['imagen'];
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $imagen = "<img src='$base64' width='50px'>";
            }
            $salida .= "<tr>";
            $salida .= "<td>{$documento['apellidos']} {$documento['nombres']}</td>";
            $salida .= "<td>{$documento['email']}</td>";
            $salida .= "<td>{$imagen}</td>";
            $salida .= "<td>{$documento['estado']}</td>";
            $salida .= "<td></td>";
            $salida .= "</tr>";
        }
        echo $salida;
    }
    public function asignaciones($cliente_id)
    {
        $modelAsignacion = model(AsignacionModel::class);
        $documentos = $modelAsignacion->getAsignacionesByClient($cliente_id);
        $salida = '';
        foreach ($documentos as $documento) {
            $salida .= "<tr>";
            $salida .= "<td>{$documento['empleado']['apellidos']} {$documento['empleado']['nombres']}</td>";
            $salida .= "<td>{$documento['device']['nombre']}</td>";
            $salida .= "<td>{$documento['device']['ubicacion']}</td>";
            $salida .= "<td>{$documento['estado']}</td>";
            $salida .= "<td nowrap><a class='btn btn-info' onclick='loadTracking(\"{$documento['_id']}\")'>LOG TRACKING</a>
            <a class='btn btn-info' onclick='verremoto(\"{$documento['device']['_id']}\")'>REMOTO</a>
            </td>";
            $salida .= "</tr>";
        }
        echo $salida;
    }
    public function asignaciones_tracking($cliente_id, $asignacion_id)
    {
        $data = [
            'title_meta' => view('partials/title-meta', ['title' => 'Tracking']),
            'page_title' => view('partials/page-title', ['title' => 'Tracking', 'pagetitle' => 'Ver Tracking'])
        ];
        //$cliente = new Client("mongodb://localhost:27017");
        $cliente = $this->mongdbcliente;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $perPage = 100;
        $skip = ($page - 1) * $perPage;
        $collection = $cliente->iotonrumbo->tracking;
        $documentos = $collection->aggregate([
            ['$lookup' => [
                'from' => 'asignacion',
                'localField' => 'asignacion_id',
                'foreignField' => '_id',
                'as' => 'asignacion'
            ]],
            ['$unwind' => '$asignacion'],
            ['$lookup' => [
                'from' => 'device',
                'localField' => 'asignacion.device_id',
                'foreignField' => '_id',
                'as' => 'asignacion.device'
            ]],
            ['$unwind' => '$asignacion.device'],
            ['$lookup' => [
                'from' => 'empleado',
                'localField' => 'asignacion.empleado_id',
                'foreignField' => '_id',
                'as' => 'asignacion.empleado'
            ]],
            ['$unwind' => '$asignacion.empleado'],
            ['$sort' => ['_id' => -1]],
            ['$skip' => $skip],
            ['$limit' => $perPage]
        ]);

        /* $documentos = $collection->find([], [
			'limit' => $perPage,
			'skip' => $skip
		]);		
		var_dump($documentos); */
        $totalRows = $collection->countDocuments();
        $totalPages = ceil($totalRows / $perPage);
        //foreach ($documentos as $documento) {
        // Mostrar los datos del documento
        /* echo "<pre>";
			var_dump($documento);
			echo "</pre>"; */
        //}
        $data['documentos'] = $documentos;
        $data['totalPages'] = $totalPages;
        $data['page'] = $page;
        return view('sitio/tracking-dataview', $data);
    }

    public function device_online($cliente_id, $device_id)
    {
        $modelDevice = model(DeviceModel::class);
        $currentDevice = $modelDevice->getDevice($device_id);
        $data['currentRow'] = $currentDevice;
        $data['cliente_id'] = $cliente_id;
        return view('sitio/device-online', $data);
    }
    public function device_getimagen($cliente_id, $device_id)
    {
        $modelDevice = model(DeviceModel::class);
        $currentDevice = $modelDevice->getDevice($device_id);

        $existImagen =  IMAGES_BASE . $currentDevice['serie'] . '/remote_image_last_fd.jpg';
        if (file_exists($existImagen)) {
            $latestFile = $existImagen;
        }

        if ($latestFile == "") {
            $imagePath = IMAGES_BASE . 'noimage.jpg';
        } else {
            $imagePath = $latestFile;
        }
        //echo $imagePath;
        //die;

        // Create a new Response instance

        // Set the image file as the response body
        $this->response->setBody(file_get_contents($imagePath));

        // Set the custom headers
        $this->response->setHeader('Content-Type', 'image/jpeg');
        $this->response->setHeader('Content-Disposition', 'inline; filename=image.jpg');

        // Return the response
        return $this->response;
    }
}
