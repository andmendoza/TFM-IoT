<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\DeviceModel;
use App\Models\EmpleadoModel;
use App\Models\NotificacionModel;

helper('inflector');

class Home extends BaseController
{
	public function index()
	{

		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dashboard']),
			'page_title' => view('partials/page-title', ['title' => 'Dashboard', 'pagetitle' => 'Minible'])
		];
		$modelCliente = model(ClienteModel::class);
		$modelDevice = model(DeviceModel::class);
		$modelNotificaciones = model(NotificacionModel::class);
		$modelEmpleado = model(EmpleadoModel::class);
		$empleados = $modelEmpleado->getEmpleados();
		$desde = date('2018-01-01');
		$hasta = date('Y-m-d');
		$empleadoNotificacionesPorFecha = [];
		foreach($empleados as $document){
			$resultados = $modelNotificaciones->getNotificacionesDesdeHasta($document['_id'],$desde,$hasta);
			if(count($resultados)>0){
				$temporal = [];
				foreach($resultados as $row){
					$temporal[] = [
						'date' => $row['_id']['fecha'],
						'counter' => $row['count'],
					];
				}
				$dataGraph = [
					'name' => $document['nombres'].' '.$document['apellidos'],
					'data' => $temporal
				];
				$empleadoNotificacionesPorFecha[] = $dataGraph;
			}
		}
		$data['empleadoNotificacionesPorFecha'] = json_encode($empleadoNotificacionesPorFecha);

        $data['count_clientes'] = count($modelCliente->getClientes());
		$data['count_devices'] = count($modelDevice->getDevices());
		$data['count_notificaciones'] = count($modelNotificaciones->getNotificacionesAll());
		$data['count_empleados'] = count($empleados);
		$data['notificaciones'] = $modelNotificaciones->getNotificacionesAll();
        
		return view('sitio/index', $data);
	}

	public function show_layouts_horizontal()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Horizontal']),
			'page_title' => view('partials/page-title', ['title' => 'Horizontal', 'pagetitle' => 'Layouts'])
		];
		return view('layouts-horizontal', $data);
	}

	public function show_layouts_vertical()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Vertical Layout']),
			'page_title' => view('partials/page-title', ['title' => 'Vertical', 'pagetitle' => 'Layouts'])
		];
		return view('layouts-vertical', $data);
	}

	public function show_layouts_dark_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dark Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Dark Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-dark-sidebar', $data);
	}

	public function show_layouts_hori_topbar_dark()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Dark Topbar']),
			'page_title' => view('partials/page-title', ['title' => 'Dark Topbar', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-topbar-dark', $data);
	}

	public function show_layouts_hori_boxed_width()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed Width']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed Width', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-boxed-width', $data);
	}

	public function show_layouts_hori_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'pagetitle' => 'Horizontal'])
		];
		return view('layouts-hori-preloader', $data);
	}

	public function show_layouts_compact_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Compact Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Compact Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-compact-sidebar', $data);
	}

	public function show_layouts_icon_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Icon Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Icon Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-icon-sidebar', $data);
	}

	public function show_layouts_boxed()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Boxed Width']),
			'page_title' => view('partials/page-title', ['title' => 'Boxed Width', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-boxed', $data);
	}

	public function show_layouts_preloader()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Preloader']),
			'page_title' => view('partials/page-title', ['title' => 'Preloader', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-preloader', $data);
	}

	public function show_layouts_colored_sidebar()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Colored Sidebar']),
			'page_title' => view('partials/page-title', ['title' => 'Colored Sidebar', 'pagetitle' => 'Vertical'])
		];
		return view('layouts-colored-sidebar', $data);
	}
	public function tracking()
	{
		$model = model(ClienteModel::class);
		//print_r($model->getClientes());

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
	public function login()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Login'])
		];
		return view('sitio/auth-login', $data);
	}
	public function check()
	{
		$data = [
			'title_meta' => view('partials/title-meta', ['title' => 'Login'])
		];
		$validation = $this->validate([
			'username' => [
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => "Email Field Required",
					'valid_email' => "Not a valid email",
				]
			],
			'userpassword' => [
				'rules' => 'required',
				'errors' => [
					'required' => "Password Field Required"
				]
			],
		]);
		if (!$validation) {
			$data['validation'] = $this->validator;
			return redirect()->back()->with('fail', "Debe ingresar el Email y el Password");
		} else {
			$model = model(ClienteModel::class);

			$email = $this->request->getPost('username');
			$password = sha1($this->request->getPost('userpassword'));
			$userInfo = $model->getValidCliente($email, $password);
			if ($userInfo) {
				session()->set('loggedUserId', $userInfo['_id']);
				session()->set('loggedUserFullName', $userInfo['nombre']);
				session()->set('loggedUserIsAdmin', $userInfo['is_admin']);
				return redirect()->to('/');
			} else {
				return redirect()->back()->with('fail', "No existe el usuario revise que el correo y la contraseña son correctas");
			}
		}
	}
	public function logout()
	{
		session()->remove('loggedUserId');
		session()->remove('loggedUserFullName');
		session()->remove('loggedUserIsAdmin');
		return redirect()->to('login');
	}
}
