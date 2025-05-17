<?php

namespace App\Controllers;
use App\Models\TaskModel;
use App\Models\SubtaskModel;
use App\Models\UserAuthModel;
use App\Models\ColaboracionModel;

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
        $subtaskModel = new SubtaskModel();
        $userAuthModel = new UserAuthModel();
        $colaboradorModel = new ColaboracionModel();

        $tareasColaboracion = $colaboradorModel
            ->where('userId', $userId)
            ->where('invitacionAceptada', true)
            ->findAll();
        
        $tareaIdsColaboracion = array_column($tareasColaboracion, 'tareaId');
        
        $priority = $this->request->getGet('priority');
        $status = $this->request->getGet('status');

        $builder = $taskModel->where('archivada', false);

        if (!empty($tareaIdsColaboracion)) {
            $builder->groupStart()
                    ->where('userId', $userId)
                    ->orWhereIn('id', $tareaIdsColaboracion)
                    ->groupEnd();
        } else {
            $builder->where('userId', $userId);
        }
        
        if ($priority !== null && $priority !== '') {
            $builder->where('prioridad', $priority);
        }
        
        if ($status !== null && $status !== '') {
            $builder->where('estatus', $status);
        }
        
        
        $tasks = $builder->orderBy('fechaVencimiento', 'ASC')
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
                    'fechaVencimiento' => $subtask['fechaVencimiento'],
                    'responsableId' => $subtask['responsableId'],
                ];
            }, $subtasks);
        }

        $users = $userAuthModel->findAll();

        $data = [
            'title' => 'Mis Tareas',
            'tasks' => $tasks,
            'users' => $users,
            'currentPriority' => $priority,
            'currentStatus' => $status
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
                'recordatorio' => 'permit_empty|valid_date',
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

        $target = 'createTask';

         if ($this->request->getPost('recordatorio')) {
            $recordatorio = $this->request->getPost('recordatorio');
            $vencimiento = $this->request->getPost('vencimiento');
            $hoy = date('Y-m-d');

            $errores = [];

            if ($vencimiento < $hoy) {
                $errores['vencimiento'] = 'La fecha de recordatorio no puede ser anterior a hoy';
            }

            if ($recordatorio < $hoy) {
                $errores['recordatorio'] = 'La fecha de recordatorio no puede ser anterior a hoy';
            }

            if ($recordatorio > $vencimiento) {
                $errores['recordatorio'] = 'La fecha de recordatorio no puede ser posterior a la fecha de vencimiento';
            }

            if (!empty($errores)) {
                return redirect()->back()
                    ->withInput()
                    ->with('modalTarget', $target)
                    ->with('errors', $errores);
            }
        }

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('modalTarget', $target)
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
            'fechaRecordatorio' => $this->request->getPost('recordatorio') ?: null,
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
                'recordatorio' => 'permit_empty|valid_date',
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

        $target = 'editTask-'. $id;

         if ($this->request->getPost('recordatorio')) {
            $recordatorio = $this->request->getPost('recordatorio');
            $vencimiento = $this->request->getPost('vencimiento');
            $hoy = date('Y-m-d'); 

           $errores = [];

            if ($recordatorio < $hoy) {
                $errores['recordatorio'] = 'La fecha de recordatorio no puede ser anterior a hoy';
            }

            if ($recordatorio > $vencimiento) {
                $errores['recordatorio'] = 'La fecha de recordatorio no puede ser posterior a la fecha de vencimiento';
            }

            if (!empty($errores)) {
                return redirect()->back()
                    ->withInput()
                    ->with('modalTarget', $target)
                    ->with('errors', $errores);
            }
        }

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->withInput()
                ->with('modalTarget', $target)
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
            'fechaRecordatorio' => $this->request->getPost('recordatorio') ?: null,
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

    public function invite($taskId)
    {
        $taskModel = new TaskModel();
        $task = $taskModel->find($taskId);
        
        if (!$task) {
            return redirect()->back()->with('error', 'La tarea no existe');
        }

        $validacion = service('validation');
        $validacion->setRules(
            [
                'email' => 'required|valid_email',
                'task_id' => 'required|is_natural_no_zero'
            ],
            [
                'email' => [
                    'required' => 'El email es requerido',
                    'valid_email' => 'Debe ingresar un email válido'
                ],
                'task_id' => [
                    'required' => 'ID de tarea requerido',
                    'is_natural_no_zero' => 'ID de tarea inválido'
                ]
            ]
        );

        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('errors', $validacion->getErrors())
                ->with('modalTarget', 'invitarColaboradores-'.$taskId);
        }

        $email = $this->request->getPost('email');
        $errors = [];

        $userModel = new UserAuthModel();
        $invitedUser = $userModel->where('email', $email)->first();

        if (!$invitedUser) {
            $errors['email'] = 'No existe un usuario con ese email';
        }
        elseif ($invitedUser['id'] == $task['userId']) {
            $errors['email'] = 'No puedes invitarte a ti mismo';
        }
        else {
            $colaboracionModel = new ColaboracionModel();
            $existingInvitation = $colaboracionModel
                ->where('tareaId', $taskId)
                ->where('userId', $invitedUser['id'])
                ->first();

            if ($existingInvitation) {
                $errors['email'] = 'Este usuario ya fue invitado a la tarea';
            }
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->with('errors', $errors)
                ->with('modalTarget', 'invitarColaboradores-'.$taskId);
        }
        
        $invitationData = [
            'tareaId' => $taskId,
            'userId' => $invitedUser['id'],
            'invitacionAceptada' => false,
        ];

        $colaboracionModel->insert($invitationData);

        $this->sendInvitationEmail($email, $task);

        return redirect()->back()
            ->with('success_invitation', 'Invitación enviada correctamente a '.$email);
    }

    protected function sendInvitationEmail($email, $task)
    {
        $emailService = \Config\Services::email();
        $userModel = new UserAuthModel();
        $colaboracionModel = new ColaboracionModel();
        
        $inviter = $userModel->find(session('user_id'));
        
        $colaboracion = $colaboracionModel
            ->where('tareaId', $task['id'])
            ->where('userId', $userModel->where('email', $email)->first()['id'])
            ->orderBy('id', 'DESC')
            ->first();

        $acceptLink = site_url("task/aceptar_invitacion/{$colaboracion['id']}");
        $rejectLink = site_url("task/rechazar_invitacion/{$colaboracion['id']}");
        
        $message = '
        <p>Hola,</p>
        <p>Has sido invitado a colaborar en la tarea: <strong>'.$task['asunto'].'</strong></p>
        
        <p>
            <a href="'.$acceptLink.'" style="
                background: #28a745;
                color: white;
                padding: 5px 10px;
                text-decoration: none;
                border-radius: 3px;
                margin-right: 5px;
            ">Aceptar</a>
            
            <a href="'.$rejectLink.'" style="
                background: #dc3545;
                color: white;
                padding: 5px 10px;
                text-decoration: none;
                border-radius: 3px;
            ">Rechazar</a>
        </p>
        
        <p>Saludos,<br>TaskFlow</p>';

        $emailService->setTo('facuaviila5@outlook.com');
        $emailService->setFrom('facuaviila5@outlook.com', 'Sistema de Tareas');
        $emailService->setSubject("Invitación a tarea: {$task['asunto']}");
        $emailService->setMessage($message);
        $emailService->setMailType('html'); 
        
        return $emailService->send();
    }

    public function aceptar_invitacion($colaboracionId)
    {
        $colaboracionModel = new ColaboracionModel();
        
        $updated = $colaboracionModel->update($colaboracionId, [
            'invitacionAceptada' => true
        ]);

        return redirect()->to("/index")
            ->with('success', '¡Has aceptado la invitación!');
    }

    public function rechazar_invitacion($colaboracionId)
    {
        $colaboracionModel = new ColaboracionModel();
        
        $updated = $colaboracionModel->update($colaboracionId, [
            'invitacionAceptada' => false,
        ]);
        
        return redirect()->to('/index"')
            ->with('success', 'Has rechazado la invitación');
    }

    public function archivadas()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('login')->with('error', 'Debes iniciar sesión');
        }

        $taskModel = new TaskModel();
        $subtaskModel = new SubtaskModel();

        $archivadas = $taskModel->where('userId', session()->get('user_id'))
                            ->groupStart()
                                ->where('archivada', true)
                                ->orWhere('estatus', 1) 
                            ->groupEnd()
                            ->findAll();

        if (empty($archivadas)) {
            return view('archivadas', [
                'tasks' => [],
                'title' => 'Tareas Archivadas'
            ]);
        }

        $taskIds = array_column($archivadas, 'id');
        
        $subtasks = $subtaskModel->whereIn('tareaId', $taskIds)
                            ->findAll();

        $subtasksByTask = [];
        foreach ($subtasks as $subtask) {
            $subtasksByTask[$subtask['tareaId']][] = $subtask;
        }

        foreach ($archivadas as &$task) {
            $task['subtasks'] = $subtasksByTask[$task['id']] ?? [];
        }

        return view('archivadas', [
            'tasks' => $archivadas,
            'title' => 'Tareas Archivadas'
        ]);
    }

    public function archivar($taskId)
    {
        $taskModel = new TaskModel();
        
        $task = $taskModel->find($taskId);
        if (!$task || $task['estatus'] != 1) { 
            return redirect()->back()->with('error', 'Solo puedes archivar tareas completadas');
        }
        
        $taskModel->update($taskId, [
            'archivada' => true,
        ]);
        
        return redirect()->to('/archivadas')
            ->with('success', 'Has rechazado la invitación');
    }
}