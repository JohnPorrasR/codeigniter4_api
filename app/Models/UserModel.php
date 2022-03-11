<?php 

namespace App\Models;
  
use CodeIgniter\Model;
  
class UserModel extends Model
{
	protected $DBGroup	  = 'default';
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields    = true;

    protected $allowedFields = ['nombre','email', 'clave'];
	
	protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
	// protected $createdField  = 'created_at';
	// protected $updatedField  = 'updated_at';
	// protected $deletedField  = 'deleted_at';

	protected $validationRules    = [
        'usuario' => 'required',
        'email'   => 'required|valid_email|is_unique[usuarios.email]',
        'clave'   => 'required|min_length[8]'
	];
	protected $validationMessages = [		
        'email'        => [
            'is_unique' => 'El correo ya esta registrado.',
        ],
	];
	protected $skipValidation     = false;
	
}
