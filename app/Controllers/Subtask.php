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
        $subtaskModel = new SubtaskModel(); 
        
        $tasks = $taskModel->where('userId', $userId)
                        ->orderBy('prioridad', 'DESC')
                        ->orderBy('fechaVencimiento', 'ASC')
                        ->findAll();

        foreach ($tasks as &$task) {
            $subtasks = $subtaskModel->where('tareaId', $task['id'])
                                    ->orderBy('prioridad', 'DESC')
                                    ->orderBy('fechaVencimiento', 'ASC')
                                    ->findAll();
            
            $task['subtasks'] = array_map(function($subtask) {
                return [
                    'id' => $subtask['id'],
                    'title' => $subtask['asunto'],
                    'description' => $subtask['descripcion'],
                    'completed' => ($subtask['estatus'] == 1), 
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

        $target = 'createSubtask';

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('modalTarget', $target)
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

        $target = 'editSubtask-'. $id;

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('modalTarget', $target)
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

    public function updateEstado()
    {
        $subtaskModel = new SubtaskModel();
        $taskModel = new TaskModel();
        $taskId = $this->request->getPost('task_id');
        $completedSubtasks = $this->request->getPost('completed') ?? [];

        $allSubtasks = $subtaskModel->where('tareaId', $taskId)->findAll();
        
        foreach ($allSubtasks as $subtask) {
            $completed = isset($completedSubtasks[$subtask['id']]) ? 1 : 2;
            $subtaskModel->update($subtask['id'], ['estatus' => $completed]);
        }

        $updatedSubtasks = $subtaskModel->where('tareaId', $taskId)->findAll();
        $totalSubtasks = count($updatedSubtasks);
        $completedCount = count(array_filter($updatedSubtasks, fn($st) => $st['estatus'] == 1));

        $newStatus = 0; 

        if ($completedCount > 0 && $completedCount < $totalSubtasks) {
            $newStatus = 2;
        } elseif ($completedCount == $totalSubtasks && $totalSubtasks > 0) {
            $newStatus = 1; 
        }

        $taskModel->update($taskId, ['estatus' => $newStatus]);

        return redirect()->back()->with('success', 'Estado actualizado correctamente');
    }
}