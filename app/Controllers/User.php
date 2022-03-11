<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class User extends ResourceController
{
    private $user;

	public function __construct()
	{
        $this->user = new UserModel();
	}

    public function index()
    {
		$data = $this->user->findAll();
        return $this->respond($data);
    }
	
    public function show($id = null)
    {
        $data = $this->user->find($id);
        if ($data) {
            return $this->respond($data);
        }
        return $this->failNotFound('Sorry! no data found');
    }
	
    public function create()
    {
        $validation = $this->validate([
            'nombre' => 'required',
            "email" => [
				"rules" => "required|valid_email|is_unique[usuarios.email]|min_length[6]",
				"errors" => [
					"required" => "El correo es obligatorio.",
					"is_unique" => "El correo ya esta registrado.",
					"valid_email" => "El correo no valido.",
				]
			],
            'clave' => 'required',
        ]);

        if (!$validation) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = [
            'nombre' => $this->request->getVar('nombre'),
            'email' => $this->request->getVar('email'),
            'clave' => $this->request->getVar('clave')
        ];

        $userId = $this->user->save($userData);
        if ($userId) {
            $userData['id'] = $userId;
            return $this->respondCreated($userData);
        }
        return $this->fail('Sorry! no student created');
    }
	
    public function update($id = null)
    {
        $user = $this->user->find($id);
        if ($user) {

            $validation = $this->validate([
                'nombre' => 'required',
                "email" => "required|valid_email",
                'clave' => 'required',
            ]);

            if (!$validation) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $user = [
                'id' => $id,
                'nombre' => $this->request->getVar('nombre'),
                'email' => $this->request->getVar('email'),
                'clave' => $this->request->getVar('clave')
            ];

            $response = $this->user->save($user);
            if ($response) {
                return $this->respond($user);
            }
            return $this->fail('Sorry! not updated');
        }
        return $this->failNotFound('Sorry! no user found');
    }
	
    public function delete($id = null)
    {
        $model = new UserModel();
        $data = $model->find($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No Data Found with id '.$id);
        }
         
    }
 
}
