<?php

namespace App\Controllers;

class Task extends BaseController
{
    public function __construct() {
        helper(['form']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Mis Tareas'
        ];
        
        return view('index', $data);
    }
}