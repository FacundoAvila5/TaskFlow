<?php
namespace App\Models;
use CodeIgniter\Model;

class UserAuthModel extends Model {
    protected $table = 'usuarios'; 
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nombreUsuario', 'email', 'password'];
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