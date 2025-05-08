<?php
namespace App\Models;
use CodeIgniter\Model;

class TaskModel extends Model {
    protected $table = 'tareas'; 
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['userId', 'asunto', 'descripcion', 'prioridad', 'estatus', 'fechaVencimiento', 'fechaRecordatorio', 'color', 'archivada'];
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $validationRules = []; 
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;
}