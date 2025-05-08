<?php

namespace App\Controllers;
use App\Models\TaskModel;

class Task extends BaseController
{
    public function __construct() {
        helper(['form']);
    }
    
    public function index()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión');
        }

        $userId = session()->get('user_id');
        
        $taskModel = new TaskModel();
        $tasks = $taskModel->where('userId', $userId)
                        ->orderBy('prioridad', 'DESC')
                        ->orderBy('fechaVencimiento', 'ASC')
                        ->findAll();

        $data = [
            'title' => 'Mis Tareas',
            'tasks' => $tasks 
        ];
        
        return view('index', $data);
    }

    public function create()
    {
        $validacion = service('validation');
        $validacion->setRules(
            [
                'asunto' => 'required|min_length[3]|max_length[255]',
                'descripcion' => 'required|max_length[255]',
                'prioridad' => 'required',
                'vencimiento' => 'required|valid_date',
                'color' => 'required'
            ],
            [
                'asunto' => [
                    'required' => 'El asunto es requerido',
                    'min_length' => 'El asunto debe tener al menos 3 caracteres',
                    'max_length' => 'El asunto no debe exceder los 255 caracteres'
                ],
                'descripcion' => [
                    'required' => 'La descripción es requerida',
                    'max_length' => 'La descripción no debe exceder los 255 caracteres'
                ],
                'prioridad' => [
                    'required' => 'La prioridad es requerida'
                ],
                'vencimiento' => [
                    'required' => 'La fecha de vencimiento es requerida',
                    'valid_date' => 'La fecha de vencimiento no es válida'
                ],
                'color' => [
                    'required' => 'El color es requerido'
                ]
            ]
        );

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validacion->getErrors());
        }

        $userId = session()->get('user_id');

        $taskModel = new TaskModel();
        $taskModel->save([
            'userId' => $userId,
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'fechaVencimiento' => $this->request->getPost('vencimiento'),
            'fechaRecordatorio' => $this->request->getPost('vencimiento'),
            'color' => $this->request->getPost('color'),
            'estatus' => 0,
            'archivada' => false
        ]);

        return redirect()->back()->with('success', 'Tarea creada exitosamente!');
    }

    public function update($id = null){
        $validacion = service('validation');
        $validacion->setRules(
            [
                'asunto' => 'required|min_length[3]|max_length[255]',
                'descripcion' => 'required|max_length[255]',
                'prioridad' => 'required',
                'vencimiento' => 'required|valid_date',
                'color' => 'required'
            ],
            [
                'asunto' => [
                    'required' => 'El asunto es requerido',
                    'min_length' => 'El asunto debe tener al menos 3 caracteres',
                    'max_length' => 'El asunto no debe exceder los 255 caracteres'
                ],
                'descripcion' => [
                    'required' => 'La descripción es requerida',
                    'max_length' => 'La descripción no debe exceder los 255 caracteres'
                ],
                'prioridad' => [
                    'required' => 'La prioridad es requerida'
                ],
                'vencimiento' => [
                    'required' => 'La fecha de vencimiento es requerida',
                    'valid_date' => 'La fecha de vencimiento no es válida'
                ],
                'color' => [
                    'required' => 'El color es requerido'
                ]
            ]
        );

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validacion->getErrors());
        }

        $userId = session()->get('user_id');

        $taskModel = new TaskModel();
        $taskModel->update($id, [
            'userId' => $userId,
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'fechaVencimiento' => $this->request->getPost('vencimiento'),
            'fechaRecordatorio' => $this->request->getPost('vencimiento'),
            'color' => $this->request->getPost('color'),
            'estatus' => 0,
            'archivada' => false
        ]);

        return redirect()->back()->with('success', 'Tarea creada exitosamente!');
    }

    public function delete($id = null){
        $taskModel = new TaskModel();
        $taskModel->delete($id);

        return redirect()->back()->with('success', 'Tarea creada exitosamente!');
    }
}