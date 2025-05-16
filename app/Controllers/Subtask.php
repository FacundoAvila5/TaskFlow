<?php

namespace App\Controllers;
use App\Models\TaskModel;
use App\Models\SubtaskModel;

class Subtask extends BaseController
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
        $subtaskModel = new SubtaskModel(); // Asegúrate de que el namespace sea correcto
        
        // Obtener todas las tareas del usuario
        $tasks = $taskModel->where('userId', $userId)
                        ->orderBy('prioridad', 'DESC')
                        ->orderBy('fechaVencimiento', 'ASC')
                        ->findAll();

        // Para cada tarea, obtener sus subtareas relacionadas
        foreach ($tasks as &$task) {
            $subtasks = $subtaskModel->where('tareaId', $task['id'])
                                    ->orderBy('prioridad', 'DESC')
                                    ->orderBy('fechaVencimiento', 'ASC')
                                    ->findAll();
            
            // Mapear los campos para que coincidan con lo que espera la vista
            $task['subtasks'] = array_map(function($subtask) {
                return [
                    'id' => $subtask['id'],
                    'title' => $subtask['asunto'],
                    'description' => $subtask['descripcion'],
                    'completed' => ($subtask['estatus'] == 1), // Asumiendo que estatus 1 es completado
                    'prioridad' => $subtask['prioridad'],
                    'fechaVencimiento' => $subtask['fechaVencimiento']
                ];
            }, $subtasks);
        }

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
                ]
            ]
        );

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validacion->getErrors());
        }

        $userId = session()->get('user_id');

        $taskModel = new SubtaskModel();
        $taskModel->save([
            'tareaId' => $this->request->getPost('task_id'),
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'fechaVencimiento' => $this->request->getPost('vencimiento'),
            'fechaRecordatorio' => $this->request->getPost('vencimiento'),
            'estatus' => 2,
            'responsableId' => $this->request->getPost('responsable')
        ]);

        return redirect()->back()->with('success', 'Subtarea creada exitosamente!');
    }

    public function update($id = null){
        //   var_dump($this->request->getPost()); 


        $validacion = service('validation');
        $validacion->setRules(
            [
                'asunto' => 'required|min_length[3]|max_length[255]',
                'descripcion' => 'required|max_length[255]',
                'prioridad' => 'required',
                'vencimiento' => 'required|valid_date',
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
                ]
            ]
        );

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validacion->getErrors());
        }

        $userId = session()->get('user_id');

        $taskModel = new SubtaskModel();
        $taskModel->update($id, [
            'tareaId' => $this->request->getPost('task_id'),
            'asunto' => $this->request->getPost('asunto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'prioridad' => $this->request->getPost('prioridad'),
            'fechaVencimiento' => $this->request->getPost('vencimiento'),
            'fechaRecordatorio' => $this->request->getPost('vencimiento'),
            'estatus' => 2,
            'responsableId' => $this->request->getPost('responsable')
        ]);

        return redirect()->back()->with('success', 'Subtarea actualizada exitosamente!');
    }

    public function delete($id = null){
        $taskModel = new SubtaskModel();
        $taskModel->delete($id);

        return redirect()->back()->with('success', 'Subarea eliminada exitosamente!');
    }
}