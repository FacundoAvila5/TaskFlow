<?php
namespace App\Controllers;
use App\Models\UserAuthModel;

class AuthController extends BaseController {
    public function __construct() {
        helper(['form']);
    }

    public function index() {
        return view('login');
    }

    public function registerView() {
        return view('register');
    }

    public function homeView() {
        return view('home');
    }

    public function register() {
        $validacion = service('validation');
        $validacion->setRules(
            [
                'nombre' => 'required|min_length[3]|alpha_space',
                'password' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',    
                'password_confirm' => 'required|matches[password]',
                'email' => 'required|valid_email|is_unique[usuarios.email]',
            ],
            [
                'nombre' => [
                    'required' => 'Este campo es requerido', 
                    'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres'
                ],
                'password' => [
                    'required' => 'La contraseña es requerida',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres',
                    'regex_match' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial'
                ],
                'password_confirm' => [
                    'required' => 'La confirmación de la contraseña es requerida',
                    'matches' => 'Las contraseñas no coinciden'
                ],
                'email' => [
                    'required' => 'El correo es requerido',
                    'is_unique' => 'Este correo electrónico ya está registrado'
                ]
            ]
        );
        
        if (!$validacion->withRequest($this->request)->run()){
            return redirect()->back()->withInput()->with('errors',$validacion->getErrors());
        }

        $datos = array(
            'nombreUsuario'=>$this->request-> getPost('nombre'), 
            'email'=>$this->request-> getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT));

        $model = new \App\Models\UserAuthModel();

        try {
            $model->insert($datos);
            session()->setFlashdata('success', 'Registro exitoso. Por favor inicie sesión.');
        
            return redirect()->to('login');
            
        } catch (\Exception $e) {
            log_message('error', 'Error al registrar usuario: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar. Por favor intente nuevamente.');
        }
    }


    public function login() {
        $validacion = service('validation');
        $validacion->setRules([
            'user' => 'required|valid_email',
            'pass' => 'required'
        ], [
            'user' => [
                'required' => 'El correo electrónico es requerido',
                'valid_email' => 'Debe ingresar un correo electrónico válido'
            ],
            'pass' => [
                'required' => 'La contraseña es requerida'
            ]
        ]);
    
        if (!$validacion->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validacion->getErrors());
        }
    
        $userModel = new UserAuthModel();
        $email = $this->request->getPost('user');
        $password = $this->request->getPost('pass');
    
        $user = $userModel->where('email', $email)->first();
    
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas. Verifique su email y contraseña');
        }
    
        $sessionData = [
            'user_id' => $user['id'],
            'nombre' => $user['nombreUsuario'],
            'email' => $user['email'],
            'logged_in' => true
        ];
        session()->set($sessionData);
    
        return redirect()->to('index');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Has cerrado sesión correctamente');
    }

    public function actualizarContrasenia()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('login');
        }

        $userModel = new UserAuthModel();
        $user = $userModel->find(session('user_id'));

        $validation = service('validation');
        $validation->setRules([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',
            'confirm_password' => 'required|matches[new_password]'
        ], [
            'current_password' => [
                'required' => 'La contraseña actual es requerida'
            ],
            'new_password' => [
                'required' => 'La nueva contraseña es requerida',
                'min_length' => 'La contraseña debe tener al menos 8 caracteres',
                'regex_match' => 'La contraseña debe contener mayúscula, número y carácter especial'
            ],
            'confirm_password' => [
                'required' => 'Debes confirmar la nueva contraseña',
                'matches' => 'Las contraseñas no coinciden'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->with('modalTarget', 'cambiarContrasenia')
                ->withInput();
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            $validation->setError('current_password', 'La contraseña actual es incorrecta');
            return redirect()->back()
                ->with('errors', $validation->getErrors())
                ->with('modalTarget', 'cambiarContrasenia')
                ->withInput();
        }

        $userModel->update($user['id'], [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente');
    }
}