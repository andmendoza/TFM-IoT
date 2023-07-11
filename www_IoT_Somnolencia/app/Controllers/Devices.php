<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\DeviceModel;

helper('inflector');

class Devices extends BaseController
{
	public function index()
	{

		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dispositivos']),
			'page_title' => view('partials/page-title', ['title' => 'Dispositivos', 'pagetitle' => 'Listado'])
		];
        $modelDevice = model(DeviceModel::class);
        $data['documentos'] = $modelDevice->getDevices();
        return view('sitio/devices-dataview', $data);
	}
    public function new()
	{

		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dispositivos']),
			'page_title' => view('partials/page-title', ['title' => 'Dispositivos', 'pagetitle' => 'Agregar'])
		];
        return view('sitio/devices-addform', $data);
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
            'ubicacion' => [
                'label' => 'ubicacion',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],
            'serie' => [
                'label' => 'serie',
                'rules' => 'required',
                'errors' => [
                    'required' => 'El campo es obligatorio',
                ]
            ],

        ];
        $data = $this->request->getPost();
        if ($this->validate($rules)) {
            $modelDevices = model(DeviceModel::class);
            $cliente_email = $modelDevices->getDeviceSerieExist($data['serie']);
            if (!$cliente_email) {
                $tranret = $modelDevices->insertDevice(
                    $data['nombre'],
                    $data['ubicacion'],
                    $data['serie']
                );
                if ($tranret) {
                    session()->setFlashdata('success', 'Se guardo correctamente');
                    return redirect()->to('devices');
                } else {
                    $data = [
                        'title_meta' => view('partials/title-meta', ['title' => 'Dispositivos']),
                        'page_title' => view('partials/page-title', ['title' => 'Dispositivos', 'pagetitle' => 'Agregar'])
                    ];
                    session()->setFlashdata('failed', '¡Falló! No se puede guardar intentelo mas tarde.');
                    return view('sitio/devices-addform', $data);
                }
            } else {
                $data = [
                    'title_meta' => view('partials/title-meta', ['title' => 'Dispositivos']),
                    'page_title' => view('partials/page-title', ['title' => 'Dispositivos', 'pagetitle' => 'Agregar'])
                ];
                session()->setFlashdata('failed', '¡Falló! No puede repetir la serie.');
                return view('sitio/devices-addform', $data);
            }
        } else {
            $data = [
                'title_meta' => view('partials/title-meta', ['title' => 'Dispositivos']),
                'page_title' => view('partials/page-title', ['title' => 'Dispositivos', 'pagetitle' => 'Agregar'])
            ];
            $data['errors'] = $this->validator->getErrors();
            session()->setFlashdata('failed', '¡Falló! Error al agregar un nuevo dispositivo.');
            return view('sitio/devices-addform', $data);
        }
    }
}