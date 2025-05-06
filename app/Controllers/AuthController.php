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
            
            // Opcional: Puedes agregar un mensaje de éxito
            session()->setFlashdata('success', 'Registro exitoso. Por favor inicie sesión.');
            
            // Redirigir al login después del registro exitoso
            return redirect()->to('login');
            
        } catch (\Exception $e) {
            // Manejar errores de base de datos
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
    
        // Buscar usuario por email
        $user = $userModel->where('email', $email)->first();
    
        // Validación unificada de credenciales
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Credenciales incorrectas. Verifique su email y contraseña');
        }
    
        // Autenticación exitosa
        $sessionData = [
            'user_id' => $user['id'],
            'nombre' => $user['nombreUsuario'],
            'email' => $user['email'],
            'logged_in' => true
        ];
        session()->set($sessionData);
    
        return redirect()->to('home');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('login');
    }
}