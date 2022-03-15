<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Login extends ResourceController
{	
    use ResponseTrait;
    public function index()
    {
        $userModel = new UserModel();
  
        $email = $this->request->getVar('email');
        $clave = $this->request->getVar('clave');
          
        $user = $userModel->where('email', $email)->first();
  
        if(is_null($user)) {
            return $this->respond(['error' => 'Invalido email or clave.'], 401);
        }
  
        $pwd_verify = password_verify($clave, $user['clave']);
  
        if(!$pwd_verify) {
            return $this->respond(['error' => 'Clave invalida.'], 401);
        }
 
        $key = getenv('TOKEN_SECRET');
		
        $iat = time();
        $exp = $iat + 3600;
 
        $payload = array(
            "iat" => $iat,
            "exp" => $exp,
            "data" => $user['email'],
        );
         
        $token = JWT::encode($payload, $key, 'HS256');
 
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];
         
        return $this->respond($response, 200);
    }
}
