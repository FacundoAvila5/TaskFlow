<?php
namespace App\Models;
use CodeIgniter\Model;

class ColaboracionModel extends Model {
    protected $table = 'colaboraciones'; 
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true; 
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['userId', 'tareaId', 'invitacionAceptada'];
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